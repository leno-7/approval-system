# Laravel Filament Project

This is a Laravel project developed by **Leen Hani Alhazmi**. The system uses Filament as an admin panel for managing projects, contracts, financial records, and approvals.

## Features

* Laravel Framework
* Filament Admin Panel
* Arabic language support
* Project management system
* Contract management system
* Financial management system
* Approval workflow system

## System Requirements

* PHP 8.1+
* Composer
* Node.js & NPM
* MySQL or PostgreSQL

## Installation

1. Clone the repository:

```bash
git clone [repository-link]
cd my-project
```

2. Install PHP and JavaScript dependencies:

```bash
composer install
npm install
```

3. Copy the environment file:

```bash
cp .env.example .env
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Update the database configuration in the `.env` file.

6. Run the database migrations:

```bash
php artisan migrate
```

7. Build the frontend assets:

```bash
npm run build
```

8. Start the local development server:

```bash
php artisan serve
```

## Admin Panel Access

You can access the admin panel at:

```text
http://localhost:8000/admin
```

## Author

**Leen Hani Alhazmi**

## Contribution

Contributions are welcome. Please fork the repository and submit a pull request.

## License

This project is licensed under the MIT License.
