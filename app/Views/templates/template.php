<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.all.min.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color:#d8dce2">

    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-center py-2 mt-auto bg-white text-muted" style="border-top:3px solid #fd7e14">
        <small><i class="fa-solid fa-utensils me-1"></i>Cantina &copy; <?= date('Y') ?></small>
    </footer>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>