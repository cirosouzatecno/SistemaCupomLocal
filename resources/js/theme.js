/**
 * theme.js — Gerenciamento de tema claro/escuro
 *
 * Prioridade de preferência:
 *  1. localStorage  (persistência manual do usuário)
 *  2. Cookie        (fallback quando localStorage indisponível)
 *  3. prefers-color-scheme (padrão do sistema)
 */

const STORAGE_KEY = 'cupons-theme';

/* ── Leitura da preferência ─────────────────────────────────────────────────── */
export function getPreference() {
    // 1. localStorage
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored !== null) return stored === 'dark';
    } catch (_) { /* privado / bloqueado */ }

    // 2. Cookie fallback
    const cookie = document.cookie
        .split(';')
        .find(c => c.trim().startsWith(STORAGE_KEY + '='));
    if (cookie) return cookie.split('=')[1].trim() === 'dark';

    // 3. Sistema operacional
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

/* ── Verificação se o usuário definiu preferência manual ────────────────────── */
function hasManualPreference() {
    try {
        return localStorage.getItem(STORAGE_KEY) !== null;
    } catch (_) {
        return document.cookie.split(';').some(c => c.trim().startsWith(STORAGE_KEY + '='));
    }
}

/* ── Salva preferência ─────────────────────────────────────────────────────── */
function savePreference(dark) {
    const value = dark ? 'dark' : 'light';
    try {
        localStorage.setItem(STORAGE_KEY, value);
    } catch (_) {
        // Cookie de 1 ano como fallback
        document.cookie = `${STORAGE_KEY}=${value};path=/;max-age=31536000;SameSite=Lax`;
    }
}

/* ── Aplica tema ao documento ───────────────────────────────────────────────── */
export function applyTheme(dark) {
    document.documentElement.classList.toggle('dark', dark);
    document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');

    // Atualiza todos os botões de toggle na página
    document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
        btn.setAttribute('aria-pressed', String(dark));
        const icon  = btn.querySelector('[data-theme-icon]');
        const label = btn.querySelector('[data-theme-label]');
        if (icon)  icon.textContent  = dark ? '☀️' : '🌙';
        if (label) label.textContent = dark ? 'Modo claro' : 'Modo escuro';
    });
}

/* ── Alterna entre claro / escuro ───────────────────────────────────────────── */
export function toggleTheme() {
    const nowDark = !document.documentElement.classList.contains('dark');
    savePreference(nowDark);
    applyTheme(nowDark);
}

/* ── Inicialização ──────────────────────────────────────────────────────────── */
export function initTheme() {
    applyTheme(getPreference());

    // Acompanha mudança do sistema SOMENTE se não houver preferência manual
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!hasManualPreference()) applyTheme(e.matches);
    });

    // Delega clique em qualquer botão data-theme-toggle
    document.addEventListener('click', e => {
        if (e.target.closest('[data-theme-toggle]')) toggleTheme();
    });
}
