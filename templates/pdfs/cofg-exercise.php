<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Solicitud Rayssa</title>
</head>
<body>
    <div class="logo">
        <img src="http://rayssa.local/wp-content/uploads/2023/04/LogoRayssa.png" width="90px">
    </div>

    <h1>Solicitud de OffGrid</h1>

    <h2>Datos del solicitante</h2>
    <div class="contact-data">
        <div class="field">
            <div class="label">Nombres y apellidos</div>
            <div class="value">{nombresApellidos}</div>
        </div>

        <div class="field">
            <div class="label">Email</div>
            <div class="value">{email}</div>
        </div>

        <div class="field">
            <div class="label">Nro. telefónico</div>
            <div class="value">{telefono}</div>
        </div>

        <div class="field">
            <div class="label">Está interesado en financiamiento</div>
            <div class="value">{financiamiento}</div>
        </div>
    </div>


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
            <?php foreach($dt['artifacts'] as $art){ ?>
            <tr>
                <td><?= $art['name'] ?></td>
                <td><?= $art['qty'] ?></td>
                <td><?= $art['pwr'] ?></td>
                <td><?= $art['duh'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>