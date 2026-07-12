<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class AdminProductController extends Controller
{
    public function test1(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function test2(): RedirectResponse
    {
        return redirect('/admin/dashboard');
    }
}
