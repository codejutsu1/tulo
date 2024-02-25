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
- Set the database connection
- Generate the application key
    ```
    php artisan key:generate
    ```
- Migrate and seed the database
    ```
    php artisan migrate --seed
    ```
- To run the project
    ```
    php artisan serve
    ```
    > This command will run the application on localhost:8000 or 127.0.0.1:8000 on your browser

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

