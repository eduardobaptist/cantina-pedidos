<?= $this->extend('templates/template') ?>

<?= $this->section('title') ?>Checkout<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .receipt-card {
        background: #fff;
        border-radius: 4px;
        font-family: 'Courier New', Courier, monospace;
    }
    .receipt-header {
        border-bottom: 2px dashed #dee2e6;
    }
    .receipt-footer {
        border-top: 2px dashed #dee2e6;
    }
    .receipt-tear {
        height: 12px;
        background: repeating-linear-gradient(
            90deg,
            #d8dce2 0px,
            #d8dce2 10px,
            transparent 10px,
            transparent 18px
        );
        margin: 0 -1px;
    }
    .receipt-line {
        font-size: .9rem;
        border-bottom: 1px dotted #e9ecef;
    }
    .receipt-line:last-child { border-bottom: none; }
    .receipt-qty  { color: #6c757d; font-weight: 600; min-width: 28px; flex-shrink: 0; }
    .receipt-name { font-weight: 500; }
    .receipt-price { font-weight: 700; color: #212529; }
    .receipt-total-row {
        font-size: 1.15rem;
        font-weight: 700;
        color: #fd7e14;
    }
    .step-badge {
        font-size: .72rem;
        letter-spacing: .04em;
        background: #fd7e14;
        color: #fff;
        padding: 2px 8px;
        border-radius: 99px;
    }
    .name-input-wrap input {
        font-family: inherit;
        font-size: 1.05rem;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        padding: .5rem .75rem;
        transition: border-color .15s;
    }
    .name-input-wrap input:focus {
        border-color: #fd7e14;
        box-shadow: 0 0 0 .2rem rgba(253,126,20,.2);
        outline: none;
    }
    .name-input-wrap input.is-invalid {
        border-color: #dc3545;
    }
    .name-input-wrap input:disabled {
        background: #f8f9fa;7
        color: #495057;
    }
    .confirmed-badge {
        background: #d1e7dd;
        border: 2px solid #0f5132;
        border-radius: 8px;
    }
    .order-number-big {
        font-size: 3rem;
        font-weight: 900;
        color: #fd7e14;
        letter-spacing: .05em;
        line-height: 1;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="sticky-top bg-white" style="border-bottom:3px solid #fd7e14">
    <div class="container-fluid px-3 py-2 d-flex align-items-center gap-2">
        <a href="<?= base_url('carrinho') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="fw-bold fs-5">Finalizar pedido</span>
        <span class="badge bg-success ms-1" id="item-count">0 itens</span>
    </div>
</div>

<div class="container py-4" style="max-width:520px">

    <!-- Carrinho vazio -->
    <div id="empty-cart-msg" class="d-none text-center py-5">
        <i class="fa-solid fa-receipt fa-4x text-muted mb-3"></i>
        <p class="text-muted mb-4">Nenhum item no carrinho.</p>
        <a href="<?= base_url('cardapio') ?>" class="btn text-white fw-semibold" style="background-color:#fd7e14">
            <i class="fa-solid fa-arrow-left me-1"></i>Ver cardápio
        </a>
    </div>

    <!-- Recibo -->
    <div id="receipt-body">

        <!-- Topo picotado -->
        <div class="receipt-tear"></div>

        <div class="receipt-card px-4 py-3">

            <!-- Cabeçalho do recibo -->
            <div class="receipt-header pb-3 mb-3 text-center">
                <div class="fw-bold" style="font-size:1.1rem; letter-spacing:.06em">Resumo</div>
            </div>

            <!-- Itens -->
            <div id="receipt-items" class="mb-3"></div>

            <!-- Total -->
            <div class="receipt-footer pt-3 mt-1">
                <div class="d-flex justify-content-between align-items-center receipt-total-row py-1">
                    <span>TOTAL</span>
                    <span id="receipt-total">R$ 0,00</span>
                </div>
            </div>

        </div>

        <!-- Fundo picotado -->
        <div class="receipt-tear"></div>

        <!-- Nome do cliente -->
        <div id="name-section" class="mt-4">
            <div class="name-input-wrap">
                <input
                    type="text"
                    id="customer-name"
                    class="form-control w-100"
                    placeholder="Como devemos te chamar?"
                    maxlength="40"
                    autocomplete="off"
                >
                <div class="invalid-feedback d-block text-danger small mt-1" id="name-error" style="display:none !important">
                    Por favor, informe seu nome.
                </div>
            </div>
            <div class="text-muted small mt-1 ms-1">Seu nome será chamado quando o pedido estiver pronto.</div>
        </div>

        <!-- Pedido confirmado (oculto até confirmar) -->
        <div id="order-confirmed" class="d-none mt-4">
            <div class="confirmed-badge p-4 text-center">
                <i class="fa-solid fa-circle-check fa-2x mb-2" style="color:#198754"></i>
                <div class="fw-bold fs-5 mb-1" style="color:#0f5132">Pedido enviado para a cozinha!</div>
                <div class="text-muted small mb-3">Fique atento ao seu número:</div>
                <div class="order-number-big mb-2" id="order-number">#000</div>
                <div class="text-muted small">Pedido de: <strong id="order-name"></strong></div>
                <div class="text-muted small mt-3">
                    Voltando à tela inicial em <span id="countdown">10</span>s...
                </div>
            </div>
        </div>

        <!-- Botão confirmar -->
        <div class="mt-4 mb-2">
            <button
                id="btn-confirm"
                class="btn w-100 text-white fw-bold py-3"
                style="background-color:#fd7e14; font-size:1.1rem"
            >
                <i class="fa-solid fa-paper-plane me-2"></i>Confirmar pedido
            </button>
        </div>

        <!-- Botão finalizar (aparece após confirmação) -->
        <div class="mb-4">
            <a
                href="<?= base_url() ?>"
                id="btn-finish"
                class="btn text-white fw-semibold w-100 d-none" style="background-color:#fd7e14"
            >
                <i class="fa-solid fa-home me-2"></i>Novo pedido agora
            </a>
        </div>

    </div><!-- /receipt-body -->

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const BASE_URL    = "<?= base_url() ?>";
    const CANTINA_URL = "<?= rtrim(env('CANTINA_URL', 'http://localhost/cantina/'), '/') . '/' ?>";
    const API_KEY     = "<?= env('API_KEY') ?>";
</script>
<script src="<?= base_url('assets/js/totem-guard.js') ?>"></script>
<script src="<?= base_url('assets/js/checkout.js') ?>"></script>
<?= $this->endSection() ?>
