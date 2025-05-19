<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="mb-4">Subir Recibos Masivos</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('recibos/procesar-masivo') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="periodo" class="form-label">Período (Ej: 2025-05)</label>
            <input type="month" id="periodo" name="periodo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo PDF (1 recibo por página)</label>
            <input type="file" id="archivo" name="archivo" class="form-control" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">Procesar Recibos</button>
    </form>
</div>

<?= $this->endSection() ?>