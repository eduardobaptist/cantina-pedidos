<?= $this->extend('templates/template') ?>

<?= $this->section('title') ?>Cantina<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .start-wrap {
        min-height: 75vh;
    }
    .start-icon {
        font-size: 5rem;
        color: #fd7e14;
    }
    .btn-iniciar {
        background-color: #fd7e14;
        border-color: #fd7e14;
        color: #fff;
        font-size: 1.5rem;
        border-radius: 1rem;
        padding: 1.25rem 3rem;
        transition: background-color .15s, transform .15s;
    }
    .btn-iniciar:hover {
        background-color: #e8650a;
        border-color: #e8650a;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="start-wrap d-flex flex-column align-items-center justify-content-center text-center px-3">
    <div class="mb-4">
        <i class="fa-solid fa-utensils start-icon"></i>
    </div>
    <h1 class="fw-bold mb-2">Bem-vindo à Cantina</h1>
    <p class="text-muted fs-5 mb-5">Toque no botão abaixo para começar seu pedido</p>
    <button id="btn-iniciar" class="btn btn-iniciar fw-bold">
        <i class="fa-solid fa-play me-2"></i>Iniciar pedido
    </button>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const totemParam = new URLSearchParams(window.location.search).get('totem');
    if (totemParam) {
        localStorage.setItem('cantina_totem', totemParam);
    }

    document.getElementById('btn-iniciar').addEventListener('click', function () {
        localStorage.removeItem('cantina_cart');
        window.location.href = "<?= base_url('cardapio') ?>";
    });
</script>
<?= $this->endSection() ?>
