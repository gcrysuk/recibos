<?php if (session()->getFlashdata('success')): ?>
    <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<h2>Listado de Recibos</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Archivo</th>
            <th>Firmado</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recibos as $recibo): ?>
            <tr>
                <td><?= $recibo['id'] ?></td>
                <td><?= $recibo['archivo'] ?></td>
                <td><?= $recibo['firmado'] ? 'Sí' : 'No' ?></td>
                <td><?= $recibo['fecha'] ?></td>
                <td>
                    <a href="<?= base_url('uploads/recibos/' . $recibo['archivo']) ?>" target="_blank">Ver</a>
                    <?php if (!$recibo['firmado']): ?>
                        | <a href="<?= site_url('recibos/firmar/' . $recibo['id']) ?>">Firmar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>