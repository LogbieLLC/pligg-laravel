# Pligg to Laravel 11 Migration

This project is a modernization effort to migrate the Pligg Content Management System to Laravel 11. The migration preserves core functionality while modernizing the architecture using Laravel best practices.

## Directory Structure Mapping

### Core Directories

| Pligg Directory | Laravel Directory | Purpose |
|-----------------|------------------|----------|
| `libs/`         | `app/Models`, `app/Services` | Core business logic, models, and services |
| `modules/`      | `app/Modules` | Modular system extensions |
| `widgets/`      | `app/View/Components` | UI components as Blade components |
| `templates/`    | `resources/views` | View templates (migrated to Blade) |
| `languages/`    | `lang/` | Multilingual configurations |
| `plugins/`      | `app/Plugins` | Template and functionality extensions |
| `admin/`        | `app/Http/Controllers/Admin` | Administrative interface |
| `internal/`     | Various Laravel directories | Core system functionality |

### Specific Component Mappings

#### User Management (`libs/user.php`)
- User model → `app/Models/User.php`
- Authentication → Laravel Sanctum/Fortify
- User profiles → `app/Models/Profile.php`
- Social connections → `app/Models/Friendship.php`

#### Content System
- Links/Stories → `app/Models/Content.php`
- Categories → `app/Models/Category.php`
- Tags → `app/Models/Tag.php`
- Comments → `app/Models/Comment.php`
- Votes → `app/Models/Vote.php`

#### Social Features
- Groups → `app/Models/Group.php`
- Messages → `app/Models/Message.php`
- Karma system → `app/Services/KarmaService.php`

#### Template System
- Template_Lite → Laravel Blade
- Custom plugins → Blade components/directives
- Widget system → Blade components
- Caching → Laravel view caching

#### Module System
- Module loading → Laravel service providers
- Module routes → Route service providers
- Module configs → Config files
- Module hooks → Laravel events/listeners

### Database Structure
The database structure will be migrated using Laravel migrations and Eloquent ORM:
- All tables modernized with timestamps
- Foreign key constraints enforced
- Pivot tables following Laravel conventions
- Legacy table prefixes removed

### Configuration
- `settings.php` → `.env` and config files
- Module configs → Individual config files
- Cache settings → Laravel cache config

## Development Guidelines

1. Follow PSR-12 coding standards
2. Use Laravel's built-in features over custom implementations
3. Implement proper dependency injection
4. Use Laravel's security features
5. Write PHPUnit tests for all components

## Migration Progress

- [x] Initial Laravel 11 project setup
- [x] Directory structure mapping
- [ ] Database migration
- [ ] Model creation
- [ ] Authentication system
- [ ] Template conversion
- [ ] Module system adaptation
- [ ] Testing and validation

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
