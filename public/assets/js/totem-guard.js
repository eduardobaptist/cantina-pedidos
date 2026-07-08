'use strict';

function clearTotemAndRedirect() {
    localStorage.removeItem('cantina_totem');
    window.location.href = BASE_URL + 'configurar';
}

async function verifyTotem() {
    const raw = localStorage.getItem('cantina_totem');
    let totem = null;
    try { totem = raw ? JSON.parse(raw) : null; } catch (e) {}

    if (!totem || !totem.id) {
        clearTotemAndRedirect();
        return false;
    }

    try {
        const res = await fetch(CANTINA_URL + 'api/totens/' + totem.id, {
            headers: { 'X-API-Key': API_KEY },
        });
        if (!res.ok) {
            clearTotemAndRedirect();
            return false;
        }
    } catch (e) {
        clearTotemAndRedirect();
        return false;
    }

    return true;
}
