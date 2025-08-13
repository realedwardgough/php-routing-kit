<?php

namespace App\Config;

class View
{
    private static ?Template $engine = null;
    
    /**
     * Initialize the template engine
     */
    public static function init(): void
    {
        if (self::$engine === null) {
            self::$engine = new Template(
                dirname(__DIR__) . '/views',
                dirname(__DIR__) . '/views/layouts',
                dirname(__DIR__) . '/views/components',
                dirname(dirname(__DIR__)) . '/storage/cache/views'
            );
        }
    }
    
    /**
     * Render a view
     */
    public static function make(string $view, array $data = [], ?string $layout = null): string
    {
        self::init();
        return self::$engine->render($view, $data, $layout);
    }
    
    /**
     * Share data globally
     */
    public static function share(string $key, mixed $value): void
    {
        self::init();
        self::$engine->share($key, $value);
    }
    
    /**
     * Clear view cache
     */
    public static function clearCache(): void
    {
        self::init();
        self::$engine->clearCache();
    }
    
    /**
     * Get the template engine instance
     */
    public static function engine(): Template
    {
        self::init();
        return self::$engine;
    }
}