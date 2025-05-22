<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Recibos</title>
</head>

<body>
    <h1>Listado de Recibos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recibos as $recibo): ?>
                <tr>
                    <td><?= $recibo['id'] ?></td>
                    <td><?= $recibo['numero'] ?></td>
                    <td><?= $recibo['fecha'] ?></td>
                    <td>
                        <a href="/recibos/<?= $recibo['id'] ?>">Ver</a>
                        <a href="/recibos/<?= $recibo['id'] ?>/edit">Editar</a>
                        <form action="/recibos/<?= $recibo['id'] ?>" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/recibos/create">Nuevo Recibo</a>
</body>

</html>