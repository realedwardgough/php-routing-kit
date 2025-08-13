<?php

namespace App\Config;


// config/view.php
return [
    'paths' => [
        'views' => 'Views',
        'layouts' => 'Views/Layouts',
        'components' => 'Views/Components',
        'cache' => 'Storage/Cache/Views'
    ],
    
    'cache_enabled' => true,
    
    'file_extension' => '.blade.php'
];

// bootstrap/app.php (Add this to your bootstrap file)
require_once __DIR__ . '/../vendor/autoload.php';

// Initialize view sharing for global data
use App\Helpers\View;

// Share common data across all views
View::share('year', date('Y'));
View::share('env', $_ENV['APP_ENV'] ?? 'production');

// You can also add middleware-like functionality
class ViewMiddleware
{
    public static function handle()
    {
        // Share user data if authenticated
        if (isset($_SESSION['user'])) {
            View::share('currentUser', $_SESSION['user']);
        }
        
        // Share flash messages
        if (isset($_SESSION['flash'])) {
            View::share('flash', $_SESSION['flash']);
            unset($_SESSION['flash']);
        }
    }
}

// Example usage in your routing or before controller execution
ViewMiddleware::handle();

// Enhanced Route Helper (Optional addition to your existing routing)
class Route
{
    public static function view(string $uri, string $view, array $data = [], ?string $layout = null)
    {
        global $router;
        
        $router->get($uri, function() use ($view, $data, $layout) {
            return View::make($view, $data, $layout);
        });
    }
}

// Usage examples for the Route helper:
// Route::view('/about', 'pages.about', ['title' => 'About Us'], 'app');
// Route::view('/terms', 'legal.terms', [], 'simple');

// Console command for clearing view cache (optional)
if (php_sapi_name() === 'cli') {
    class ViewCommand
    {
        public static function clearCache()
        {
            View::clearCache();
            echo "View cache cleared successfully.\n";
        }
    }
    
    // Usage: php artisan view:clear (if you implement an artisan-like command system)
}

// Error handling for views
set_exception_handler(function($exception) {
    if ($exception instanceof Exception && strpos($exception->getMessage(), 'View file not found') !== false) {
        // Handle missing view files gracefully
        http_response_code(404);
        
        try {
            echo View::make('errors.404', ['message' => $exception->getMessage()], 'app');
        } catch (Exception $e) {
            // Fallback if even error view is missing
            echo "<h1>404 - Page Not Found</h1><p>" . htmlspecialchars($exception->getMessage()) . "</p>";
        }
    } else {
        // Handle other exceptions
        http_response_code(500);
        
        try {
            echo View::make('errors.500', ['exception' => $exception], 'app');
        } catch (Exception $e) {
            echo "<h1>500 - Internal Server Error</h1>";
            if ($_ENV['APP_DEBUG'] ?? false) {
                echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
            }
        }
    }
});

// Helper functions (global functions you can use anywhere)
if (!function_exists('view')) {
    function view(string $view, array $data = [], ?string $layout = null): string
    {
        return View::make($view, $data, $layout);
    }
}

if (!function_exists('component')) {
    function component(string $component, array $data = []): string
    {
        return View::engine()->renderComponent($component, $data);
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = null): mixed
    {
        return $_SESSION['old'][$key] ?? $default;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

// Advanced Template Engine with Slots (Laravel-like component slots)
namespace App\Templating;

class ComponentEngine extends TemplateEngine
{
    private array $slots = [];
    
    /**
     * Enhanced component rendering with slots
     */
    public function renderComponent(string $component, array $data = []): string
    {
        $componentPath = $this->getComponentPath($component);
        
        if (!file_exists($componentPath)) {
            throw new \Exception("Component file not found: {$componentPath}");
        }
        
        // Extract slots from data
        $slot = $data['slot'] ?? '';
        unset($data['slot']);
        
        // Merge global data
        $data = array_merge($this->globalData, $data, ['slot' => $slot]);
        
        $compiled = $this->compile(file_get_contents($componentPath), $componentPath);
        $cacheFile = $this->getCacheFile($componentPath);
        file_put_contents($cacheFile, $compiled);
        
        return $this->renderCompiled($cacheFile, $data);
    }
}