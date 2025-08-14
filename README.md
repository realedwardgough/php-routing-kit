# PHP Routing Kit

A lightweight PHP routing system inspired by Laravel's elegant structure. This kit provides a simple yet powerful way to handle routing, views, and components in PHP applications without the overhead of a full framework.

## Features

- **Laravel-inspired Architecture**: Familiar structure for developers coming from Laravel
- **Flexible Routing**: Handle routes individually or group them with prefixes
- **URL Parameters**: Handle dynamic parameters via the URI
- **Wildcard Routes**: Support for catch-all routes and 404 error handling
- **View System**: Create and manage views with layouts, components, and partials
- **Blade-like Templates**: Support for template inheritance and components
- **Clean Structure**: Organized folder structure for maintainable code
- **Caching Support**: Built-in view caching for improved performance
- **Docker Support**: Containerized development environment included

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
│       ├── example.blade.php
│       └── 404.blade.php # 404 error page
├── storage/
│   └── cache/
│       └── views/        # Cached compiled views
├── docker-compose.yml    # Docker configuration
└── Dockerfile           # Docker image definition
```

## Quick Start

### Installation

#### Option 1: Standard Installation

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

#### Option 2: Docker Installation

1. **Clone the repository**

   ```bash
   git clone git@github.com:realedwardgough/php-routing-kit.git
   cd php-routing-kit
   ```

2. **Build and run with Docker**
   ```bash
   docker-compose up --build
   ```

The application will be available at `http://localhost:8080`

### Basic Usage

#### Defining Routes

**Individual Routes** (src/Routes/web.php):

```php
<?php

namespace App\Routes;

use App\Config\View;

// Simple route with closure
$router->get('/php-routing-kit/public', function(){
   echo View::make('home', [], 'example-layout');
});

// Route with URL parameter
$router->get('/page/{id}', function($id = 0){
   echo View::make('example-with-parameter', ['id' => $id], 'example-layout');
});

// Route with multiple parameters
$router->get('/user/{id}/posts/{slug}', function($id = 0, $slug = ''){
   echo View::make('user-post', ['userId' => $id, 'postSlug' => $slug], 'example-layout');
});

// Wildcard route for 404 handling (should be placed last)
$router->get('*', function(){
   http_response_code(404);
   echo View::make('404', [], 'example-layout');
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

   // Admin route with parameter
   $router->get('/user/{id}', function($id = 0){
      echo View::make('admin.user', ['userId' => $id], 'admin-layout');
   });
});

// API routes example
$router->group('/api', function ($router) {
   $router->get('/posts', function(){
      // Return JSON response
      header('Content-Type: application/json');
      echo json_encode(['posts' => []]);
   });

   // API route with parameter
   $router->get('/post/{id}', function($id = 0){
      header('Content-Type: application/json');
      echo json_encode(['post' => ['id' => $id]]);
   });
});
```

#### Creating Views

**Basic View** (src/Views/home.blade.php):

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

**View with Parameter** (src/Views/example-with-parameter.blade.php):

```php
@extends('example-layout')

@section('content')
   <div class="container">
      <h1>Page Details</h1>
      <p>Page ID: {{ $id }}</p>

      @if($id > 0)
         <div class="content">
            <h2>Content for Page {{ $id }}</h2>
            <p>This is the content for page with ID {{ $id }}.</p>
         </div>
      @else
         <p>No valid page ID provided.</p>
      @endif
   </div>
@endsection
```

**404 Error Page** (src/Views/404.blade.php):

```php
@extends('example-layout')

@section('title', 'Page Not Found')

@section('content')
   <div class="container error-page">
      <div class="error-content">
         <h1>404</h1>
         <h2>Page Not Found</h2>
         <p>The page you're looking for doesn't exist.</p>
         <div class="cta">
            <a href="/" class="btn btn-primary">Go Home</a>
         </div>
      </div>
   </div>
@endsection
```

**Layout** (src/Views/layouts/Layout-Example.blade.php):

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
- Parameter handling
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

### Complete Route Definition (src/Routes/web.php)

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

// Dynamic pages with parameters
$router->get('/blog/{slug}', function($slug = ''){
   // In a real application, you'd fetch the post from a database
   $post = ['title' => ucfirst($slug), 'content' => 'Content for ' . $slug];
   echo View::make('blog.post', ['post' => $post], 'example-layout');
});

// User profile with ID
$router->get('/profile/{id}', function($id = 0){
   if ($id == 0) {
      http_response_code(400);
      echo View::make('error', ['message' => 'Invalid user ID'], 'example-layout');
      return;
   }

   $user = ['id' => $id, 'name' => 'User ' . $id];
   echo View::make('profile', ['user' => $user], 'example-layout');
});

// Admin section
$router->group('/admin', function ($router) {
   $router->get('/dashboard', function(){
      echo View::make('admin.dashboard', [], 'admin-layout');
   });

   $router->get('/users', function(){
      $users = ['John', 'Jane', 'Bob'];
      echo View::make('admin.users', ['users' => $users], 'admin-layout');
   });

   $router->get('/user/{id}', function($id = 0){
      $user = ['id' => $id, 'name' => 'Admin User ' . $id];
      echo View::make('admin.user-detail', ['user' => $user], 'admin-layout');
   });
});

// API routes
$router->group('/api', function ($router) {
   $router->get('/status', function(){
      header('Content-Type: application/json');
      echo json_encode(['status' => 'ok', 'timestamp' => time()]);
   });

   $router->get('/user/{id}', function($id = 0){
      header('Content-Type: application/json');
      echo json_encode(['user' => ['id' => $id, 'name' => 'API User ' . $id]]);
   });
});

// 404 handler - MUST be placed last
$router->get('*', function(){
   http_response_code(404);
   echo View::make('404', [], 'example-layout');
});
```

### Example View with Data (src/Views/admin/users.blade.php)

```php
@extends('admin-layout')

@section('content')
   <div class="admin-header">
      <h1>User Management</h1>
   </div>

   <div class="user-list">
      @if(!empty($users))
         @foreach($users as $index => $user)
            <div class="user-card">
               <h3>{{ $user }}</h3>
               <a href="/admin/user/{{ $index + 1 }}">View Details</a>
            </div>
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
echo View::make('blog-post', ['id' => $id, 'title' => $title], 'blog-layout');
```

**Parameters:**

- `$viewName`: The view file name (without .blade.php extension)
- `$data`: Array of data to pass to the view
- `$layout`: Layout file to extend (optional)

## URL Parameters

URL parameters are defined using curly braces `{}` in your route patterns:

```php
// Single parameter
$router->get('/user/{id}', function($id){
   // $id contains the value from the URL
});

// Multiple parameters
$router->get('/category/{category}/post/{id}', function($category, $id){
   // Both parameters are available
});

// Optional parameters with defaults
$router->get('/page/{id}', function($id = 1){
   // $id defaults to 1 if not provided
});
```

## Wildcard Routes

Wildcard routes use the `*` pattern and are typically used for 404 error handling:

```php
// Catch-all route for 404 errors
$router->get('*', function(){
   http_response_code(404);
   echo View::make('404', [], 'example-layout');
});
```

**Important:** Wildcard routes should always be placed at the end of your route definitions to ensure they don't override specific routes.

## Docker Usage

The project includes Docker support for easy development setup:

### Docker Commands

```bash
# Build and start the container
docker-compose up --build

# Start in detached mode
docker-compose up -d

# Stop the container
docker-compose down

# View logs
docker-compose logs

# Rebuild after changes
docker-compose up --build --force-recreate
```

### Docker Configuration

The Docker setup includes:

- PHP 8.1 with Apache
- Composer for dependency management
- All necessary PHP extensions
- Automatic volume mounting for live development

## Requirements

- PHP 7.4 or higher
- Composer
- Web server with URL rewriting support
- Docker & Docker Compose (for containerized development)

## Completed Features

- ✅ **URL Parameters**: Handle parameters via the URI
- ✅ **Docker Setup**: Containerized development environment
- ✅ **Wildcard Routes**: Support for catch-all routes and 404 handling

## Upcoming Features

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
