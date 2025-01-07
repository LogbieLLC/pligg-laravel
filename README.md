# Pligg Laravel Migration

This project is a modernization of the Pligg Content Management System, migrating it from its original PHP implementation to Laravel 11. The goal is to preserve the core functionality while leveraging modern Laravel features and best practices.

## Features

- User authentication with karma system
- Content submission and voting
- Category management
- Comment system
- Friend relationships
- Group functionality
- Private messaging
- Widget system
- Module system

## Technical Implementation

### Authentication
- Laravel Breeze for authentication scaffolding
- Enhanced User model with karma system
- Granular permission system
- Social media integration

### Security
- Stateless CSRF protection using JWT
- Modern password hashing
- XSS protection
- Rate limiting

### Database
- Eloquent ORM for all database operations
- Comprehensive migration system
- Efficient relationship mapping

## Installation

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment
3. Run `composer install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `npm install && npm run dev`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
