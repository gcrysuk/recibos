<!DOCTYPE html>
<html>

<head>
    <title>Subir Recibo</title>
</head>

<body>
    <h1>Subir Recibo PDF</h1>

    <form action="/api/recibos" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" accept="application/pdf" required>
        <input type="text" name="usuario_id" placeholder="ID del usuario" required>
        <button type="submit">Subir recibo</button>
    </form>
</body>

</html>