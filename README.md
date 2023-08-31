Dokumentasi Rest Api
 - https://documenter.getpostman.com/view/26360687/2s9Y5bQ1rX

Config : 
- git clone https://github.com/dandyazidant/logical-develop-test.git
- cd logical-develop-test
- composer install
- npm install
- cp .env.example .env
- - lakukan perubahan file .env seperti ini:
  - DB_CONNECTION=pgsql
  - DB_HOST=127.0.0.1
  - DB_PORT=5432
  - DB_DATABASE=development (sesuaikan nama databasenya)
  - DB_USERNAME=postgres (sesuaikan username)
  - DB_PASSWORD=123 (sesuaikan password)
- php artisan key:generate
- php artisan config:cache
- php artisan migrate
- php artisan storage:link
- - Terakhir jalankan 2 perintah berikut :
  - php artisan serve
  - npm run dev

 Run Unit test:
 masuk ke directory utama kemudian ketik vendor/bin/phpunit

 LOGICAL TEST
- http://localhost:8000/logic
