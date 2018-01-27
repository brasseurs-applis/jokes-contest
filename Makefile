test:
	vendor/bin/phpunit

show-coverage:
	open ./tests/output/coverage/index.html

metrics:
	rm -Rf tests/output/phpmetrics
	vendor/bin/phpmetrics ./src --report-html=tests/output/phpmetrics/index.html
	open ./tests/output/phpmetrics/index.html
