.PHONY: ;
.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ;              # skip prerequisite discovery

all: dep build
database: init-database
dep: dep-frontend dep-backend
build: build-frontend
test: build init-database test-acceptance test-frontend test-backend
fmt: fmt-frontend
upgrade: upgrade-frontend upgrade-backend
phpunit: test-backend
testcafe: test-acceptance
docker-run:
	docker-compose up -d
docker-stop:
	docker-compose stop
docker-down:
	docker-compose down
terminal:
	docker-compose exec app sh
start:
	app/clearcache
	rr serve -d
stop:
	rr stop
migrate:
	app/console migrations:migrate
dep-frontend:
	(cd frontend &&	npm install --silent)
dep-backend:
	env COMPOSER_MEMORY_LIMIT=-1 composer update --no-interaction
build-frontend:
	(cd frontend &&	env NODE_ENV=production npm run build)
init-database:
	app/clearcache
	app/console database:drop
	app/console database:create
	app/console migrations:migrate -n
	app/console database:insert-fixtures
watch-frontend:
	(cd frontend &&	env NODE_ENV=development npm run watch)
test-frontend:
	$(info Running JS unit tests...)
	(cd frontend &&	env NODE_ENV=development npm run test)
test-acceptance:
	$(info Running acceptance tests in Chromium headless...)
	(cd frontend &&	npm run test-chromium)
test-chrome:
	$(info Running acceptance tests in Chrome...)
	(cd frontend &&	npm run test-chrome)
test-remote:
	$(info Running acceptance tests in remote browsers...)
	(cd frontend &&	npm run test-remote)
test-backend:
	bin/phpunit
test-backend-coverage:
	bin/phpunit --coverage-html ./storage/coverage
lint-frontend:
	(cd frontend &&	npm run lint)
fmt-frontend:
	(cd frontend &&	npm run fmt)
upgrade-frontend:
	(cd frontend &&	npm --depth 2 update)
upgrade-backend:
	composer update
clearcache:
	app/clearcache
clean:
	rm -f *.cache
	rm -f *.log
	rm -rf node_modules
	rm -rf frontend/node_modules
	app/clearcache