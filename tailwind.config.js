export default {
    content: [
        './resources/views/theme/**/*.blade.php',
        './resources/views/components/theme/**/*.blade.php',
        './resources/js/theme-demo.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
            },
            colors: {
                brand: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#0b1f4b',
                },
                surface: 'var(--color-surface)',
                bg: 'var(--color-bg)',
                'surface-alt': 'var(--color-surface-alt)',
                'surface-soft': 'var(--color-surface-soft)',
                text: 'var(--color-text)',
                'text-muted': 'var(--color-text-muted)',
                'text-subtle': 'var(--color-text-subtle)',
                border: 'var(--color-border)',
                'border-strong': 'var(--color-border-strong)',
                success: 'var(--color-success)',
                warning: 'var(--color-warning)',
                error: 'var(--color-error)',
                info: 'var(--color-info)',
            },
            boxShadow: {
                'soft-1': 'var(--shadow-soft-1)',
                'soft-2': 'var(--shadow-soft-2)',
                'soft-3': 'var(--shadow-soft-3)',
            },
        },
    },
};
