<?= $this->extend('templates/template') ?>

<?= $this->section('title') ?>Configurar totem<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .setup-card {
        background: #fff;
        border-radius: .5rem;
        border-top: 4px solid #fd7e14;
        box-shadow: 0 2px 12px rgba(0,0,0,.08);
        max-width: 420px;
        width: 100%;
    }
    .totem-id-input {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        color: #fd7e14;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: .5rem;
        -moz-appearance: textfield;
    }
    .totem-id-input::-webkit-outer-spin-button,
    .totem-id-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .totem-id-input:focus {
        border-color: #fd7e14;
        box-shadow: 0 0 0 .2rem rgba(253,126,20,.2);
        outline: none;
    }
    .totem-id-input.is-invalid { border-color: #dc3545; }
    .confirmed-badge {
        background: #d1e7dd;
        border: 2px solid #0f5132;
        border-radius: 8px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-center" style="min-height:80vh">
    <div class="setup-card p-4 mx-3">

        <div class="text-center mb-4">
            <i class="fa-solid fa-tablet-screen-button fa-3x mb-3" style="color:#fd7e14"></i>
            <h5 class="fw-bold mb-1">Configurar totem</h5>
            <p class="text-muted small mb-0">Informe o ID deste totem para ativá-lo.</p>
        </div>

        <div id="form-section">
            <div class="mb-3">
                <input type="number" id="totem-id" class="totem-id-input w-100"
                    placeholder="ID" min="1" autocomplete="off">
            </div>
            <div id="input-error" class="text-danger small text-center mb-3 d-none"></div>
            <button id="btn-verificar" class="btn w-100 text-white fw-bold py-2"
                style="background-color:#fd7e14;font-size:1.05rem">
                <i class="fa-solid fa-circle-check me-2"></i>Verificar e ativar
            </button>
        </div>

        <div id="confirmed-section" class="d-none">
            <div class="confirmed-badge p-3 text-center">
                <i class="fa-solid fa-circle-check fa-2x mb-2" style="color:#198754"></i>
                <div class="fw-bold" style="color:#0f5132">Totem configurado!</div>
                <div class="text-muted small mt-1" id="confirmed-desc"></div>
            </div>
            <a id="btn-iniciar" href="<?= base_url() ?>"
                class="btn w-100 text-white fw-bold py-2 mt-3" style="background-color:#fd7e14;font-size:1.05rem">
                <i class="fa-solid fa-arrow-right me-2"></i>Ir para o cardápio
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const CANTINA_URL = "<?= rtrim(env('CANTINA_URL', 'http://localhost/cantina/'), '/') . '/' ?>";
    const API_KEY     = "<?= env('API_KEY') ?>";
</script>
<script src="<?= base_url('assets/js/totem_setup.js') ?>"></script>
<?= $this->endSection() ?>
