<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(RoleMiddleware::class . ':admin');
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
