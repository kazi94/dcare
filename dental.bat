@Echo Off
Echo Connexion a application
CD C:\laragon/www/dental
Echo Lancement de application
php artisan serve --host=0.0.0.0 --port=81
Pause
Exit