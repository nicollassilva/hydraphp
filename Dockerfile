FROM openswoole/swoole

RUN docker-php-ext-install mysqli pdo_mysql

COPY . /php_emulator

WORKDIR /php_emulator

RUN composer clearcache
RUN composer install
RUN composer dump-autoload

ENTRYPOINT ["php", "/php_emulator/bootstrap.php"]