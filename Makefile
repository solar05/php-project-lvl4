install:
	composer install
	npm run dev
lint:
	composer run-script phpcs -- --standard=PSR12 tests app routes
test:
	composer run-script phpunit tests
run:
	php artisan serve
