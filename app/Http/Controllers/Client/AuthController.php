<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'username' => 'Tên đăng nhập hoặc email',
            'password' => 'Mật khẩu',
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('message', 'Tên đăng nhập, email hoặc mật khẩu không đúng')->withInput();
        }

        Auth::login($user, $request->filled('remember'));

        if ($user->role === 1) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'gender' => 'required|in:0,1,2',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute phải là email hợp lệ',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'confirmed' => 'Xác nhận mật khẩu không khớp',
            'unique' => ':attribute đã tồn tại',
            'in' => ':attribute không hợp lệ',
        ], [
            'fullname' => 'Họ tên',
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'gender' => 'Giới tính',
            'password' => 'Mật khẩu',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => 2,
            'status' => 1,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công. Chào mừng bạn!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
