<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
</head>

<body>
    <h1>Listado de Usuarios</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td>
                        <a href="/usuarios/<?= $usuario['id'] ?>">Ver</a>
                        <a href="/usuarios/<?= $usuario['id'] ?>/edit">Editar</a>
                        <form action="/usuarios/<?= $usuario['id'] ?>" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/usuarios/create">Nuevo Usuario</a>
</body>

</html>