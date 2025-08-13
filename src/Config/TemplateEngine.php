<?php

namespace App\Config;

class TemplateEngine
{
    private string $viewsPath;
    private string $layoutsPath;
    private string $componentsPath;
    private string $cachePath;
    private array $globalData = [];
    private array $sections = [];
    private array $components = [];
    private $currentSection;
    
    public function __construct(
        string $viewsPath = __DIR__ . '/Views',
        string $layoutsPath = __DIR__ . '/Views/Layouts',
        string $componentsPath = __DIR__ . '/Views/Components',
        string $cachePath = __DIR__ . '/Storage/Cache/Views'
    ) {
        $this->viewsPath = rtrim($viewsPath, '/');
        $this->layoutsPath = rtrim($layoutsPath, '/');
        $this->componentsPath = rtrim($componentsPath, '/');
        $this->cachePath = rtrim($cachePath, '/');

        // Ensure cache directory exists
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
    
    /**
     * Render a view with optional layout
     */
    public function render(string $view, array $data = [], ?string $layout = null): string
    {
        $viewPath = $this->getViewPath($view);
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        // Merge global data with view data
        $data = array_merge($this->globalData, $data);
        
        // Compile and cache the view
        $compiled = $this->compile(file_get_contents($viewPath), $viewPath);
        $cacheFile = $this->getCacheFile($viewPath);
        file_put_contents($cacheFile, $compiled);
        
        // Render the view
        $content = $this->renderCompiled($cacheFile, $data);
        
        // If layout is specified, render within layout
        if ($layout) {
            return $this->renderLayout($layout, $content, $data);
        }
        
        return $content;
    }
    
    /**
     * Render a layout with content
     */
    private function renderLayout(string $layout, string $content, array $data): string
    {
        $layoutPath = $this->getLayoutPath($layout);
        
        if (!file_exists($layoutPath)) {
            throw new \Exception("Layout file not found: {$layoutPath}");
        }
        
        // Add content to data
        $data['content'] = $content;
        $data['sections'] = $this->sections;
        
        $compiled = $this->compile(file_get_contents($layoutPath), $layoutPath);
        $cacheFile = $this->getCacheFile($layoutPath);
        file_put_contents($cacheFile, $compiled);
        
        return $this->renderCompiled($cacheFile, $data);
    }
    
    /**
     * Compile template syntax to PHP
     */
    private function compile(string $template, string $filePath): string
    {
        // Start with raw template
        $compiled = $template;
        
        // Compile extends directive
        $compiled = preg_replace('/@extends\([\'"]([^\'"]+)[\'"]\)/', '<?php $this->layout = "$1"; ?>', $compiled);
        
        // Compile sections
        $compiled = preg_replace('/@section\([\'"]([^\'"]+)[\'"]\)/', '<?php $this->startSection("$1"); ?>', $compiled);
        $compiled = preg_replace('/@endsection/', '<?php $this->endSection(); ?>', $compiled);
        
        // Compile yields
        $compiled = preg_replace('/@yield\([\'"]([^\'"]+)[\'"](?:,\s*[\'"]([^\'"]*)[\'"])?\)/', '<?php echo $this->yieldSection("$1", "$2"); ?>', $compiled);
        
        // Compile includes
        $compiled = preg_replace('/@include\([\'"]([^\'"]+)[\'"](?:,\s*(\[.*?\]))?\)/', '<?php echo $this->include("$1", isset($2) ? $2 : []); ?>', $compiled);
        
        // Compile components
        $compiled = preg_replace('/@component\([\'"]([^\'"]+)[\'"](?:,\s*(\[.*?\]))?\)/', '<?php echo $this->renderComponent("$1", isset($2) ? $2 : []); ?>', $compiled);
        
        // Compile variable echoing {{ $var }}
        $compiled = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?php echo htmlspecialchars($1, ENT_QUOTES, "UTF-8"); ?>', $compiled);
        
        // Compile raw echoing {!! $var !!}
        $compiled = preg_replace('/\{!!\s*(.+?)\s*!!\}/', '<?php echo $1; ?>', $compiled);
        
        // Compile if statements
        $compiled = preg_replace('/@if\s*\((.+?)\)/', '<?php if($1): ?>', $compiled);
        $compiled = preg_replace('/@elseif\s*\((.+?)\)/', '<?php elseif($1): ?>', $compiled);
        $compiled = preg_replace('/@else/', '<?php else: ?>', $compiled);
        $compiled = preg_replace('/@endif/', '<?php endif; ?>', $compiled);
        
        // Compile foreach loops
        $compiled = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach($1): ?>', $compiled);
        $compiled = preg_replace('/@endforeach/', '<?php endforeach; ?>', $compiled);
        
        // Compile for loops
        $compiled = preg_replace('/@for\s*\((.+?)\)/', '<?php for($1): ?>', $compiled);
        $compiled = preg_replace('/@endfor/', '<?php endfor; ?>', $compiled);
        
        // Compile while loops
        $compiled = preg_replace('/@while\s*\((.+?)\)/', '<?php while($1): ?>', $compiled);
        $compiled = preg_replace('/@endwhile/', '<?php endwhile; ?>', $compiled);
        
        return $compiled;
    }
    
    /**
     * Render compiled PHP file
     */
    private function renderCompiled(string $cacheFile, array $data): string
    {
        extract($data);
        
        ob_start();
        include $cacheFile;
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Start a section
     */
    public function startSection(string $name): void
    {
        ob_start();
        $this->currentSection = $name;
    }
    
    /**
     * End a section
     */
    public function endSection(): void
    {
        if (isset($this->currentSection)) {
            $this->sections[$this->currentSection] = ob_get_clean();
            unset($this->currentSection);
        }
    }
    
    /**
     * Yield a section
     */
    public function yieldSection(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }
    
    /**
     * Include a partial view
     */
    public function include(string $view, array $data = []): string
    {
        return $this->render($view, $data);
    }
    
    /**
     * Render a component
     */
    public function renderComponent(string $component, array $data = []): string
    {
        $componentPath = $this->getComponentPath($component);
        
        if (!file_exists($componentPath)) {
            throw new \Exception("Component file not found: {$componentPath}");
        }
        
        // Merge global data
        $data = array_merge($this->globalData, $data);
        
        $compiled = $this->compile(file_get_contents($componentPath), $componentPath);
        $cacheFile = $this->getCacheFile($componentPath);
        file_put_contents($cacheFile, $compiled);
        
        return $this->renderCompiled($cacheFile, $data);
    }
    
    /**
     * Share data globally across all views
     */
    public function share(string $key, mixed $value): void
    {
        $this->globalData[$key] = $value;
    }
    
    /**
     * Get view file path
     */
    private function getViewPath(string $view): string
    {
        return $this->viewsPath . '/' . str_replace('.', '/', $view) . '.blade.php';
    }
    
    /**
     * Get layout file path
     */
    private function getLayoutPath(string $layout): string
    {
        return $this->layoutsPath . '/' . str_replace('.', '/', $layout) . '.blade.php';
    }
    
    /**
     * Get component file path
     */
    private function getComponentPath(string $component): string
    {
        return $this->componentsPath . '/' . str_replace('.', '/', $component) . '.blade.php';
    }
    
    /**
     * Get cache file path
     */
    private function getCacheFile(string $originalPath): string
    {
        return $this->cachePath . '/' . md5($originalPath) . '.php';
    }
    
    /**
     * Clear compiled view cache
     */
    public function clearCache(): void
    {
        $files = glob($this->cachePath . '/*.php');
        foreach ($files as $file) {
            unlink($file);
        }
    }
}