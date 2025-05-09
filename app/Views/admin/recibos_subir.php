<!DOCTYPE html>
<html>

<head>
    <title>Cargar Recibo</title>
</head>

<body>
    <h2>Cargar Recibo de Sueldo</h2>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p style="color: green;"><?= session()->getFlashdata('mensaje') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('/recibos/guardar') ?>" method="post" enctype="multipart/form-data">
        <label for="usuario_id">Empleado:</label>
        <select name="usuario_id" required>
            <option value="">Seleccionar</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= $usuario['id'] ?>"><?= esc($usuario['nombre_completo']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="periodo">Periodo (ej. 2025-03):</label>
        <input type="month" name="periodo" required><br><br>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br><br>

        <label for="archivo_pdf">Archivo PDF:</label>
        <input type="file" name="archivo_pdf" accept=".pdf" required><br><br>

        <button type="submit">Cargar Recibo</button>
    </form>
</body>

</html>