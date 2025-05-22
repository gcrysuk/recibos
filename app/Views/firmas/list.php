<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Firmas</title>
</head>

<body>
    <h1>Listado de Firmas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($firmas as $firma): ?>
                <tr>
                    <td><?= $firma['id'] ?></td>
                    <td><?= $firma['nombre'] ?></td>
                    <td>
                        <a href="/firmas/<?= $firma['id'] ?>">Ver</a>
                        <a href="/firmas/<?= $firma['id'] ?>/edit">Editar</a>
                        <form action="/firmas/<?= $firma['id'] ?>" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/firmas/create">Nueva Firma</a>
</body>

</html>