# Docker (Laravel)

Este projeto foi preparado para rodar em Docker com Nginx, PHP-FPM, MySQL e Redis.

## Subir o ambiente
1. Construa e suba os containers:
   - `docker compose up -d --build`
2. Acesse a aplicação:
   - http://localhost:8080
3. Vite (dev):
   - http://localhost:5173
4. MySQL (host):
   - porta 3307 (usuário `cupom`, senha `cupom`)

## Observações
- Variáveis do Docker ficam em `.env.docker`.
- O container `app` executa `composer install` e `php artisan migrate` automaticamente.
- Se quiser desativar migrations automáticas, ajuste `RUN_MIGRATIONS` no `docker-compose.yml`.

## Comandos úteis
- Logs:
  - `docker compose logs -f app`
- Entrar no container:
  - `docker compose exec app bash`
- Rodar migrations manualmente:
  - `docker compose exec app php artisan migrate --force`
- Rodar testes:
  - `docker compose exec app php artisan test`
