<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $users = User::orderBy('fullname')->get();
        return view('admin.post.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'status' => 'required|in:0,1',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Post::create($request->only([
            'title',
            'slug',
            'content',
            'image',
            'status',
            'user_id',
        ]));

        return redirect('/admin/post')->with('success', 'Đã thêm Post mới.');
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $users = User::orderBy('fullname')->get();
        return view('admin.post.edit', compact('post', 'users'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'status' => 'required|in:0,1',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $post->update($request->only([
            'title',
            'slug',
            'content',
            'image',
            'status',
            'user_id',
        ]));

        return redirect('/admin/post')->with('success', 'Đã cập nhật Post.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/admin/post')->with('success', 'Đã xóa Post.');
    }
}
