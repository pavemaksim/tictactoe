# Tic Tac Toe

## Requirements

- PHP 7.0
- MongoDB 3.2
- Node.js 7.6
- NPM 4.6
- Composer

## Deploy

- Grab source code `git clone`
- Install project dependencies `composer install` and `npm install`
- Set up your env config file: `cp .env.example .env`
- Setup DB connection in `.env`
- Generate Laravel `API_KEY`: `php artisan key:generate`
- Compile assets by running `npm run dev` for dev environment or `npm run prod` for prod environment
- Set web server root to `public/index.php`. For dev environment you can
just use `php artisan serve`

## Testing

You have to install `phpunit`. To run all tests simply fire `phpunit` in a
project directory.
