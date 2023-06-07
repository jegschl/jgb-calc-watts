jQuery( function( $ ) {

    const rayssaCalcOffGridSlctr = RAYSSA_CALC_OFFGRID.rootSelector;
    const childElItems = ' table.items tbody';

    $(document).ready(function() {
       
        $(rayssaCalcOffGridSlctr + ' #add-item-button').click(function(){
            const newArtifactItem = $(this)
                .closest(rayssaCalcOffGridSlctr)
                .find(childElItems)
                .append(RAYSSA_CALC_OFFGRID.artifactItemTpl);

            // newArtifactItem almacena tbody entonces...
            const lastTREl = $(newArtifactItem).find('tr:last');
            
            $(lastTREl).find('td[data-field="actions"] .delete')
                .click(function(){
                    $(this).closest('tr').remove();
                    calcOffGridUIParser.calculate();
                });
                
            $(lastTREl).find('td[data-field="artifact"] select').select2();

            $(lastTREl).find('td[data-field="artifact"] select')
                .on('select2:select', function(e){
                    console.log('Datos de la selección:');
                    console.log(e.params.data);
                    const adList = RAYSSA_CALC_OFFGRID.artfctsDemo;
                    const adId = e.params.data.id;
                    let i = 0;
                    for( i = 0; i < adList.length; i++ ){
                        if( adList[i].id == adId ){
                            $(this)
                                .closest('tr')
                                .find('td[data-field="qty"] input')
                                .val(adList[i].qty);

                            $(this)
                                .closest('tr')
                                .find('td[data-field="power"] input')
                                .val(adList[i].power);

                            $(this)
                                .closest('tr')
                                .find('td[data-field="hours-by-day"] input')
                                .val(adList[i].duh);
                            
                            calcOffGridUIParser.calculate();
                            break;
                            
                        }
                    }
                });

            $(lastTREl).find('td[data-field="qty"] input')
                .change(function(){
                    calcOffGridUIParser.calculate();
                });

            $(lastTREl).find('td[data-field="power"] input')
                .change(function(){
                    calcOffGridUIParser.calculate();
                });

            $(lastTREl).find('td[data-field="hours-by-day"] input')
                .change(function(){
                    calcOffGridUIParser.calculate();
                });
        });

        $(rayssaCalcOffGridSlctr + ' #region-selector').change(function(){
            calcOffGridUIParser.calculate();
        });

        $(rayssaCalcOffGridSlctr + ' .contact-data-container button.submit')
        .click(function(){
            const data = calcOffGridUIParser.getDataToSend();

            const ac = {
                data: JSON.stringify(data),
                method: 'POST',
                url: RAYSSA_CALC_OFFGRID.sndExcrsURL,
                accepts: 'application/json; charset=UTF-8',
				contentType: 'application/json; charset=UTF-8',
                complete: ( jqXHR, textStatus )=>{
                    $.unblockUI();
                },
				success: ( data,  textStatus,  jqXHR )=>{},
				error: ( jqXHR, textStatus, errorThrown )=>{}
            };

            $.ajax(ac);
        });

        $('.rayssa-calc-offgrid .contact-data-container .field.submit button').click(function() { 
            $.blockUI({ message: $('#rayssa-processing-msg') }); 
        }); 

    });

});