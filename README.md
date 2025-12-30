# Laravel + Vue Components Tutorial

This project demonstrates how to use **Vue 3 as components inside a Laravel application** (non-SPA, without Inertia).

---

## Requirements

- PHP 8.1 or higher  
- Composer  
- Node.js & npm  
- Database (MySQL / PostgreSQL / SQLite)

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/kiroroMirae/laravel-vue-tutorial.git
cd laravel-vue-tutorial
```

---

### 2. Install Dependencies

```bash
composer install
npm install
```

---

### 3. Create Environment File

Copy the example environment file:

```bash
cp .env.example .env
```

Update the database credentials inside the `.env` file.

---

### 4. Generate Application Key

```bash
php artisan key:generate
```

---

### 5. Run Database Migrations

```bash
php artisan migrate
```

---

### 6. Run the Application

```bash
npm run dev
php artisan serve
```

**OR**

```bash
composer run dev
```

---

## Notes

- Laravel handles routing and backend logic  
- Vue is used only as components  
- This project does not use Vue Router or Inertia  

---

## License

This project is intended for internal training and educational purposes.
