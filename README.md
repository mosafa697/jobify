# Jobify

Jobify is a job board application built with Laravel. It allows companies to post job listings and candidates to apply for jobs. The application uses Laravel Passport for API authentication.

## Features

-   Company and Candidate registration and login.
-   Job posting and management for companies.
-   Job application submission for candidates.
-   Soft deletion and restoration of job posts.
-   API authentication using Laravel Passport.

## Prerequisites

Before running the application, ensure you have the following installed:

-   PHP 8.1 or higher
-   Composer
-   Node.js and npm
-   MySQL or another supported database
-   Laravel Passport (installed via Composer)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/your-repo/jobify.git
    cd jobify
    ```

2. Install PHP & JS dependencies:

    ```bash
    composer install
    ```

3. Copy the .env.example file to .env and configure your environment variables:

    ```bash
    cp .env.example .env
    ```

4. Execute the basic commands:

    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5. Install Laravel Passport:

    ```pash
    php artisan passport:install
    ```

## Running the Application

    ```pash
    php artisan serve
    ```

The application will be available at http://localhost:8000.

## Postman Collection

To simplify API testing, a Postman collection file generated and stored in the main dir. This collection includes all the API endpoints for the project.
