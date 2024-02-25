## A FinTech API for Airtime and utility bills. 

### About Tulo API

This is the backend API to:

- Purchase Airtime and data 
    - MTN
    - Airtel
    - Glo
    - 9Mobile

- Renew your CableTv Subscription 
    - DSTV
    - GoTV
    - Startimes

- Pay your electricity bills

We collect Payment with [Paystack](https://paystack.com)

## Language and Framework

This project was developed using the [Laravel 10.x](https://laravel.com) PHP framework.

## How to run the application

- Clone this repository

- Copy the `.env.example` to `.env` file on your root directory.

- Setup the database connection

- Install `Composer`

    ```
    composer install
    ```

- Generate the application key

    ```
    php artisan key:generate
    ```

- Migrate and seed the database

    ```
    php artisan migrate:fresh --seed
    ```

- To run the project

    ```
    php artisan serve
    ```
    > This command will run the application on localhost:8000 or 127.0.0.1:8000 on your browser

### For Docker

- Initialize the project

    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```
- To run docker containers
    - Laravel 10
    - MySQL 8.0
    - PHPMyAdmin
    - Mailhog

    ```
    ./vendor/bin/sail up -d
    ```

- Then run the following commands

    ```
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```
    or run the root-shell

    ```
    ./vendor/bin/sail root-shell
    ```
    Then,

    ```
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```
    > The application runs on `localhost` on the browser.

- To bring down the containers

    ```
    ./vendor/bin/sail down
    ```

## API Documentation

This application has been documented using Postman Here.

> Coming soon.

## Run the tests

- To run the test, simply

    ```
    php artisan test
    ```

    or

    ```
    ./vendor/bin/pest
    ```

- &#128526;

