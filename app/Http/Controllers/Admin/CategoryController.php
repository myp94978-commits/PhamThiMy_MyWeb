<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
{
    $list = DB::table('categories')
        ->select('cateid', 'catename', 'status', 'slug')
        ->where('status', 1)
        
        ->orderBy('catename')
        ->get();

    return view('admin.categories.index', compact('list'));
}

    public function create()
   {
    return view('admin.categories.create');
}

    public function store(Request $request)
{
    DB::table('categories')->insert([
     'catename' => $request->catename,
     'slug' => $request->slug
]);

    return redirect()->route('admin.categories.index');
}
    public function show($id)
    {
       
    }

    public function edit($id)
{
    $item = DB::table('categories')
        ->where('cateid', $id)
        ->first();

    return view('admin.categories.edit', compact('item'));
}

    public function update(Request $request, $id)
{
    DB::table('categories')
        ->where('cateid', $id)
        ->update([
            'catename' => $request->catename,
            'slug' => $request->slug,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

    return redirect()->route('admin.categories.index');
}

    public function destroy($id)
{
    DB::table('categories')
        ->where('cateid', $id)
        ->delete();

    return redirect()->route('admin.categories.index');
}
}

