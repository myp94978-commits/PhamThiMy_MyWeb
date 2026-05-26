<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = ["Bài viết 1", "Bài viết 2", "Bài viết 3"];
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        return "Bạn vừa thêm Post: " . $title;
    }

    public function show($id)
    {
        return "Chi tiết Post có ID: " . $id;
    }

    public function edit($id)
    {
        return view('admin.post.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $title = $request->input('title');
        return "Post có ID $id đã được cập nhật thành: " . $title;
    }

    public function destroy($id)
    {
        return "Xóa Post có ID: " . $id;
    }
}
