<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Danh mục sản phẩm
        $categories = Category::where('status', 1)
            ->withCount('products')
            ->take(8)
            ->get();
        
        // Sản phẩm mới nhất
        $newProducts = Product::where('status', 1)
            ->select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'slug')
            ->with('images', 'category', 'brand')
            ->latest()
            ->take(8)
            ->get();
        
        // Sản phẩm giảm giá
        $saleProducts = Product::where('status', 1)
            ->select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'slug')
            ->where('pricediscount', '>', 0)
            ->with('images', 'category', 'brand')
            ->latest()
            ->take(8)
            ->get();
        
        return view('client.home.index', [
            'categories' => $categories,
            'newProducts' => $newProducts,
            'saleProducts' => $saleProducts,
        ]);
    }
}
