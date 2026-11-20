# Smart URL – URL Shortener & Analytics Platform

A web-based URL shortening platform that allows users to convert long URLs into short, shareable links and monitor their performance through an analytics dashboard.

## Features

### Authentication
- User registration and login.
- Secure authentication.
- User-specific URL management.

### URL Management
- Generate short URLs from long URLs.
- View all generated URLs in a dashboard.
- Copy short URLs with a single click.
- Manage generated URLs.
- View individual URL details.

### Analytics Dashboard
- Track URL clicks.
- View URL performance statistics.
- Analyze click activity.
- View analytics for individual short URLs.

## Application Workflow

1. Register or log in to the application.
2. Access the user dashboard.
3. Enter a long URL to generate a short URL.
4. View generated URLs in the URL listing table.
5. Copy and share the generated short URL.
6. View analytics to understand link performance.

## Technology Stack

- Backend: PHP, Laravel
- Database: MySQL
- Frontend: Laravel Blade


## Installation

Clone the repository:

```bash
git clone https://github.com/ravigurupackiyam/smart-url.git
cd smart-url
```

Install dependencies:

```bash
composer install
```

Configure environment:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in the `.env` file.

Run migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

Open the application at:

`http://127.0.0.1:8000`

## Screenshots

Add application screenshots here:

- Login and Registration
- Dashboard
- URL Generation
- URL Listing
- Analytics Dashboard

## Project Purpose

This project demonstrates practical implementation of authentication, URL management, redirection, database relationships, click tracking and analytics in a Laravel application.
