import { initTheme } from './theme';

const focusableSelector =
    'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])';

function setSidebar(open) {
    const sidebar = document.querySelector('[data-theme-sidebar]');
    const overlay = document.querySelector('[data-sidebar-overlay]');
    const toggle = document.querySelector('[data-sidebar-toggle]');
    if (!sidebar) return;

    sidebar.classList.toggle('-translate-x-full', !open);
    sidebar.classList.toggle('translate-x-0', open);
    if (overlay) overlay.classList.toggle('hidden', !open);
    if (toggle) toggle.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('overflow-hidden', open);
}

function openModal(modal) {
    if (!modal) return;
    modal.removeAttribute('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');

    const focusable = Array.from(modal.querySelectorAll(focusableSelector)).filter(
        (el) => !el.hasAttribute('disabled') && el.offsetParent !== null
    );
    const first = focusable[0];
    if (first) first.focus();

    modal._previouslyFocused = document.activeElement;
    modal._trapHandler = (event) => {
        if (event.key !== 'Tab') return;
        const items = Array.from(modal.querySelectorAll(focusableSelector)).filter(
            (el) => !el.hasAttribute('disabled') && el.offsetParent !== null
        );
        if (!items.length) return;
        const firstItem = items[0];
        const lastItem = items[items.length - 1];
        if (event.shiftKey && document.activeElement === firstItem) {
            event.preventDefault();
            lastItem.focus();
        } else if (!event.shiftKey && document.activeElement === lastItem) {
            event.preventDefault();
            firstItem.focus();
        }
    };
    modal.addEventListener('keydown', modal._trapHandler);
}

function closeModal(modal) {
    if (!modal) return;
    modal.setAttribute('aria-hidden', 'true');
    modal.setAttribute('hidden', '');
    document.body.classList.remove('overflow-hidden');
    if (modal._trapHandler) modal.removeEventListener('keydown', modal._trapHandler);
    if (modal._previouslyFocused && modal._previouslyFocused.focus) {
        modal._previouslyFocused.focus();
    }
}

function closeAllDropdowns() {
    document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => {
        menu.classList.add('hidden');
    });
    document.querySelectorAll('[data-dropdown-toggle]').forEach((toggle) => {
        toggle.setAttribute('aria-expanded', 'false');
    });
}

function bindThemeDemo() {
    document.addEventListener('click', (event) => {
        const sidebarToggle = event.target.closest('[data-sidebar-toggle]');
        if (sidebarToggle) {
            const open = sidebarToggle.getAttribute('aria-expanded') !== 'true';
            setSidebar(open);
            return;
        }

        const sidebarOverlay = event.target.closest('[data-sidebar-overlay]');
        if (sidebarOverlay) {
            setSidebar(false);
            return;
        }

        const modalOpen = event.target.closest('[data-modal-open]');
        if (modalOpen) {
            const id = modalOpen.getAttribute('data-modal-open');
            openModal(document.getElementById(id));
            return;
        }

        const modalClose = event.target.closest('[data-modal-close]');
        if (modalClose) {
            closeModal(modalClose.closest('[data-modal]'));
            return;
        }

        const modalOverlay = event.target.closest('[data-modal-overlay]');
        if (modalOverlay) {
            closeModal(modalOverlay.closest('[data-modal]'));
            return;
        }

        const dropdownToggle = event.target.closest('[data-dropdown-toggle]');
        if (dropdownToggle) {
            const dropdown = dropdownToggle.closest('[data-dropdown]');
            const menu = dropdown?.querySelector('[data-dropdown-menu]');
            if (!menu) return;
            const willOpen = menu.classList.contains('hidden');
            closeAllDropdowns();
            menu.classList.toggle('hidden', !willOpen);
            dropdownToggle.setAttribute('aria-expanded', String(willOpen));
            return;
        }

        if (!event.target.closest('[data-dropdown]')) {
            closeAllDropdowns();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            const openModalEl = document.querySelector('[data-modal][aria-hidden="false"]');
            if (openModalEl) {
                closeModal(openModalEl);
                return;
            }
            closeAllDropdowns();
            setSidebar(false);
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    bindThemeDemo();
});
