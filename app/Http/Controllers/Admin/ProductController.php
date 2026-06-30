<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
   public function index($limit = 10)
{
    $list = Product::with([
        'category:cateid,catename',
        'brand:id,brandname'
    ])
    ->select(
        'id',
        'productname',
        'price',
        'image',
        'status',
        'cateid',
        'brandid'
    )
    ->orderBy('productname')
    ->paginate($limit);

    return view('admin.product.index', compact('list'));
}
    public function create()
{
    $categories = Category::select('cateid', 'catename')->get();
    $brands = Brand::select('id', 'brandname')->get();

    return view('admin.product.create', compact('categories', 'brands'));
}

   public function store(ProductRequest $request)
{
    try {

        Product::create([
            'productname'   => $request->productname,
            'slug'          => $request->slug,
            'cateid'        => $request->cateid,
            'brandid'       => $request->brandid,
            'price'         => $request->price,
            'pricediscount' => $request->pricediscount ?? 0,
            'description'   => $request->description,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Thêm sản phẩm thành công');

    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
    public function show($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

   public function edit($id)
{
    $product = Product::find($id);

    $categories = Category::all();

    $brands = Brand::all();

    return view('admin.product.edit',
    compact('product','categories','brands'));
}

  public function update(ProductRequest $request, string $id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }

        $product->update([
            'productname'   => $request->productname,
            'slug'          => $request->slug,
            'cateid'        => $request->cateid,
            'brandid'       => $request->brandid,
            'price'         => $request->price,
            'pricediscount' => $request->pricediscount,
            'status'        => $request->status,
            'description'   => $request->description
        ]);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Cập nhật sản phẩm thành công');

    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}    public function destroy($id)
{
    try {

        $product = Product::findOrFail($id);

        $product->delete();

        return redirect('/admin/product')
            ->with('success', 'Đã xóa sản phẩm thành công.');

    } catch (\Exception $e) {

        return redirect('/admin/product')
            ->with('error', $e->getMessage());
    }
}
    public function test1(): RedirectResponse
    {
        return redirect()->route('admin.home');
    }

    public function test2(): RedirectResponse
    {
        return redirect('/admin/dashboard');
    }
}
