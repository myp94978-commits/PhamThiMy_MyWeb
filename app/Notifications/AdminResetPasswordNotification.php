<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token;
    public int $otp;

    public bool $sendEmailVerify = false;

    public function __construct(string $token, int $otp)
    {
        $this->token = $token;
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu')
            ->greeting('Xin chào!')
            ->line('Bạn nhận được email này vì đã yêu cầu đặt lại mật khẩu.')
            ->line('Mã OTP của bạn là: **'.$this->otp.'**')
            ->action('Đặt lại mật khẩu', $resetUrl)
            ->line(__('Liên kết này chỉ có hiệu lực trong :count phút.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]))
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.');
    }

    public function toArray($notifiable)
    {
        return [
            'token' => $this->token,
        ];
    }
}
