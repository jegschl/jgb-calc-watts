<?php 
    $img_logo_url = site_url('/wp-content/uploads/2023/04/LogoRayssa.png');
    //$img_logo_url = '/wp-content/uploads/2023/04/LogoRayssa.png';
    $img_logo_url = apply_filters('rayssa_pdf_img_logo_url',$img_logo_url);

    $img_water_mark = "/var/www/rayssa/public_html/wp-content/uploads/2023/06/LogoRayssa-blanco-inclinado-50x50-1.png";
    $img_water_mark = apply_filters('rayssa_pdf_img_watermark_path',$img_water_mark);
?>
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

    table.contact-data,
    table.panels{border-collapse:collapse;}

    table.contact-data td,
    table.panels td{
        width: 170px;
        padding: 5px;
        
    }

    table.contact-data, table.contact-data th, table.contact-data td,
    table.panels, table.panels th, table.panels td{
        border: 1px solid;
    }

    table.results td.calc-result{
        width: 380px;
        text-align: center;
        background-color: #094B82; 
        color: #ffffff;
        padding-top: 20px;
        padding-bottom: 20px;
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

<page 
    backcolor="#D0E3F9"
    footer="date;time;page"
>
    <div class="main-container">
        <div class="logo">
            <img src="<?=  $img_logo_url ?>">
        </div>

        <h1>Solicitud de cálculo OnGrid</h1>

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


        <h2>Datos de paneles</h2>
        <table class="panels">

            <thead>
                <tr>
                    <td>Potencia del panel</td>
                    <td>Cantidad de paneles</td>
                    <td>Región</td>
                    <td>HSP</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><strong><?= $args['pwr'] ?></strong></td>
                    <td><strong><?= $args['qty'] ?> unidades</strong></td>
                    <td><strong><?= $args['region'] ?></strong></td>
                    <td><strong><?= $args['hsp'] ?></strong></td>
                </tr>
            </tbody>
        </table>

        <?php

        $whbd   = number_format( $args['whbd'], 2, ",","." );
        $kwhbd  = number_format( $args['kwhbd'], 2, ",","." );
        $kwhbm  = number_format( $args['kwhbm'], 2, ",","." );
        $discm  = number_format( $args['discbm'], 0, ",","." );
        $discy  = number_format( $args['discby'], 0, ",","." );

        $anchoCRCol = "350";

        ?>

        <h2>Resultados del cálculo</h2>
        <table class="results">
            <tbody>
                <tr>
                    <td class="calc-result wh-by-day" >
                        
                            <span class="title">W/H Día:</span>
                            <span class="value"><?= $whbd ?></span>
                            <span class="unit">W/h</span>

                        
                    </td>
                    <td class="calc-result kwh-by-dy">
                        
                            <span class="title">KW/H al día:</span>
                            <span class="value"><?= $kwhbd ?></span>
                            <span class="unit">KW/H</span>
                        
                    </td>
                </tr>

                <tr>
                    <td class="calc-result kwh-by-month">
                        
                            <span class="title">KW/H al mes:</span>
                            <span class="value"><?= $kwhbm ?></span>
                            <span class="unit">KW/h</span>
                    
                        
                    </td>
                    <td class="calc-result discounts">
                        
                            
                        <span class="title">Descuento mensual:</span>
                        <span class="unit">$</span>
                        <span class="value"><?= $discm ?></span>
                        
                        <br>
                    
                        <span class="title">Descuento anual:</span>
                        <span class="unit">$</span>
                        <span class="value"><?= $discy ?></span>
                                
                    
                    
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</page>