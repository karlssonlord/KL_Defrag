#!/bin/sh
vendor/bin/phpcbf --standard=vendor/leaphub/phpcs-symfony2-standard/leaphub/phpcs/Symfony2/ --extensions=php app/
vendor/bin/phpcs --standard=vendor/leaphub/phpcs-symfony2-standard/leaphub/phpcs/Symfony2/ --extensions=php app/
vendor/bin/parallel-lint app/
vendor/bin/phpcpd app/
