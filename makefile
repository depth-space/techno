i:
	- docker run -it --rm -v ${PWD}:/app composer i

update:
	- docker run -it --rm -v ${PWD}:/app composer update

style:
	- docker run -it --rm -w=/app -v ${PWD}:/app oskarstark/php-cs-fixer-ga --allow-risky=yes

stan:
	- docker run -it --rm -w=/app -v ${PWD}:/app oskarstark/phpstan-ga analyse -c phpstan.neon