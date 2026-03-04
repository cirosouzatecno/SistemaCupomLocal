# Tema Azul Escuro (Laravel 10 + Blade + Tailwind v4)

Este tema é paralelo ao layout atual. As páginas demo estão em `/admin/tema` e exigem `auth:admin`.

## Instalação rápida
1. Instale as fontes (recomendado):
   - `npm install -D @fontsource/manrope @fontsource/jetbrains-mono`
2. Compile os assets:
   - `npm run dev` (ambiente local)
   - `npm run build` (produção)
3. Acesse:
   - `/admin/tema` (home)
   - `/admin/tema/dashboard`
   - `/admin/tema/itens`

## Estrutura do tema
- `resources/css/theme.css` — tokens, dark mode e utilitários
- `resources/js/theme-demo.js` — sidebar, modal e dropdown
- `resources/views/components/theme/` — componentes `x-theme.*`
- `resources/views/theme/pages/` — páginas demo
- `resources/lang/pt_BR/theme.php` — strings pt-BR
- `resources/tokens/theme.json` — design tokens
- `public/assets/theme/placeholder.svg` — placeholder para imagens

## Componentes disponíveis
- `x-theme.layout`
- `x-theme.header`
- `x-theme.navbar`
- `x-theme.sidebar`
- `x-theme.footer`
- `x-theme.card`
- `x-theme.button`
- `x-theme.input`
- `x-theme.select`
- `x-theme.textarea`
- `x-theme.checkbox`
- `x-theme.toggle`
- `x-theme.alert`
- `x-theme.table`
- `x-theme.pagination`
- `x-theme.modal`
- `x-theme.badge`
- `x-theme.icon`

## Acessibilidade
- Contraste AA garantido via tokens e texto em `text-text`.
- Estados de foco visíveis com `:focus-visible`.
- Labels sempre associados em inputs.
- Modal com `aria-hidden`, foco preso e fechamento por ESC.

## Performance
- Imagens devem usar `loading="lazy"` e `decoding="async"`.
- Prefira WebP/AVIF para novos assets.
- Ícones SVG inline para evitar requests extra.

## Dark mode
- Controlado por classe `dark` em `html`.
- O arquivo `resources/js/theme.js` gerencia a preferência do usuário.

## Observações
- O tema não altera as telas atuais.
- Strings de exemplo estão em `pt-BR`.
- Garanta `APP_LOCALE=pt_BR` no `.env` para ver os textos traduzidos.
