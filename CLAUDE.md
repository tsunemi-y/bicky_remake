# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Language Preference

**Default language: Japanese (日本語)**
- All communication should be in Japanese unless explicitly requested otherwise
- Code comments should be in Japanese
- Variable names and function names should use English for technical consistency
- Documentation and explanations should be in Japanese

## Project Overview

This is a Laravel + React TypeScript reservation system for child therapy/training services. The project is currently migrating from traditional Blade templates to a React SPA architecture (branch: `feature/replace_to_react`).

## Key Commands

### Development
- `npm run watch` - Watch and compile TypeScript/React files during development
- `php artisan serve` - Start Laravel development server
- `php artisan migrate` - Run database migrations
- `php artisan migrate:refresh --seed` - Reset database with fresh migrations and seed data

### Build and Assets
- Asset compilation: TypeScript → JavaScript via Laravel Mix
- Frontend entry point: `resources/ts/index.tsx` compiles to `public/js/index.js`
- Build configuration: `webpack.mix.js`

## Architecture Overview

### Hybrid Laravel + React SPA
- **Backend**: Laravel 8 API with JWT authentication
- **Frontend**: React 18 + TypeScript SPA served from Laravel
- **Authentication**: Multi-guard system (session for web, JWT for API)
- **Database**: MySQL with Eloquent ORM

### Directory Structure
```
app/
├── Http/Controllers/User/     # User-facing API endpoints
├── Http/Controllers/Admin/    # Admin panel controllers
├── Services/                  # Business logic layer
├── Repositories/              # Data access layer
└── Models/                    # Eloquent models

resources/ts/
├── features/user/             # Feature-based organization
│   ├── components/            # Reusable UI components
│   ├── pages/                 # Page components
│   └── services/              # API service layer
├── services/                  # Global services
├── App.tsx                    # Root component
└── router.tsx                 # Route configuration
```

### Authentication System
- **Multi-guard**: web (session), api (JWT), admin (session)
- **JWT Implementation**: tymon/jwt-auth with localStorage on frontend
- **User Model**: Implements JWTSubject interface
- **API Routes**: Protected with `auth:api` middleware

### Database Schema
Key tables:
- `users` - Parent/guardian information
- `children` - Child entities (new normalized structure)
- `reservations` - Appointment bookings
- `courses` - Service/course definitions
- `available_reservation_datetimes` - Time slot availability
- `admins` - Administrative users

## Technology Stack

### Backend
- Laravel 8 with Fortify authentication
- External integrations: Google Calendar API, LINE Bot SDK
- PDF generation: barryvdh/laravel-dompdf
- Email services via Laravel Mail

### Frontend
- React 18 + TypeScript 5
- Material-UI v7 for components
- React Hook Form + Zod validation
- TanStack React Query for state management
- React Router DOM v6
- FullCalendar for scheduling

## Development Patterns

### Backend Patterns
- Repository pattern for data access
- Service layer for business logic
- Form Request classes for validation
- Multi-tenancy with separate user/admin authentication

### Frontend Patterns
- Feature-based architecture (organized by domain)
- Service layer for API abstraction
- Component co-location (styles alongside components)
- Type-safe API interfaces

## Current Migration State

The project is actively migrating from Blade templates to React:
- Legacy Blade routes and views are commented out in `webpack.mix.js`
- SPA entry point: `resources/views/user/top.blade.php`
- New React components in `resources/ts/features/user/`
- Some legacy JavaScript files still exist in `public/js/` and `resources/js/`

## External Services Configuration

### Google Calendar Integration
- Service account credentials in `storage/app/api-key/`
- Configuration in `config/services.php`

### LINE Bot Integration
- LINE Bot SDK for messaging
- Used for consultation notifications

### Email Services
- Laravel Mail for reservation confirmations
- PDF receipts generation

## Important Notes

- The system uses Japanese language for UI and business logic
- Database migrations show evolution from denormalized (child data in users table) to normalized structure (separate children table)
- JWT tokens are stored in localStorage for API authentication
- The application serves both user-facing and admin interfaces
- Current branch suggests active development on React migration