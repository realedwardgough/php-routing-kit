<?php

namespace App\Controllers;

use App\Config\View;

class LoadController
{
    public function index()
    {
        // Share global data (available in all views)
        View::share('siteName', 'My Laravel-like App');
        View::share('user', ['name' => 'John Doe', 'email' => 'john@example.com']);
        
        // Render view with layout
        return View::make('pages.home', [
            'title' => 'Welcome Home',
            'message' => 'This is the home page',
            'items' => ['Item 1', 'Item 2', 'Item 3']
        ], 'app');
    }
    
    public function dashboard()
    {
        return View::make('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => [
                'users' => 150,
                'orders' => 45,
                'revenue' => 12500
            ]
        ], 'admin');
    }
    
    /**
     * Example of rendering without layout
     */
    public function partial()
    {
        return View::make('partials.user-info', [
            'user' => ['name' => 'Jane Doe', 'role' => 'Admin']
        ]);
    }
    
    /**
     * Example with JSON response
     */
    public function api()
    {
        header('Content-Type: application/json');
        
        $data = [
            'status' => 'success',
            'message' => 'API endpoint working',
            'view' => View::make('components.api-response', ['status' => 'active'])
        ];
        
        return json_encode($data);
    }
}