## Simple Laravel API

Rest API
Build on Laravel 10

## Project setup native way

6, 9, 10 - optional

1. `git clone <repository_url> <folder_name>`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. `php artisan jwt:secret`
6. `npm install`
7. Add details to `.env` file
8. `php artisan migrate`
9. `php artisan storage:link`
10. Make sure `storage/app/public` is read and writable

## Explanation of how to test the API endpoint.

1. Use any APi client like Postman
2. Choose `POST` request 
3. Enter API endpoint URL `http://{your_address_here}/api/submit`
4. Setup `Headers` 
5. `Accept` => `application/json`
6. `Content-Type` => `application/json`
7. Select `Body`
8. Choose `raw` type input
9. Use simple test data to test `{
   "name": "John Doe",
   "email": "john.doe@example.com",
   "message": "This is a test message."
   }` OR use `php artisan test`
