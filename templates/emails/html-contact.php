<h2>Datos del solicitante</h2>
<div class="contact-data-table-wrapper">
    <table class="contact-data">
        <thead>
            <tr>
                <td>Nombres y apellidos</td>
                <td>Nro. telefónico</td>
                <td>Financiamiento</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong><?= $args['names'] ?></strong></td>
                <td><strong><?= $args['phone'] ?></strong></td>
                <td><strong><?= $args['finantial'] ?></strong></td>
            </tr>
            <tr>
                <td colspan="2">Email</td>
                <td>Comuna</td>
            </tr>
            <tr>
                <td colspan="2"><strong><?= $args['email'] ?></strong></td>
                <td><strong><?= $args['comuna'] ?></strong></td>
            </tr>
        </tbody>
        
    </table>
</div>