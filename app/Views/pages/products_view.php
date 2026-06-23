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
        object-fit: cover;
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
        .price-tag {
            font-size: 1.15rem;
        }
    }

    .category-btn {
        background-color: transparent;
        color: #6c757d;
        border-color: #dee2e6;
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
        .product-img-wrap {
            height: 110px;
        }

        .product-img-wrap .img-placeholder {
            font-size: 2.2rem;
        }

        .card-body {
            padding: .6rem;
        }

        .price-tag {
            font-size: .95rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$products = [
    [
        'id' => 1,
        'name' => 'X-Burguer Clássico',
        'category' => 'lanches',
        'description' => 'Pão brioche, hambúrguer 150g, queijo, alface e tomate.',
        'price' => 18.90,
        'img' => null,
        'icon' => 'fa-burger',
    ],
    [
        'id' => 2,
        'name' => 'Coxinha Crocante',
        'category' => 'lanches',
        'description' => 'Recheio de frango desfiado com catupiry, massa crocante.',
        'price' => 7.50,
        'img' => null,
        'icon' => 'fa-drumstick-bite',
    ],
    [
        'id' => 3,
        'name' => 'Misto Quente',
        'category' => 'lanches',
        'description' => 'Pão de forma, presunto e queijo grelhados na chapa.',
        'price' => 9.00,
        'img' => null,
        'icon' => 'fa-bread-slice',
    ],
    [
        'id' => 4,
        'name' => 'Suco de Laranja',
        'category' => 'bebidas',
        'description' => 'Suco natural de laranja gelado, 300 ml.',
        'price' => 6.00,
        'img' => null,
        'icon' => 'fa-martini-glass-citrus',
    ],
    [
        'id' => 5,
        'name' => 'Refrigerante Lata',
        'category' => 'bebidas',
        'description' => 'Lata 350 ml — Coca-Cola, Guaraná ou Fanta.',
        'price' => 5.00,
        'img' => null,
        'icon' => 'fa-wine-bottle',
    ],
    [
        'id' => 6,
        'name' => 'Água Mineral',
        'category' => 'bebidas',
        'description' => 'Garrafa 500 ml sem gás ou com gás.',
        'price' => 3.00,
        'img' => null,
        'icon' => 'fa-droplet',
    ],
];
?>

<!-- Top bar -->
<div class="sticky-top bg-white" style="border-bottom:3px solid #fd7e14">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between gap-2">

        <!-- Category filters -->
        <div class="d-flex gap-1 gap-md-2">
            <button class="btn btn-sm category-btn active" data-category="todos">
                <i class="fa-solid fa-border-all me-md-1"></i><span class="d-none d-md-inline">Todos</span>
            </button>
            <button class="btn btn-sm category-btn" data-category="lanches">
                <i class="fa-solid fa-burger me-md-1"></i><span class="d-none d-md-inline">Lanches</span>
            </button>
            <button class="btn btn-sm category-btn" data-category="bebidas">
                <i class="fa-solid fa-bottle-water me-md-1"></i><span class="d-none d-md-inline">Bebidas</span>
            </button>
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
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-2 g-sm-3 g-md-4"
        id="product-grid">

        <?php foreach ($products as $product): ?>
            <div class="col product-item" data-category="<?= $product['category'] ?>">
                <div class="card product-card h-100 shadow-sm overflow-hidden">

                    <!-- Image -->
                    <div class="product-img-wrap">
                        <?php if ($product['img']): ?>
                            <img src="<?= $product['img'] ?>" alt="<?= esc($product['name']) ?>">
                        <?php else: ?>
                            <span class="img-placeholder">
                                <i class="fa-solid <?= $product['icon'] ?>"></i>
                            </span>
                        <?php endif ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div
                            class="d-flex flex-column flex-md-row align-items-md-baseline justify-content-md-between gap-1 mb-1">
                            <h6 class="card-title fw-bold mb-0"><?= esc($product['name']) ?></h6>
                            <span class="price-tag text-nowrap">R$
                                <?= number_format($product['price'], 2, ',', '.') ?></span>
                        </div>
                        <p class="card-text text-muted mb-2 mt-1" style="font-size:.8rem; line-height:1.3">
                            <?= esc($product['description']) ?>
                        </p>
                        <button class="btn btn-success btn-add w-100 btn-sm mt-auto"
                            data-id="<?= $product['id'] ?>"
                            data-name="<?= esc($product['name']) ?>"
                            data-price="<?= $product['price'] ?>"
                            data-description="<?= esc($product['description']) ?>"
                            data-icon="<?= $product['icon'] ?>"
                            data-img="<?= $product['img'] ?? '' ?>">
                            <i class="fa-solid fa-plus me-1"></i>Adicionar
                        </button>
                    </div>

                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/products.js') ?>"></script>
<?= $this->endSection() ?>