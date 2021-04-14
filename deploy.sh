git reset --hard
git pull origin master
composer install --ignore-platform-reqs
/opt/php74/bin/php artisan config:clear
/opt/php74/bin/php artisan cache:clear
/opt/php74/bin/php artisan config:cache
/opt/php74/bin/php artisan view:clear