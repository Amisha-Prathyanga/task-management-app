# Task Manager Application

A comprehensive task management application built with Laravel that allows users to manage tasks, handle premium features, and export task data.

## Features

* Task Management (Create, Read, Update, Delete)
* Task status toggling (Complete/Incomplete)
* Advanced search and filtering capabilities
* Premium task management with payment integration
* Task export functionality
* Fully responsive design for all devices

## Requirements

* PHP >= 8.1
* Composer
* MySQL
* Node.js & NPM
* Laravel 10.x

## Installation

1. Clone the repository
```bash
git clone https://github.com/Amisha-Prathyanga/task-management-app.git
cd task-manager
```

2. Install PHP dependencies
```bash
composer install
```

3. Install and compile frontend dependencies
```bash
npm install
npm run dev
```

4. Configure environment variables
```bash
cp .env.example .env
```
Update the .env file with your database and payment gateway credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

5. Generate application key
```bash
php artisan key:generate
```

6. Run database migrations
```bash
php artisan migrate
```

7. Start the development server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Payment Integration

This application uses Stripe for payment processing. To enable payment features:

1. Create a Stripe account at https://stripe.com
2. Get your API keys from the Stripe dashboard
3. Update the `.env` file with your Stripe credentials
4. Test the payment system using Stripe's test card numbers

## Database Structure

The application uses the following main tables:

- `users` - User information
- `tasks` - Task details and status

## API Endpoints

The application provides the following API endpoints:

```
GET /tasks - Get all tasks
POST /api/tasks - Create a new task
PUT /tasks/{id} - Update a task
DELETE /tasks/{id} - Delete a task
PUT /tasks/{id}/complete - Toggle task status
POST /tasks/{id}/pay - Stripe payments
```

## Testing

Run the test suite using:
```bash
php artisan test
```

## Deployment

1. Set up your production environment
2. Configure your web server (Apache/Nginx)
3. Set appropriate permissions:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
4. Update environment variables for production
5. Run migrations and optimize:
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Contributing

1. Fork the repository
2. Create a new branch (`git checkout -b feature/improvement`)
3. Make your changes
4. Commit your changes (`git commit -am 'Add new feature'`)
5. Push to the branch (`git push origin feature/improvement`)
6. Create a Pull Request

## Security

If you discover any security-related issues, please email [your-email] instead of using the issue tracker.
