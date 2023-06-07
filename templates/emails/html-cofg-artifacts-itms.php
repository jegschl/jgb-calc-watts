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
            <?php foreach($args as $art){ 
                do_action('rayssa_pdf_exercise_item',$art);
            }
            ?>
        </tbody>
    </table>