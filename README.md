# Installation


### Preparation
+ cp .env.example .env
+ *edit this file for connection to the database*
+ *edit this file for connection to the google drive*


### Console
- composer install
- npm install
- php artisan key:generate
- php artisan migrate --seed
- php artisan jwt:secret
- php artisan cache:clear
- php artisan config:clear

### Run this application
- npm run watch
- php artisan serve
