<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Roles</title>
</head>

<body>
    <h1>Listado de Roles</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?= $role['id'] ?></td>
                    <td><?= $role['nombre'] ?></td>
                    <td><?= $role['descripcion'] ?></td>
                    <td>
                        <a href="/roles/<?= $role['id'] ?>">Ver</a>
                        <a href="/roles/<?= $role['id'] ?>/edit">Editar</a>
                        <form action="/roles/<?= $role['id'] ?>" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/roles/create">Nuevo Rol</a>
</body>

</html>