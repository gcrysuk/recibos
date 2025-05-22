<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignaciones de Roles</title>
</head>

<body>
    <h1>Asignaciones de Roles a Usuarios</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asignaciones as $asignacion): ?>
                <tr>
                    <td><?= $asignacion['id'] ?></td>
                    <td><?= $asignacion['usuario_id'] ?></td>
                    <td><?= $asignacion['role_id'] ?></td>
                    <td>
                        <a href="/asignaciones/<?= $asignacion['id'] ?>">Ver</a>
                        <a href="/asignaciones/<?= $asignacion['id'] ?>/edit">Editar</a>
                        <form action="/asignaciones/<?= $asignacion['id'] ?>" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/asignaciones/create">Nueva Asignación</a>
</body>

</html>