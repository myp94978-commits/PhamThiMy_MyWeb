<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display all products with filtering and pagination
     */
    public function index()
    {
        $query = Product::where('status', 1)
            ->with('images', 'category', 'brand');
        
        // Search
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('productname', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        // Category filter
        if (request('categories')) {
            $query->whereIn('cateid', request('categories'));
        }
        
        // Brand filter
        if (request('brands')) {
            $query->whereIn('brandid', request('brands'));
        }
        
        // Price range
        if (request('price_min')) {
            $query->where('price', '>=', request('price_min'));
        }
        if (request('price_max')) {
            $query->where('price', '<=', request('price_max'));
        }
        
        // Sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderByDesc('created_at');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        
        return view('client.product.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    
    /**
     * Display product detail by slug
     */
    public function show($slug)
    {
        $product = Product::select(
            'id',
            'cateid',
            'brandid',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description',
            'created_at'
        )
        ->with([
            'category:cateid,catename,slug',
            'brand:id,brandname',
            'images:id,product_id,image'
        ])
        ->where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

        $relatedProducts = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
        ->where('cateid', $product->cateid)
        ->where('id', '<>', $product->id)
        ->where('status', 1)
        ->take(4)
        ->get();

        return view('client.product.show', compact(
            'product',
            'relatedProducts'
        ));
    }
    
    /**
     * Filter products by category slug
     */
    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
        ->join('categories', 'products.cateid', 'categories.cateid')
        ->where('categories.slug', $slug)
        ->where('products.status', 1)
        ->paginate($limit);

        return view('client.product.category', compact('products'));
    }
    
    /**
     * Filter products by brand slug
     */
    public function brand($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'brands.brandname'
        )
        ->join('brands', 'products.brandid', 'brands.id')
        ->where('brands.slug', $slug)
        ->where('products.status', 1)
        ->paginate($limit);

        return view('client.product.brand', compact('products'));
    }
    
    /**
     * Search products
     */
    public function search()
    {
        $keyword = request('q');
        $sort = request('sort');
        $priceMin = request('price_min');
        $priceMax = request('price_max');

        if (!$keyword || strlen($keyword) < 2) {
            $products = Product::where('status', 1)
                ->whereRaw('1 = 0')
                ->paginate(12);

            return view('client.product.search', [
                'products' => $products,
                'keyword' => $keyword,
            ]);
        }

        $products = Product::where('status', 1)
            ->with('images', 'category', 'brand')
            ->whereRaw('LOWER(productname) LIKE ?', ['%' . mb_strtolower($keyword) . '%'])
            ->when($priceMin, function ($query, $priceMin) {
                return $query->where('price', '>=', $priceMin);
            })
            ->when($priceMax, function ($query, $priceMax) {
                return $query->where('price', '<=', $priceMax);
            })
            ->when($sort, function ($query, $sort) {
                switch ($sort) {
                    case 'name_asc':
                        return $query->orderBy('productname', 'asc');
                    case 'name_desc':
                        return $query->orderBy('productname', 'desc');
                    case 'price_asc':
                        return $query->orderBy('price', 'asc');
                    case 'price_desc':
                        return $query->orderBy('price', 'desc');
                    default:
                        return $query->orderByDesc('created_at');
                }
            }, function ($query) {
                return $query->orderByDesc('created_at');
            })
            ->paginate(12)
            ->withQueryString();

        return view('client.product.search', [
            'products' => $products,
            'keyword' => $keyword,
        ]);
    }
}
