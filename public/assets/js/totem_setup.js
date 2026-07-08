'use strict';

const btn      = document.getElementById('btn-verificar');
const input    = document.getElementById('totem-id');
const errorEl  = document.getElementById('input-error');

function showError(msg) {
    errorEl.textContent = msg;
    errorEl.classList.remove('d-none');
    input.classList.add('is-invalid');
}

function clearError() {
    errorEl.classList.add('d-none');
    input.classList.remove('is-invalid');
}

btn.addEventListener('click', async () => {
    const id = input.value.trim();
    clearError();

    if (!id || isNaN(id) || parseInt(id) < 1) {
        showError('Informe um ID de totem válido.');
        input.focus();
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verificando…';

    try {
        const res = await fetch(CANTINA_URL + 'api/totens/' + parseInt(id), {
            headers: { 'X-API-Key': API_KEY },
        });

        if (res.status === 404) {
            showError('Totem não encontrado ou inativo. Verifique o ID com o administrador.');
            return;
        }

        if (!res.ok) {
            throw new Error('HTTP ' + res.status);
        }

        const totem = await res.json();

        localStorage.setItem('cantina_totem', JSON.stringify({
            id:       totem.id,
            descricao: totem.descricao,
        }));

        document.getElementById('form-section').classList.add('d-none');
        document.getElementById('confirmed-section').classList.remove('d-none');
        document.getElementById('confirmed-desc').textContent = totem.descricao + ' (ID #' + totem.id + ')';

    } catch (err) {
        console.error(err);
        showError('Erro ao verificar o totem. Tente novamente.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i>Verificar e ativar';
    }
});

input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') btn.click();
});
