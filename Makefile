.PHONY: install
install : ; \
    composer install

.PHONY: lint
lint : phpcs phpstan psalm

.PHONY: phpcs
phpcs : ; \
    vendor/bin/phpcs

.PHONY: phpcsf
phpcsf: ; \
	vendor/bin/php-cs-fixer fix src

.PHONY: phpstan
phpstan : ; \
	vendor/bin/phpstan

.PHONY: psalm
psalm : ; \
	vendor/bin/psalm

.PHONY: phpunit
phpunit : ; \
	vendor/bin/phpunit

.PHONY: test
test : phpunit

