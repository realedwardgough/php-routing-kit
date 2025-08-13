<?php

namespace App\Config;

class View
{
    private static ?TemplateEngine $engine = null;
    
    /**
     * Initialize the template engine
     */
    public static function init(): void
    {
        if (self::$engine === null) {
            self::$engine = new TemplateEngine(
                dirname(__DIR__) . '/Views',
                dirname(__DIR__) . '/Views/Layouts',
                dirname(__DIR__) . '/Views/Components',
                dirname(__DIR__) . '/Storage/Cache/Views'
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
    public static function engine(): TemplateEngine
    {
        self::init();
        return self::$engine;
    }
}