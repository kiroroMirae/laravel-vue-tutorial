Laravel + Vue Components Tutorial

This project demonstrates how to use Vue 3 as components inside a Laravel application (non-SPA, without Inertia).

Requirements

PHP 8.1 or higher
Composer
Node.js & npm
Database (MySQL / PostgreSQL / SQLite)

Installation
1. Clone the Repository

git clone https://github.com/kiroroMirae/laravel-vue-tutorial.git
cd laravel-vue-tutorial

2. Install Dependencies

composer install
npm install

3. Create Environment File

Copy the example environment file:
cp .env.example .env

Update the database credentials inside the .env file.

4. Generate Application Key
php artisan key:generate

5. Run Database Migrations
php artisan migrate

6. Run the Application

npm run dev
php artisan serve

or 

composer run dev
