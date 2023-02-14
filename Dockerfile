FROM nlplay/apibasecontainer:8.0.0

COPY  ./kube/php/php.ini-production "$PHP_INI_DIR/php.ini"

# Copy code and run composer
COPY . /var/www/html
RUN cd /var/www/html && composer install  --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html/storage

RUN cd /var/www/html/ \
   && php artisan l5-swagger:generate \
   && composer dump-autoload

# test comment for initiate build container
# Ensure the entrypoint file can be run
RUN chmod +x /var/www/html/entrypoint-dev.sh
ENTRYPOINT ["/var/www/html/entrypoint-dev.sh"]

# The default apache run command
CMD ["apache2-foreground"]

