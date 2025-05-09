<!-- app/Views/recibos/subir_masivo.php -->

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Subir Recibos de Sueldo (Carga Masiva)</h2>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('mensaje') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('recibos/subir-masivo') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="periodo">Período (por ejemplo, 04/2025):</label>
        <input type="text" name="periodo" class="form-control" required placeholder="MM/AAAA">
    </div>

    <div class="form-group mt-3">
        <label for="archivos">Seleccionar archivos PDF (puede elegir varios):</label>
        <input type="file" name="archivos[]" class="form-control" multiple accept="application/pdf" required>
        <small class="form-text text-muted">El nombre de cada archivo debe incluir el número de documento del empleado (ejemplo: 20333444_recibo.pdf).</small>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Subir Recibos</button>
</form>

<form action="<?= site_url('recibos/subirMasivo') ?>" method="post" enctype="multipart/form-data">
    <label for="archivos">Seleccionar archivos PDF:</label>
    <input type="file" name="archivos[]" id="archivos" multiple accept="application/pdf">
    <br><br>
    <button type="submit">Subir recibos</button>
</form>


<?= $this->endSection() ?>