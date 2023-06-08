<style>
    .logo img{
        width: 120px;
        height: auto;
    }

    h1,h2{
        text-align: center;
    }

    .contact-data th td{
        color: #7A7A7A;
    }

    .contact-data td{
        padding: 5px;
    }

    .contact-data-table-wrapper{
        text-align: center;
    }

    table.results td.calc-results{
        text-align: center;
        background-color: #094B82; 
        color: #ffffff;
    }

</style>
<page>
    <div class="logo">
        <img src="http://rayssa.local/wp-content/uploads/2023/04/LogoRayssa.png">
    </div>

    <h1>Solicitud de cálculo OffGrid</h1>

    <h2>Datos del solicitante</h2>
    <div class="contact-data-table-wrapper">
        <table class="contact-data">
            <thead>
                <tr>
                    <td>Nombres y apellidos</td>
                    <td>Email</td>
                    <td>Nro. telefónico</td>
                    <td>Financiamiento</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{nombresApellidos}</strong></td>
                    <td><strong>{email}</strong></td>
                    <td><strong>{telefono}</strong></td>
                    <td><strong>{financiamiento}</strong></td>
                </tr>
            </tbody>
            
        </table>
    </div>


    <h2>Lista de artefactos</h2>
    <table class="artifacts">

        <thead>
            <tr>
                <td>Nombre</td>
                <td>Cantidad</td>
                <td>Potencia</td>
                <td>Tiempo de uso diario</td>
                <td>KW/h día</td>
                <td>KW/h mes</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach($args['artifacts'] as $art){ 
                do_action('rayssa_pdf_exercise_item',$art);
            }
            ?>
        </tbody>
    </table>

    <?php

    $consumoDiario = number_format( $args['daylyConsumtion'], 2, ",","." );
    $pwrPicoNecsr  = number_format( $args['peakPowerRequired'], 2, ",","." );

    $anchoCRCol = "350";
    ?>

    <h2>Resultados del cálculo</h2>
    <table class="results">
        <tbody>
            <tr>
                <td class="calc-result daylytotalKWatts" width="<?= $anchoCRCol ?>" style="background-color:lightblue; text-align: center; color: white;">
                    
                        <span class="title">Consumo diario:</span>
                        <span class="value"><?= $consumoDiario ?></span>
                        <span class="unit">KW/h día</span>

                    
                </td>
                <td class="calc-result nominalCapacity" width="<?= $anchoCRCol ?>">
                    
                        <span class="title">Capacidad neta:</span>
                        <span class="value"><?= number_format( $args['nominalCap'], 2, ",","." ) ?></span>
                        <span class="unit">KWatt</span>
                    
                </td>
            </tr>

            <tr>
                <td class="calc-result bruteCapacity" width="<?= $anchoCRCol ?>">
                    
                        <span class="title">Capacidad bruta:</span>
                        <span class="value"><?= number_format( $args['bruteCap'], 2, ",","." ) ?></span>
                        <span class="unit">KW/h día</span>
                   
                    
                </td>
                <td class="calc-result hourly-amperage-container" width="<?= $anchoCRCol ?>">
                    
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
                  
                </td>
            </tr>

        </tbody>
    </table>
</page>