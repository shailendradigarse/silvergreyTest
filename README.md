# Laravel Project Setup

## Overview

This Laravel project includes functionality for **user registration**, **login**, and **profile management**. The application makes use of **APIs** that are called within Blade files using **AJAX**. Additionally, **jQuery** is used for form validation.

### Preventing API Calls from Non-Browser Clients

To enhance security and prevent unauthorized API access through tools like **Postman**, I have added a middleware named **BrowserCheck**. This middleware ensures that API calls are only allowed from web browsers by checking the **User-Agent** header of incoming requests.

## Prerequisites

1. **PHP** (version 8.0 or higher)
2. **Composer** (for managing PHP dependencies)
3. **MySQL** (or any other compatible database)

## Setup Instructions

### 1. Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/shailendradigarse/silvergreyTest.git
cd silvergreyTest
```

### 2. Install PHP Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

### Configure Environment Variables

1. **Create the .env File**:

Copy the example environment file to create a new .env file:

```bash
cp .env.example .env
```

2 **Set Up Database Configuration**:

Open the .env file and configure your database settings:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Make sure to replace your_database_name, your_database_username, and your_database_password with your actual database credentials.

 **Generate Application Key**:
Generate a new application key for the Laravel project:

```bash
php artisan key:generate
```

**Run Migrations**:
Run the database migrations to set up the necessary tables:

```bash
php artisan migrate
```

**Start PHP Server**:
Open a new terminal and start the PHP development server:

```bash
php artisan serve
```

The application will be accessible at http://127.0.0.1:8000 (or another port specified in the output).
