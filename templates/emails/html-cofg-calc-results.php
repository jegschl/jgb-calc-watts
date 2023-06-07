<?php
$consumoDiario = number_format( $args['daylyConsumtion'], 2, ",","." );
$pwrPicoNecsr = number_format( $args['peakPowerRequired'], 2, ",","." );

?>
<div class="calc-results">

    <h2>Resultados del cálculo</h2>

    <div class="capacity-results">
        <div class="calc-result daylytotalKWatts">
            <span class="title">Consumo diario:</span>
            <span class="value"><?= $consumoDiario ?></span>
            <span class="unit">KW/h día</span>
        </div>

        <div class="calc-result nominalCapacity">
            <span class="title">Capacidad neta:</span>
            <span class="value"><?= number_format( $args['nominalCap'], 2, ",","." ) ?></span>
            <span class="unit">KWatt</span>
        </div>

        <div class="calc-result bruteCapacity">
            <span class="title">Capacidad bruta:</span>
            <span class="value"><?= number_format( $args['bruteCap'], 2, ",","." ) ?></span>
            <span class="unit">Watt/h</span>
        </div>

        <div class="calc-result hourly-amperage-container">
            <div class="amp-12v">
                <span class="title">12v:</span>
                <span class="value"><?= number_format( $args['ha12v'], 2, ",","." ) ?></span>
                <span class="unit">ah</span>
            </div>

            <div class="amp-24v">
                <span class="title">24v:</span>
                <span class="value"><?= number_format( $args['ha24v'], 2, ",","." ) ?></span>
                <span class="unit">ah</span>
            </div>

            <div class="amp-48v">
                <span class="title">48v:</span>
                <span class="value"><?= number_format( $args['ha48v'], 2, ",","." ) ?></span>
                <span class="unit">ah</span>
            </div>
        </div>
      
    </div>





    <div class="panels-calculation">
        <div class="step-1">
            <div class="calc-result region">
                <span class="title">Región:</span>
                <span class="value"><?= $args['hsp']['region'] ?></span>
            </div>
            
            <div class="calc-result peak-power-required">
                <span class="title">Potencia pico necesaria:</span>
                <span class="value"><?= $pwrPicoNecsr ?></span>
                <span class="unit"></span>
            </div>
        </div>

        <div class="step-2 panels-count-container">
            <div class="calc-result panel-count 335-340w">
                <span class="title">Panel 335/340w: </span>
                <div class="value-ctnr">
                    <span class="value"><?= $args['pc335_340w'] ?></span>
                    <span class="unit">unidades</span>
                </div>
            </div>

            <div class="calc-result panel-count 445-450w">
                <span class="title">Panel 445/450w: </span>
                <div class="value-ctnr">
                    <span class="value"><?= $args['pc445_450w'] ?></span>
                    <span class="unit">unidades</span>
                </div>
            </div>

            <div class="calc-result panel-count 550-560w">
                <span class="title">Panel 550/560w: </span>
                <div class="value-ctnr">
                    <span class="value"><?= $args['pc550_560w'] ?></span>
                    <span class="unit">unidades</span>
                </div>
            </div>

            <div class="calc-result panel-count 600-610w">
                <span class="title">Panel 600/610w: </span>
                <div class="value-ctnr">
                    <span class="value"><?= $args['pc600_610w'] ?></span>
                    <span class="unit">unidades</span>
                </div>
            </div>

            <div class="calc-result panel-count 650-660w">
                <span class="title">Panel 650/660w: </span>
                <div class="value-ctnr">
                    <span class="value"><?= $args['pc650_660w'] ?></span>
                    <span class="unit">unidades</span>
                </div>
            </div>
        </div>
    </div>


</div>