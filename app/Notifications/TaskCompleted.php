<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var
     */
    private $output;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed   $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];
        if ($notifiable->notification_email_address) {
            $channels[] = 'mail';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed                                            $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($notifiable->description)
            ->greeting('你好,')
            ->salutation(' ')
            ->line("{$notifiable->description} 刚刚运行完成!")
            ->line($this->output);
    }
}
