# Taskit - A simple task management application

## Prerequisites

- [PHP](https://www.php.net/) (8.2 or higher)
- [Composer](https://getcomposer.org/)

## Installation

```bash
# Clone the repository
git clone https://github.com/andgith/taskit.git
cd taskit

# Install dependencies
composer install
npm i

# Copy the .env.example file
cp .env.example .env

# Generate a new application key
php artisan key:generate

# Seed the database
php artisan migrate --seed

# Compile and serve assets
npm run dev

# Serve the application locally
php artisan serve

```
Visit http://localhost:8000 in your browser.

A test user will be seeded with the following credentials:

```
Username: test@taskit.test
Password: password
```

## Testing

```bash
php artisan test
```

## Overview
Taskit is a simple task management application built with Laravel. 
It allows users to create, update and complete tasks.

Tasks can be optionally provided with a description, due date and priority.

Laravel Livewire is used to provide a more interactive user experience which is important to task management application as positive reinforcement is key to productivity. 

Livewire would also allow features such as custom ordering which would be inefficient to implement with traditional blade components.

Laravel events are used to send motivational notifications when a user competes a pinned task. Notifications are queued to prevent any delays in the application UI.

Laravel Filament has been utilized to provide an admin panel for managing users. This provides a chart with a history of new users over the past 12 months.

