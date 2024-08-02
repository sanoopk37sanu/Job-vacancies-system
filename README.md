





## Installation

1. Clone the repository.
2. Copy .env.example into .env and configure your database credentials.
3. Run `composer install`
4. Set the application key by running `php artisan key:generate --ansi`.
5. Run migrations `php artisan migrate`
5. `php artisan db:seed --class=JobSeeder`
6. `php artisan db:seed --class=UserSeeder`
7. Run `npm install`..
8. Run `npm run build`.
9. Start local server by executing php artisan serve

