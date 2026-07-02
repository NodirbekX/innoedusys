<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class InnoEduSysVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Email manzilingizni tasdiqlang — InnoEduSys LMS')
            ->greeting('Assalomu alaykum, ' . $notifiable->name . ' 👋')
            ->line('InnoEduSys LMS platformasiga ro‘yxatdan o‘tganingiz uchun rahmat.')
            ->line('Hisobingizni faollashtirish va tizimdan foydalanishni boshlash uchun emailingizni tasdiqlang.')
            ->action('Emailni tasdiqlash', $verificationUrl)
            ->line('Agar siz ro‘yxatdan o‘tmagan bo‘lsangiz, ushbu xatni e’tiborsiz qoldiring.')
            ->salutation('Hurmat bilan, InnoEduSys LMS jamoasi');
    }
}
