<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EmailVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url($verificationUrl))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    protected function verificationUrl($notifiable)
    {
        $frontendUrl = config( 'http://0.0.0.0');
        $signedUrl = URL::temporarySignedRoute('verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        $signature = parse_url($signedUrl, PHP_URL_QUERY); // Получаем строку параметров из URL
        parse_str($signature, $queryParamsArray); // Разбираем строку параметров в массив
        $queryParams = [
            'id' => $notifiable->getKey(), // ID пользователя
            'hash' => sha1($notifiable->getEmailForVerification()), // Хеш email
            'expires' => Carbon::now()->addMinutes(60)->timestamp, // Время истечения ссылки
            'signature' => $queryParamsArray['signature'] ?? '',];


        // Создаём ссылку для Vue-компонента
        return $frontendUrl . '/verify-email?' . http_build_query($queryParams);
    }


}
