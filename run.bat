@Echo Off
Echo Connexion a application
CD C:\laragon/www/dental
php artisan config:cache
Echo Cache de l'application...
php artisan storage:link
Echo Lancement de application
php artisan serve
Pause
Exit