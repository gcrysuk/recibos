<h2>Mis Recibos</h2>

<?php if (empty($recibos)): ?>
    <p>No tenés recibos disponibles por el momento.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Fecha de Subida</th>
                <th>Archivo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recibos as $recibo): ?>
                <tr>
                    <td><?= esc($recibo['mes']) ?></td>
                    <td><?= esc($recibo['anio']) ?></td>
                    <td><?= esc(date('d/m/Y', strtotime($recibo['fecha_subida']))) ?></td>
                    <td>
                        <a href="<?= base_url('uploads/recibos/' . $recibo['archivo']) ?>" target="_blank">Ver / Descargar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>