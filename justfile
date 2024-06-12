default: dev

dev:
    php artisan serve & pnpm run dev

install:
    rm -rf node_modules/ pnpm-lock.yaml vendor/ composer.lock; \
    pnpm install; \
    composer install;

ssr:
    find resources/ *.ts *.js | entr -s 'rm -rf bootstrap/ssr/ && pnpm run build && php artisan inertia:start-ssr'

lint-php:
    find app/ resources/ routes/ database/ tests/ phpstan.neon | entr -s 'composer run lint'

lint-js:
    find resources/ *.ts *.js biome.json | entr -s 'pnpm run lint'

test:
    find app/ resources/ routes/ database/ tests/ phpstan.neon | entr -s 'composer run test'

remigrate:
    php artisan migrate:fresh --seed

ci:
    composer run check && pnpm run check

prepare:
    git config core.hookspath .githooks
