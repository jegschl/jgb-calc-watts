jQuery( function( $ ) {

    const rayssaCalcOnGridSlctr = RAYSSA_CALC_ONGRID.rootSelector;
    const childElItems = ' table.items tbody';

    $(document).ready(function() {
       
        const rayssaCokNmSsnId = RAYSSA_CALC_ONGRID.cokNm_ExcrSsnId;
        const rayssaExrcsSsnId = RAYSSA_CALC_ONGRID.rayssaExcrcsSsnId;
        Cookies.set(rayssaCokNmSsnId,rayssaExrcsSsnId, {sameSite: 'none'});

        const elSelPwr    = rayssaCalcOnGridSlctr + childElItems + ' select#potencia';
        const elSelRegion = rayssaCalcOnGridSlctr + childElItems + ' select#region-selector';
        const elNbrQty    = rayssaCalcOnGridSlctr + childElItems + ' input#panels-qty';
        const elSubmit    = rayssaCalcOnGridSlctr + ' .contact-data-container button.submit';
        
        $(elSelPwr).niceSelect('destroy');
        $(elSelRegion).niceSelect('destroy');

        $(elSelPwr).select2();

        $(elSelPwr).on('select2:select', function(e){
            console.log('Datos de la selección de Potencia de Panel:');
            console.log(e.params.data);
            calcOnGridUIParser.calculate();
        });

        $(elNbrQty).change(function(){
            calcOnGridUIParser.calculate();
        });

        $(elSelRegion).select2();
        $(elSelRegion).change(function(){
            calcOnGridUIParser.calculate();
        });

        $(elSubmit).click(function(){
            $.blockUI({ message: $('#rayssa-processing-msg') }); 
            const data = calcOnGridUIParser.getDataToSend();

            data.excerciseSsnId = RAYSSA_CALC_ONGRID.rayssaExcrcsSsnId;
            data.sysSsnId       = RAYSSA_CALC_ONGRID.sysSsnId;
            
            const ac = {
                data: JSON.stringify(data),
                method: 'POST',
                url: RAYSSA_CALC_ONGRID.sndExcrsURL,
                accepts: 'application/json; charset=UTF-8',
				contentType: 'application/json; charset=UTF-8',
                complete: ( jqXHR, textStatus )=>{
                    $.unblockUI();
                    location.reload();
                },
				success: ( data,  textStatus,  jqXHR )=>{},
				error: ( jqXHR, textStatus, errorThrown )=>{}
            };

            $.ajax(ac);
        });

    });

});