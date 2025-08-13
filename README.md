# PHP Routing Kit

A lightweight PHP routing system inspired by Laravel's elegant structure. This kit provides a simple yet powerful way to handle routing, views, and components in PHP applications without the overhead of a full framework.

## Features

- **Laravel-inspired Architecture**: Familiar structure for developers coming from Laravel
- **Flexible Routing**: Handle routes individually or group them with prefixes
- **View System**: Create and manage views with layouts, components, and partials
- **Blade-like Templates**: Support for template inheritance and components
- **Clean Structure**: Organized folder structure for maintainable code
- **Caching Support**: Built-in view caching for improved performance

## Folder Structure

```
php-routing-kit/
├── public/
│   ├── index.php         # Entry point
│   └── .htaccess         # URL rewriting rules
├── src/
│   ├── Config/
│   │   ├── Route.php     # Route configuration
│   │   ├── Template.php  # Template engine
│   │   └── View.php      # View handler
│   ├── Controllers/
│   │   └── LoadController.php
│   ├── Routes/
│   │   ├── api.php       # API routes
│   │   └── web.php       # Web routes
│   └── Views/
│       ├── components/   # Reusable components
│       ├── layouts/      # Page layouts
│       ├── partials/     # Partial views
│       └── example.blade.php
└── storage/
    └── cache/
        └── views/        # Cached compiled views
```

## Quick Start

### Installation

1. **Clone the repository**

   ```bash
   git clone git@github.com:realedwardgough/php-routing-kit.git
   cd php-routing-kit
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Configure your web server**
   - Point your document root to the `public/` directory
   - Ensure URL rewriting is enabled (Apache: mod_rewrite, Nginx: try_files)

### Basic Usage

#### Defining Routes

**Individual Routes** (`src/Routes/web.php`):

```php
<?php

namespace App\Routes;

use App\Config\View;

// Simple route with closure
$router->get('/php-routing-kit/public', function(){
   echo View::make('home', [], 'example-layout');
});
```

**Grouped Routes** with prefixes:

```php
<?php
// Admin routes with prefix
$router->group('/admin', function ($router) {
   $router->get('/dashboard', function(){
      echo View::make('dashboard', [], 'example-layout');
   });

   $router->get('/users', function(){
      echo View::make('users', [], 'example-layout');
   });
});

// API routes example
$router->group('/api', function ($router) {
   $router->get('/posts', function(){
      // Return JSON response
      header('Content-Type: application/json');
      echo json_encode(['posts' => []]);
   });
});
```

#### Creating Views

**Basic View** (`src/Views/home.blade.php`):

```php
@extends('example-layout')
@section('content')
   <!-- Hero Section -->
   <section class="hero">
   <div class="container hero-grid">
      <div>
         <div class="eyebrow">
            <span class="dot"></span>
            <span>Launch faster with a beautiful baseline</span>
         </div>
         <h1>Make something people love.</h1>
         <p class="lead">A crisp, responsive starter you can brand in minutes. Swap the colors, drop in your copy, and ship your next idea without wrestling CSS.</p>
         <div class="cta">
            <a href="#pricing" class="btn btn-primary">Start free</a>
            <a href="#features" class="btn btn-ghost">Explore features</a>
         </div>
      </div>
      <div class="mock" role="img" aria-label="Interface mockup with gradient accents"></div>
   </div>
   </section>
@endsection
```

**Layout** (`src/Views/layouts/Layout-Example.blade.php`):

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PHP Routing Kit')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    <script src="/js/app.js"></script>
</body>
</html>
```

## Configuration

### Route Configuration

The routing system is configured through the `src/Config/Route.php` file. You can customize:

- Route patterns
- Middleware support
- Default controllers

### Template Configuration

Template settings are managed in `src/Config/Template.php`:

- View paths
- Caching options
- Template compilation settings

### View Configuration

View-specific settings in `src/Config/View.php`:

- Default layout
- Component directories
- Partial paths

## Real-World Examples

### Complete Route Definition (`src/Routes/web.php`)

```php
<?php

namespace App\Routes;

use App\Config\View;

// Homepage
$router->get('/', function(){
   echo View::make('home', [], 'example-layout');
});

// About page
$router->get('/about', function(){
   echo View::make('about', [], 'example-layout');
});

// Admin section
$router->group('/admin', function ($router) {
   $router->get('/dashboard', function(){
      echo View::make('admin.dashboard', [], 'admin-layout');
   });

   $router->get('/users', function(){
      // Example with data
      $users = ['John', 'Jane', 'Bob'];
      echo View::make('admin.users', ['users' => $users], 'admin-layout');
   });
});

// API routes
$router->group('/api', function ($router) {
   $router->get('/status', function(){
      header('Content-Type: application/json');
      echo json_encode(['status' => 'ok', 'timestamp' => time()]);
   });
});
```

### Example View with Data (`src/Views/admin/users.blade.php`)

```php
@extends('admin-layout')

@section('content')
   <div class="admin-header">
      <h1>User Management</h1>
   </div>

   <div class="user-list">
      @if(!empty($users))
         @foreach($users as $user)
            <div class="user-card">{{ $user }}</div>
         @endforeach
      @else
         <p>No users found.</p>
      @endif
   </div>
@endsection
```

### View Rendering

The View system uses the `View::make()` method to render templates:

```php
// Basic syntax
View::make($viewName, $data, $layout)

// Examples
echo View::make('home', [], 'example-layout');
echo View::make('user', ['name' => 'John'], 'example-layout');
echo View::make('dashboard', ['stats' => $stats], 'admin-layout');
```

**Parameters:**

- `$viewName`: The view file name (without .blade.php extension)
- `$data`: Array of data to pass to the view
- `$layout`: Layout file to extend (optional)

## Requirements

- PHP 7.4 or higher
- Composer
- Web server with URL rewriting support

## Upcoming Features

- 🔗 **URL Parameters**: Handle parameters via the URI
- 🐳 **Docker Setup**: Containerized development environment
- 🔐 **Middleware Support**: Authentication and authorization layers
- 📝 **Form Validation**: Built-in validation system
- 🗄️ **Database Integration**: Simple ORM or query builder
- ⚡ **Performance Optimizations**: Enhanced caching and routing performance

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

If you encounter any issues or have questions, please [open an issue](https://github.com/realedwardgough/php-routing-kit/issues) on GitHub.

---
