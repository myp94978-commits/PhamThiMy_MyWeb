<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminRandomPasswordNotification;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        // Kiểm tra xem đã đăng nhập chưa thì chuyển hướng về Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(\Illuminate\Http\Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        // bổ sung thêm một số rules bước khác - nếu có
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'username' => 'Tên đăng nhập hoặc email',
            'password' => 'Mật khẩu',
        ]);

        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Tên đăng nhập hoặc email không tồn tại')
                ->withInput();
        }
        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        // dùng Hash::check() để so sánh
        $check = Hash::check($request->password, $user->password); // true hoặc false
        if (!$check) {
            // Nếu mật khẩu không đúng
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }

        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        // Nếu người dùng được yêu cầu đổi mật khẩu thì chuyển hướng tới trang đổi mật khẩu
        if ($user->force_change_password) {
            return redirect()->route('admin.change-password')
                ->with('message', 'Bạn cần đổi mật khẩu tạm thời vừa được gửi qua email.');
        }

        // ... Nếu không có sự định hướng về URL mà người dùng muốn truy cập
        // được khai báo trước (route name dashboard được khai báo trong web.php)
        return redirect()->intended(route('admin.dashboard'));
    }

    // Đăng xuất
    public function logout(\Illuminate\Http\Request $request)
    {
        // Đăng xuất user
        Auth::logout();

        // Xóa session hiện tại
        $request->session()->invalidate();

        // Tạo lại CSRF token mới
        $request->session()->regenerateToken();

        // Redirect về trang đăng nhập
        return redirect()->route('admin.login');
    }

    // Hiển thị trang đổi mật khẩu
    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    // Xử lý đổi mật khẩu
    public function postChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'confirmed' => 'Xác nhận mật khẩu không khớp',
        ], [
            'old_password' => 'Mật khẩu cũ',
            'password' => 'Mật khẩu mới',
        ]);

        $user = User::findOrFail(Auth::id());
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('message', 'Mật khẩu cũ không đúng');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('message', 'Mật khẩu mới phải khác mật khẩu cũ');
        }

        $user->password = Hash::make($request->password);
        // Clear the force_change_password flag after successful update
        $user->force_change_password = 0;
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.users.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'action' => 'required|in:random_password,reset_link',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'action.required' => 'Vui lòng chọn hành động',
            'action.in' => 'Hành động không hợp lệ',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()
                ->with('message', 'Email không tồn tại')
                ->withInput();
        }


        // Tạo mật khẩu mới
        $passrandom = Str::random(10);
        // Mã hóa mật khẩu
        $passencrypted = Hash::make($passrandom);
        // Lưu vào DB
        $user->update([
            'password' => $passencrypted
        ]);




        // Nội dung email
        $html = "<h2>Mật khẩu mới của bạn là: $passrandom</h2>
        <p>Vui lòng đổi mật khẩu sau khi đăng nhập.</p>";
        // Gửi email
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
        });
        
        // điều hướng về page forgot kèm thông báo
        return back()
            ->with('message', 'Đã Gửi mật khẩu mới. Bạn vui lòng kiểm tra email của bạn');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute phải là email hợp lệ',
            'otp.digits' => 'OTP phải gồm 6 chữ số',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'confirmed' => 'Xác nhận mật khẩu không khớp',
            'exists' => ':attribute không tồn tại trong hệ thống',
        ], [
            'email' => 'Email',
            'token' => 'Token',
            'otp' => 'OTP',
            'password' => 'Mật khẩu mới',
        ]);

        $passwordsTable = config('auth.passwords.' . config('auth.defaults.passwords') . '.table');
        $user = User::where('email', $request->email)->firstOrFail();
        $tokenRecord = DB::table($passwordsTable)
            ->where('email', $request->email)
            ->first();

        /** @var PasswordBroker $broker */
        $broker = app('auth.password.broker');

        if (!$tokenRecord || ! $broker->tokenExists($user, $request->token)) {
            return back()->with('message', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        if (!isset($tokenRecord->otp) || $tokenRecord->otp !== $request->otp) {
            return back()->with('message', 'OTP không đúng.');
        }

        $expireMinutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
        if (Carbon::parse($tokenRecord->created_at)->addMinutes($expireMinutes)->isPast()) {
            return back()->with('message', 'Token hoặc OTP đã hết hạn. Vui lòng yêu cầu lại.');
        }

        $status = $broker->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập lại.');
        }

        return back()->with('message', trans($status));
    }
}
