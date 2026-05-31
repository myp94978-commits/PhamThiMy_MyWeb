<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Post::create($request->only('title'));

        return redirect('/admin/post')->with('success', 'Đã thêm Post mới.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $post->update($request->only('title'));

        return redirect('/admin/post')->with('success', 'Đã cập nhật Post.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/admin/post')->with('success', 'Đã xóa Post.');
    }
}
