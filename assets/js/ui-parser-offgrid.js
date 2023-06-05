let calcOffGridUIParser = null;

jQuery( function( $ ) {
    class OffgridUiParser{
        #rootEl = '';
        #tblItmsEl = '';
        #cieANm = '';
        #cieQty = ''; //cie = child input element
        #ciePwr = '';
        #cieDuh = '';
        #cteKbd = ''; //cte = child TD element
        #cteKbm = '';
        #twbd   = 0; // Total Watts by day.
        #twbm   = 0; // Total Watts by month.
        #twbdEl = '';
        #nmcapEl = '';
        #brCapEl = '';
        #ha12vEl = '';
        #ha24vEl = '';
        #ha48vEl = '';
        #pPwrREl = '';
        #hspSlEl = '';
        #pc335_340wEl = '';
        #pc445_450wEl = '';
        #pc550_560wEl = '';
        #pc600_610wEl = '';
        #pc650_660wEl = '';

        #autonomia = 0;
        #dod = 0;
        #efficiency = 0;
        #peakPowerRequired = 0;
        #hsp = 0;

        #dts = {}; // data to send to emails.
        #artifacts = [];

        constructor(){
            this.#rootEl = '.rayssa-calc-offgrid';
            this.#tblItmsEl = this.#rootEl + ' table.items tbody';
            this.#cieANm = 'td[data-field="artifact"] select'
            this.#cieQty = 'td[data-field="qty"] input';
            this.#ciePwr = 'td[data-field="power"] input';
            this.#cieDuh = 'td[data-field="hours-by-day"] input';
            this.#cteKbd = 'td[data-field="kwh-by-day"] span';
            this.#cteKbm = 'td[data-field="kwh-by-month"] span';
            this.#twbdEl = this.#rootEl + ' .daylytotalKWatts span.value';
            this.#nmcapEl = this.#rootEl + ' .nominalCapacity span.value';
            this.#brCapEl = this.#rootEl + ' .bruteCapacity span.value';

            this.#ha12vEl = this.#rootEl + ' .hourly-amperage-container .amp-12v span.value';
            this.#ha24vEl = this.#rootEl + ' .hourly-amperage-container .amp-24v span.value';
            this.#ha48vEl = this.#rootEl + ' .hourly-amperage-container .amp-48v span.value';

            this.#pPwrREl = this.#rootEl + ' .peak-power-required span.value';
            this.#hspSlEl = this.#rootEl + ' .panels-calculation #region-selector';

            this.#pc335_340wEl = this.#rootEl + ' .panels-count-container .335-340w span.value';
            this.#pc445_450wEl = this.#rootEl + ' .panels-count-container .445-450w span.value';
            this.#pc550_560wEl = this.#rootEl + ' .panels-count-container .550-560w span.value';
            this.#pc600_610wEl = this.#rootEl + ' .panels-count-container .600-610w span.value';
            this.#pc650_660wEl = this.#rootEl + ' .panels-count-container .650-660w span.value';

            this.#autonomia = 2;
            this.#dod = 55/100;
            this.#efficiency = 0.86;
        }

        calculate(){
            let i = 0;
            let qty, pwr, duh;
            let currRow = null;
            let currWbd;
            let currWbm;
            let currInput;
            let nominalCap, bruteCap;
            let pcc;
            let selRegText = "Seleccionar región";
            let atfItmObj = {};

            const trs = $(this.#tblItmsEl + ' tr');
            this.#twbd = 0;
            this.#artifacts = [];
            for( i = 0; i < trs.length; i++){
                
                atfItmObj = {};
                
                currRow = trs[i];

                currInput = $(currRow).find(this.#cieANm);
                currInput = $(currInput).find(':selected');
                atfItmObj.name = $(currInput).text();
                
                currInput = $(currRow).find(this.#cieQty);
                qty = parseInt( $(currInput).val() );
                if( isNaN(qty) ){
                    qty = 0;
                }
                atfItmObj.qty = qty;

                currInput = $(currRow).find(this.#ciePwr);
                pwr = parseInt( $(currInput).val() );
                if( isNaN(pwr) ){
                    pwr = 0;
                }
                atfItmObj.pwr = pwr;

                currInput = $(currRow).find(this.#cieDuh);
                duh = parseFloat( $(currInput).val() );
                if( isNaN(duh) ){
                    duh = 0;
                }
                atfItmObj.duh = duh;
                
                currWbd = qty * pwr * duh;
                currWbm = currWbd * 30;

                atfItmObj.currWbd = currWbd;
                atfItmObj.currWbm = currWbm;
                
                this.#twbd += currWbd;
                
                $(currRow).find(this.#cteKbd).text( currWbd.toFixed(2) );
                $(currRow).find(this.#cteKbm).text( currWbm.toFixed(2) );

                this.#artifacts.push(atfItmObj);
            }

            this.#twbm = this.#twbd * 30; 
            nominalCap = this.#twbd / 1000 * this.#autonomia
            bruteCap = this.#twbd * this.#autonomia / this.#dod;
            $(this.#twbdEl).text((this.#twbd / 1000 ).toFixed(2));
            $(this.#nmcapEl).text(nominalCap.toFixed(2));
            $(this.#brCapEl).text(bruteCap.toFixed(2));

            this.#dts.totalWattsByMonth = this.#twbm;
            this.#dts.nominalCap = nominalCap;
            this.#dts.bruteCap = bruteCap;
            this.#dts.artifacts = this.#artifacts;

            // Amperaje por hora.
            $( this.#ha12vEl).text((bruteCap/12).toFixed(2));
            $( this.#ha24vEl).text((bruteCap/24).toFixed(2));
            $( this.#ha48vEl).text((bruteCap/48).toFixed(2));

            this.#dts.ha12v = bruteCap/12;
            this.#dts.ha24v = bruteCap/24;
            this.#dts.ha48v = bruteCap/48;

            this.readHsp();
            if( this.#hsp != 0 ){
                this.#peakPowerRequired = nominalCap / (this.#efficiency * this.#hsp);
                $(this.#pPwrREl).text(this.#peakPowerRequired.toFixed(2));

                pcc = this.#peakPowerRequired * 1000 / 335;
                pcc = Math.ceil( pcc );
                this.#dts.pc335_340w = pcc;
                $(this.#pc335_340wEl).text( pcc );

                pcc = this.#peakPowerRequired * 1000 / 450;
                pcc = Math.ceil( pcc );
                this.#dts.pc445_450w = pcc;
                $(this.#pc445_450wEl).text( pcc );

                pcc = this.#peakPowerRequired * 1000 / 550;
                pcc = Math.ceil( pcc );
                this.#dts.pc550_560w = pcc;
                $(this.#pc550_560wEl).text( pcc );

                pcc = this.#peakPowerRequired * 1000 / 600;
                pcc = Math.ceil( pcc );
                this.#dts.pc600_610w = pcc;
                $(this.#pc600_610wEl).text( pcc );

                pcc = this.#peakPowerRequired * 1000 / 650;
                pcc = Math.ceil( pcc );
                this.#dts.pc650_660w = pcc;
                $(this.#pc650_660wEl).text( pcc );

            } else {
                
                $(this.#pPwrREl).text( selRegText );
                $(this.#pc335_340wEl).text( selRegText );
                $(this.#pc445_450wEl).text( selRegText );
                $(this.#pc550_560wEl).text( selRegText );
                $(this.#pc600_610wEl).text( selRegText );
                $(this.#pc650_660wEl).text( selRegText );
            }
        }

        readHsp(){
            this.#hsp = parseFloat( $(this.#hspSlEl).find(":selected").val() )
            if( isNaN(this.#hsp)){
                this.#hsp = 0;
            }
            this.#dts.hsp = {
                'value' : this.#hsp,
                'region': $(this.#hspSlEl).find(":selected").text()
            };
            return this.#hsp;
        }

        getDataToSend(){
            let finantial;
            if( $('#cofg-finances').is(":checked") ){
                finantial = 'Si';
            } else {
                finantial = 'No';
            }
            this.#dts.contact = {
                'names': $('#cofg-names').val(),
                'email': $('#cofg-email').val(),
                'phone': $('#cofg-phone').val(),
                'finantial':  finantial
            };
           return this.#dts;

        }
    }

    $(document).ready(function(){
        calcOffGridUIParser = new OffgridUiParser;
    });
});