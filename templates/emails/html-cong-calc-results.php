<?php
$consumoDiario = number_format( $args['daylyConsumtion'], 2, ",","." );
$pwrPicoNecsr = number_format( $args['peakPowerRequired'], 2, ",","." );

?>
<div class="calc-results">

    <h2>Resultados del cálculo</h2>

    <div class="capacity-results">
        <div class="calc-result dayly-wh">
            <span class="title">W/H Día:</span>
            <span class="value"><?= $args['whbd'] ?></span>
            <span class="unit">W/h</span>
        </div>

        <div class="calc-result dayly-kwh">
            <span class="title">KW/H al Día:</span>
            <span class="value"><?= number_format( $args['kwhbd'], 2, ",","." ) ?></span>
            <span class="unit">KW/H</span>
        </div>

        <div class="calc-result monthly-kwh">
            <span class="title">KW/H al Día:</span>
            <span class="value"><?= number_format( $args['kwhbm'], 2, ",","." ) ?></span>
            <span class="unit">KW/H</span>
        </div>

        <div class="calc-result hourly-amperage-container">
            <div class="discount by-month">
                <span class="title">Descuento mensual:</span>
                <span class="unit">$</span>
                <span class="value"><?= number_format( $args['discbm'], 2, ",","." ) ?></span>
            </div>

            <div class="discount by-year">
                <span class="title">Descuento anual:</span>
                <span class="unit">$</span>
                <span class="value"><?= number_format( $args['discby'], 2, ",","." ) ?></span>
                
            </div>

        </div>
      
    </div>


</div>