This is simple short url management tool (Laravel)
Laravel version 12
mysql
php 8

Setup instructions 

1) create laravel project 
   "composer create-project laravel/laravel example-app"

2) run "cd example-app"


3) Delete composer.lock file

4) run "composer require laravel/jetstream"
5) configure .env file to connect to mysql database

6) run "php artisan jetstream:install livewire"
7) Copy content of this repo and paste in root folder of laravel project
8) run "composer install"
9) run "php artisan migrate"
10) run "php artisan db:seed"
    
 

Login as super admin
email : superadmin@email.com
password : password

Test 
1) Run "php artisan test --filter=ShortUrlTest"

   
