let calcOnGridUIParser = null;

jQuery( function( $ ) {
    class OngridUiParser{
        #rootEl = '';
        #tblItmsEl = '';
        #elQty = ''; 
        #elPwr = '';
        #elRegion = '';

        #elWhbd   = '';
        #elKwhbd  = '';
        #elKwhbm  = '';
        #elDiscbm = '';
        #elDiscby = '';

        #whbd       = 0; // Total Watts by day.
        #kwhbd      = 0; // Total Kilo Watts by day.
        #kwhbm      = 0; // Total Kilo Watts hour by month
        #discbm     = 0; // Discount by month.
        #discby     = 0; // Discount by year.

        #kwvalue = 0;
        #hsp = 0;

        #dts = {}; // data to send to emails.
        #artifacts = [];

        constructor( cfg ){
            this.#rootEl = '.rayssa-calc-ongrid';
            this.#tblItmsEl = this.#rootEl + ' table.items tbody';
     
            this.#elQty = this.#tblItmsEl + ' #panels-qty';
            this.#elPwr = this.#tblItmsEl + ' select#potencia';
            this.#elRegion = this.#tblItmsEl + ' select#region-selector';
            
            this.#elWhbd   = this.#rootEl + ' .dayly-wh span.value';
            this.#elKwhbd  = this.#rootEl + ' .dayly-kwh span.value';
            this.#elKwhbm  = this.#rootEl + ' .monthly-kwh span.value';
            this.#elDiscbm = this.#rootEl + ' .discount .by-month span.value';
            this.#elDiscby = this.#rootEl + ' .discount .by-year span.value';


            this.#kwvalue  = cfg.valorkw == undefined ? 200 : cfg.valorkw;
        }

        calculate(){
            let qty, pwr, region;
            let currInput, currSData;
            let selRegText = "Seleccionar región";


            currSData = $(this.#elPwr).select2('data');
            if( Array.isArray(currSData) && ( currSData.length == 1 ) && ( currSData[0].id != "" ) ){
                pwr = parseInt(currSData[0].id);
                this.#dts.pwr = currSData[0].text;
            }else{
                pwr = 0;
                this.#dts.pwr = '';
            }

            currInput = $(this.#elQty);
            qty = parseInt( $(currInput).val() );

            currSData = $(this.#elRegion).select2('data');
            if( Array.isArray(currSData) && ( currSData.length == 1 ) && ( currSData[0].id != "" ) ){
                this.#hsp = parseFloat(currSData[0].id);
                this.#dts.hsp = this.#hsp;
                this.#dts.region = currSData[0].text;
            }else{
                this.#hsp = 0;
                this.#dts.hsp = 0;
                this.#dts.region = '';
            }


            this.#whbd       = pwr * qty; // Total Watts by day.
            this.#kwhbd      = this.#whbd * this.#hsp / 1000; // Total Kilo Watts by day.
            this.#kwhbm      = this.#kwhbd * 30; // Total Kilo Watts hour by month
            this.#discbm     = this.#kwhbm * this.#kwvalue; // Discount by month.
            this.#discby     = this.#discbm * 12; // Discount by year.

            $(this.#elWhbd).text( this.#whbd.toFixed(2) );
            $(this.#elKwhbd).text( this.#kwhbd.toFixed(2) );
            $(this.#elKwhbm).text( this.#kwhbm.toFixed(2) );
            $(this.#elDiscbm).text( this.#discbm.toFixed(0) );
            $(this.#elDiscby).text( this.#discby.toFixed(0) );
            
             
            this.#dts.whbd = this.#whbd.toFixed(2);
            this.#dts.kwhbd = this.#kwhbd.toFixed(2);
            this.#dts.kwhbm = this.#kwhbm.toFixed(2);
            this.#dts.discbm = this.#discbm.toFixed(0);
            this.#dts.discby = this.#discby.toFixed(0);

            return;
              
        }

        getDataToSend(){
            let finantial;
            if( $('#cong-finances').is(":checked") ){
                finantial = 'Si';
            } else {
                finantial = 'No';
            }
            this.#dts.contact = {
                'names': $('#cong-names').val(),
                'email': $('#cong-email').val(),
                'phone': $('#cong-phone').val(),
                'finantial':  finantial
            };
           return this.#dts;

        }
    }

    $(document).ready(function(){
        calcOnGridUIParser = new OngridUiParser( RAYSSA_CALC_ONGRID.calcConfig );
    });
});