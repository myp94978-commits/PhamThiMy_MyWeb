<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminRandomPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mật khẩu mới của bạn')
            ->greeting('Xin chào!')
            ->line('Bạn đã yêu cầu đặt lại mật khẩu.')
            ->line('Mật khẩu ngẫu nhiên mới của bạn là: '.$this->password)
            ->line('Vui lòng đăng nhập và đổi mật khẩu ngay sau khi vào hệ thống.')
            ->line('Nếu bạn không yêu cầu mật khẩu mới, hãy bỏ qua email này.');
    }

    public function toArray($notifiable)
    {
        return [
            'password' => $this->password,
        ];
    }
}
