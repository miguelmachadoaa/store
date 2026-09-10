start:
	php -S localhost:8000 -t public & \
	npm.cmd run dev & \
	php artisan queue:work

PHP=/opt/cpanel/ea-php84/root/usr/bin/php