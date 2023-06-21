<?php 
    $img_logo_url = site_url('/wp-content/uploads/2023/04/LogoRayssa.png');
    //$img_logo_url = '/wp-content/uploads/2023/04/LogoRayssa.png';
    $img_logo_url = apply_filters('rayssa_pdf_img_logo_url',$img_logo_url);

    $img_water_mark = "/var/www/rayssa/public_html/wp-content/uploads/2023/06/LogoRayssa-blanco-inclinado-50x50-1.png";
    $img_water_mark = apply_filters('rayssa_pdf_img_watermark_path',$img_water_mark);
?>
<style>
    page{
        background-color: #086AD821;
    }
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

    table.contact-data,
    table.artifacts{border-collapse:collapse;}

    table.contact-data td{
        width: 170px;
        padding: 5px;
        
    }
    table.artifacts td{
        width: 114px;
        padding: 3px;
        
    }

    table.contact-data, table.contact-data th, table.contact-data td,
    table.artifacts, table.artifacts th, table.artifacts td{
        border: 1px solid;
    }

    table.results td.calc-result{
        width: 381px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: #094B82;
        color: #ffffff;
    } 
    table.results-s2 td.calc-result{
        width: 381px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: #EC763E;
        color: #ffffff;
    }

    table.results-s3 td.calc-result{
        width: 381px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: #6EC1E4; 
        color: #54595F;
    }

    td.calc-result .monthly, td.calc-result .yearly{
        display: block;
        text-align: center;
    }

    td.calc-result span.title{
        display: block;
        text-align: center;
    }

    .main-container{
        background-color: #D0E3F9;
        background-image: url(<?= $img_water_mark ?>);
        height: 100%;
    }

</style>

<page backcolor="#D0E3F9" footer="date;time;page">
    <div class="main-container">
        <div class="logo">
            <img src="<?=  $img_logo_url ?>">
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
                    <td>Nombre artefacto</td>
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

        ?>

        <h2>Resultados del cálculo</h2>
        <table class="results">
            <tbody>
                <tr>
                    <td class="calc-result daylytotalKWatts" >
                        
                            <span class="title">Consumo diario:</span>
                            <span class="value"><?= $consumoDiario ?></span>
                            <span class="unit">KW/h día</span>

                        
                    </td>
                    <td class="calc-result nominalCapacity">
                        
                            <span class="title">Capacidad neta:</span>
                            <span class="value"><?= number_format( $args['nominalCap'], 2, ",","." ) ?></span>
                            <span class="unit">KWatt</span>
                        
                    </td>
                </tr>

                <tr>
                    <td class="calc-result bruteCapacity">
                        
                            <span class="title">Capacidad bruta:</span>
                            <span class="value"><?= number_format( $args['bruteCap'], 2, ",","." ) ?></span>
                            <span class="unit">KW/h día</span>
                    
                        
                    </td>
                    <td class="calc-result hourly-amperage-container" >
                        
                            
                        <span class="title">12v:</span>
                        <span class="value"><?= number_format( $args['ha12v'], 2, ",","." ) ?></span>
                        <span class="unit">ah</span>
                    
                        /
                    
                        <span class="title">24v:</span>
                        <span class="value"><?= number_format( $args['ha24v'], 2, ",","." ) ?></span>
                        <span class="unit">ah</span>
                    
                        /
                    
                        <span class="title">48v:</span>
                        <span class="value"><?= number_format( $args['ha48v'], 2, ",","." ) ?></span>
                        <span class="unit">ah</span>
                            
                    
                    </td>
                </tr>

            </tbody>
        </table>

        <table class="results-s2">
            <tbody>
                <tr>
                    <td class="calc-result hsp">
                        
                            <span class="title">Región:</span>
                            <span class="value"><?= $args['hsp']['region'] ?></span>
                            <span class="unit"></span>
                    
                        
                    </td>
                    <td class="calc-result peak-pwr-req" >
                        
                            
                        <span class="title">Potencia pico necesaria:</span>
                        <span class="value"><?= number_format( $args['peakPowerRequired'], 2, ",","." ) ?></span>
                        <span class="unit"></span>
                            
                    
                    </td>
                </tr>

            </tbody>
        </table>

        <table class="results-s3">
            <tbody>
                <tr>
                    <td class="calc-result panel">
                        
                            <span class="title">Panel 335/340w:</span>
                            <span class="value"><?= $args['pc335_340w'] ?></span>
                            <span class="unit">unidades</span>
                    
                        
                    </td>
                    <td class="calc-result panel" >
                        
                            
                        <span class="title">Panel 445/450w:</span>
                        <span class="value"><?= $args['pc445_450w'] ?></span>
                        <span class="unit">unidades</span>
                            
                    
                    </td>
                </tr>

                <tr>
                    <td class="calc-result panel">
                        
                            <span class="title">Panel 550/560w:</span>
                            <span class="value"><?= $args['pc550_560w'] ?></span>
                            <span class="unit">unidades</span>
                    
                        
                    </td>
                    <td class="calc-result panel" >
                        
                            
                        <span class="title">Panel 600/610w:</span>
                        <span class="value"><?= $args['pc600_610w'] ?></span>
                        <span class="unit">unidades</span>
                            
                    
                    </td>
                </tr>

                <tr>
                    <td class="calc-result panel" colspan="2">
                        
                            <span class="title">Panel 650/660w:</span>
                            <span class="value"><?= $args['pc650_660w'] ?></span>
                            <span class="unit">unidades</span>
                    
                        
                    </td>
                    
                </tr>

            </tbody>
        </table>
    </div>
</page>