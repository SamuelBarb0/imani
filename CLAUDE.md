# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Imani Magnets** is a Laravel 12 e-commerce application for custom photo magnets. The site features a modern design with Tailwind CSS v4, custom brand fonts, and a responsive layout optimized for selling personalized magnets, collections, and wholesale orders.

## Development Commands

### Initial Setup
```bash
composer setup          # Full setup: install deps, copy .env, generate key, migrate, build assets
```

### Development Workflow
```bash
composer dev            # Start all services concurrently (server, queue, logs, Vite)
                       # Runs: artisan serve + queue:listen + pail + npm run dev

php artisan serve      # Start only the Laravel development server (http://127.0.0.1:8000)
npm run dev            # Start only Vite dev server for frontend assets
```

### Building Assets
```bash
npm run build          # Build production assets with Vite
```

### Testing
```bash
composer test          # Run PHPUnit tests (clears config first)
php artisan test       # Alternative: run tests directly
vendor/bin/phpunit tests/Unit/SpecificTest.php  # Run single test file
```

### Code Quality
```bash
vendor/bin/pint        # Format code using Laravel Pint (PHP CS Fixer)
```

### Common Laravel Commands
```bash
php artisan route:list          # View all registered routes
php artisan migrate            # Run database migrations
php artisan migrate:fresh      # Drop all tables and re-run migrations
php artisan make:controller ProductController --resource
php artisan make:model Product -m  # Create model with migration
php artisan cache:clear        # Clear application cache
php artisan config:clear       # Clear config cache
php artisan view:clear         # Clear compiled view cache
```

## Architecture & Structure

### Frontend Stack
- **Laravel 12** with Blade templates
- **Vite** for asset bundling (configured in [vite.config.js](vite.config.js))
- **Tailwind CSS v4** using `@tailwindcss/vite` plugin
- **Custom fonts**: Above the Beyond Script/Serif (local OTF files in `public/Demo_Fonts/`)
- **Google Fonts**: League Spartan (headings) and Open Sans (body text)

### View Architecture
The application uses a component-based Blade structure:

- **Layout**: [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php) - Base layout with top banner, navbar, content area, and footer
- **Reusable Components**:
  - [components/navbar.blade.php](resources/views/components/navbar.blade.php) - Main navigation with brand colors
  - [components/footer.blade.php](resources/views/components/footer.blade.php) - Footer with social links
  - [components/instagram-grid.blade.php](resources/views/components/instagram-grid.blade.php) - Instagram feed grid
- **Page Views**: Located in feature directories (`home/`, `personalizados/`, etc.)

All routes are currently closure-based in [routes/web.php](routes/web.php) - when adding backend logic, create controllers instead of keeping route closures.

### Styling System

**Brand Colors** (defined in [tailwind.config.js](tailwind.config.js)):
- `dark-turquoise`: #12463c (primary brand color)
- `dark-turquoise-alt`: #003a2f
- `gray-brown`: #5c533b
- `gray-orange`: #c2b59b (buttons and accents)

**Typography Hierarchy**:
- `font-spartan`: League Spartan - Use for headings and navigation
- `font-sans`: Open Sans - Use for body text and paragraphs
- `font-script`: Above the Beyond Script - Use for decorative/cursive text only
- `font-serif`: Above the Beyond Serif - Use sparingly for elegant headings

Custom font faces are loaded via `@font-face` in [resources/css/app.css](resources/css/app.css) and reference OTF files in `public/Demo_Fonts/`.

### Key Features
1. **Hero Slideshow**: Auto-rotating image carousel with manual controls (home page)
2. **Instagram Grid**: 4x2 grid with hover effects showing social proof
3. **WhatsApp Float Button**: Fixed position contact button
4. **Responsive Design**: Mobile-first with breakpoint at 768px

### Database
- Default: SQLite (see `.env.example`)
- Standard Laravel migrations for users, jobs, cache in `database/migrations/`
- No product models exist yet - these need to be created when building e-commerce functionality

## Important Notes

### Asset Loading
- **Vite**: Use `@vite(['resources/css/app.css', 'resources/js/app.js'])` in Blade templates
- **Public assets**: Reference via `asset()` helper, e.g., `{{ asset('images/logo.png') }}`
- Custom fonts are in `public/Demo_Fonts/` and loaded via `resources/css/app.css`

### Routes & Views
All routes are defined in [routes/web.php](routes/web.php). Route structure:
- `/` → home page
- `/personalizados` → custom magnets
- `/colecciones` → magnet collections
- `/mayoristas` → wholesale
- `/gift-card`, `/contacto`, `/carrito`, `/cuenta`, `/buscar`, `/faq`
- `/politica-devolucion`, `/politica-privacidad`

Most views beyond `home/index.blade.php` and `personalizados/index.blade.php` are not yet created.

### Tailwind CSS v4 Specifics
This project uses Tailwind v4 with the new Vite plugin (`@tailwindcss/vite`). Key differences:
- CSS imports use `@import "tailwindcss";` instead of `@tailwind` directives
- Configuration in [tailwind.config.js](tailwind.config.js) extends theme colors and fonts
- PostCSS config ([postcss.config.js](postcss.config.js)) includes autoprefixer

### Development Environment
- Uses XAMPP (Windows environment based on path structure)
- PHP 8.2+ required (see [composer.json](composer.json))
- SQLite for simple local development
- Queue connection set to `database` (requires `queue:listen` to process jobs)

## Future Development Considerations

When building out e-commerce functionality:
1. Create Product, Collection, Order models with proper relationships
2. Implement shopping cart using sessions or database
3. Add authentication controllers (currently just placeholder routes)
4. Integrate payment gateway (Stripe/PayPal)
5. Build admin panel for product management
6. Add image upload functionality for custom magnets
7. Implement proper SEO meta tags in layout
8. Optimize images in `public/images/` for production

## Testing Strategy
- PHPUnit configured for unit and feature tests ([phpunit.xml](phpunit.xml))
- Test environment uses SQLite in-memory database
- No existing tests - create feature tests for cart, checkout, and product functionality
- Unit test recommendation: test price calculations, discount logic, order totals
