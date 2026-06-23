<?= $this->extend('templates/template') ?>

<?= $this->section('title') ?>Carrinho<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .cart-img-wrap {
        width: 72px;
        height: 72px;
        min-width: 72px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .cart-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .icon-placeholder {
        font-size: 1.8rem;
        color: #ced4da;
    }
    .cart-item-card {
        background: #fff;
        border: none;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        line-height: 1;
        transition: background-color .15s, border-color .15s, color .15s;
    }
    .btn-minus:hover { background-color: #dc3545 !important; border-color: #dc3545 !important; color: #fff !important; }
    .btn-plus:hover  { background-color: #198754 !important; border-color: #198754 !important; color: #fff !important; }
    .btn-remove { transition: background-color .15s, border-color .15s, color .15s; }
    .btn-remove:hover { background-color: #dc3545 !important; border-color: #dc3545 !important; color: #fff !important; }
    .qty-input {
        width: 48px;
        height: 32px;
        text-align: center;
        font-weight: 700;
        font-size: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .item-subtotal {
        color: #fd7e14;
        font-weight: 700;
        font-size: .95rem;
        text-align: center;
        min-width: 72px;
    }
    .bottom-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 3px solid #fd7e14;
        z-index: 1030;
    }
    @media (max-width: 575px) {
        .cart-img-wrap { width: 56px; height: 56px; min-width: 56px; }
        .icon-placeholder { font-size: 1.4rem; }
        .item-subtotal { min-width: 60px; font-size: .85rem; }
        .qty-btn { width: 28px; height: 28px; font-size: 1rem; }
        .qty-input { width: 40px; height: 28px; font-size: .9rem; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="sticky-top bg-white" style="border-bottom:3px solid #fd7e14">
    <div class="container-fluid px-3 py-2 d-flex align-items-center gap-2">
        <a href="<?= base_url() ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="fw-bold fs-5">Carrinho</span>
        <span class="badge bg-success ms-1" id="item-count">0 itens</span>
    </div>
</div>

<!-- Items (rendered by cart.js) -->
<div class="container-fluid px-2 px-md-4 py-3" id="cart-items"></div>

<!-- Spacer so content doesn't hide behind bottom bar -->
<div style="height:90px"></div>

<!-- Bottom bar -->
<div class="bottom-bar px-3 py-2">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2">
        <div class="lh-1 text-end text-md-start">
            <div class="text-muted small mb-1">Total</div>
            <div class="fw-bold" style="font-size:1.6rem; color:#fd7e14" id="cart-total">R$ 0,00</div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url() ?>" class="btn btn-outline-secondary flex-fill flex-md-grow-0">
                <i class="fa-solid fa-xmark me-1"></i>Cancelar
            </a>
            <a href="<?= base_url('checkout') ?>" class="btn text-white fw-semibold flex-fill flex-md-grow-0" style="background-color:#fd7e14" id="btn-confirm">
                <i class="fa-solid fa-check me-1"></i>Confirmar pedido
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url('assets/js/cart.js') ?>"></script>
<?= $this->endSection() ?>
