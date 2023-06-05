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

</style>
<page>
    <div class="logo">
        <img src="http://rayssa.local/wp-content/uploads/2023/04/LogoRayssa.png">
    </div>

    <h1>Solicitud de cálculo OffGrid</h1>

    <h2>Datos del solicitante</h2>
    <center><div class="contact-data-table-wrapper">
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
    </div></center>


    <h2>Lista de artefactos</h2>
    <table>

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
</page>