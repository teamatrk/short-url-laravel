This is simple short url management tool (Laravel)
Laravel version 12
mysql
php 8

Setup instructions 

1) create laravel project 
   "composer create-project laravel/laravel example-app"

2) runb "cd example-app"

3) Copy content of this repo and paste in root folder of laravel project
4) Delete composer.lock file
5) run "composer install"

6) configure .env file to connect to mysql database
7) run "php artisan jetstream:install livewire"
8) run "php artisan migrate"
9) run "php db:seed"

Login as super admin
email : superadmin@email.com
password : password

Test 
1) Run "php artisan test --filter=ShortUrlTest"

   
