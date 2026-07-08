<?= $this->extend('templates/template') ?>

<?= $this->section('title') ?>Cardápio<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .product-card {
        background-color: #fff;
        border: none;
        transition: transform .15s, box-shadow .15s;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .12) !important;
    }

    .product-img-wrap {
        height: 150px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
    }

    .product-img-wrap .img-placeholder {
        font-size: 3rem;
        color: #ced4da;
    }

    .price-tag {
        font-weight: 700;
        font-size: .95rem;
        color: #fd7e14;
    }

    @media (min-width: 768px) {
        .price-tag { font-size: 1.15rem; }
    }

    .category-btn {
        background-color: transparent;
        color: #6c757d;
        border-color: #dee2e6;
        text-transform: capitalize;
    }

    .category-btn:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
        color: #212529;
    }

    .category-btn.active {
        background-color: #fd7e14 !important;
        color: #fff !important;
        border-color: #fd7e14 !important;
    }

    .btn-cart {
        background-color: #fd7e14;
        border-color: #fd7e14;
        color: #fff;
    }

    .btn-cart:hover {
        background-color: #e8650a;
        border-color: #e8650a;
        color: #fff;
    }

    @media (max-width: 575px) {
        .product-img-wrap { height: 110px; }
        .product-img-wrap .img-placeholder { font-size: 2.2rem; }
        .card-body { padding: .6rem; }
        .price-tag { font-size: .95rem; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Top bar -->
<div class="sticky-top bg-white" style="border-bottom:3px solid #fd7e14">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between gap-2">

        <!-- Category filters -->
        <div class="d-flex flex-wrap gap-1 gap-md-2">
            <button class="btn btn-sm category-btn active" data-category="todos">
                <i class="fa-solid fa-border-all me-md-1"></i><span class="d-none d-md-inline">Todos</span>
            </button>
            <button class="btn btn-sm category-btn" data-category="lanches">Lanches</button>
            <button class="btn btn-sm category-btn" data-category="bebidas">Bebidas</button>
        </div>

        <!-- Cart -->
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold text-dark" id="cart-total">R$ 0,00</span>
            <a href="<?= base_url('carrinho') ?>" class="btn btn-sm btn-cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>

    </div>
</div>

<!-- Product grid -->
<div class="container-fluid px-2 px-sm-3 px-md-4 py-3">

    <!-- Product grid (rendered by products.js) -->
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-2 g-sm-3 g-md-4"
        id="product-grid">
        <div class="col-12 text-center py-5 text-muted">
            <div class="spinner-border" style="color:#fd7e14" role="status"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const BASE_URL    = "<?= base_url() ?>";
    const CANTINA_URL = "<?= rtrim(env('CANTINA_URL', 'http://localhost/cantina/'), '/') . '/' ?>";
    const API_KEY     = "<?= env('API_KEY') ?>";
</script>
<script src="<?= base_url('assets/js/totem-guard.js') ?>"></script>
<script src="<?= base_url('assets/js/products.js') ?>"></script>
<?= $this->endSection() ?>
