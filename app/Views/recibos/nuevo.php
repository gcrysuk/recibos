<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Recibo</title>
</head>

<body>
    <h2>Subir nuevo recibo</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('recibos/guardar') ?>" method="post" enctype="multipart/form-data">
        <label for="usuario_id">Empleado:</label>
        <select name="usuario_id" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['id'] ?>"><?= esc($usuario['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="archivo">Archivo PDF:</label>
        <input type="file" name="archivo" accept="application/pdf" required>
        <br><br>

        <button type="submit">Subir recibo</button>
    </form>
</body>

</html>