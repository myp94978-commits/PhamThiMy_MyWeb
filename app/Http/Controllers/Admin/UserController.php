<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = ["Nguyễn Văn A", "Trần Thị B", "Lê Văn C"];
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        return "Bạn vừa thêm User: " . $name;
    }

    public function show($id)
    {
        return "Chi tiết User có ID: " . $id;
    }

    public function edit($id)
    {
        return view('admin.user.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        return "User có ID $id đã được cập nhật thành: " . $name;
    }

    public function destroy($id)
    {
        return "Xóa User có ID: " . $id;
    }
}
