<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalProducts' => Product::query()->count(),
            'totalCategories' => Category::query()->count(),
            'lowStockProducts' => Product::query()->where('stock', '<=', 5)->count(),
            'outOfStockProducts' => Product::query()->where('stock', 0)->count(),
            'latestProducts' => Product::query()->with('category')->latest()->limit(5)->get(),
        ]);
    }
}
