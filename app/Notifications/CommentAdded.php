<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\TwilioSMSChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentAdded extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail', TwilioSMSChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(setting('website_name').' | '.($this->comment->reply_on ? 'رد' : 'تعليق') .' جديد')
                    ->line(
                        ($this->comment->reply_on ? 'رد' : 'تعليق') . 
                        ' جديد' . 
                        ' على الاعلان "' . 
                        $this->comment->commentable->title . '"'
                    )
                    ->action('فتح الاعلان', route('listings.show', $this->comment->commentable->slug));
    }

    public function toMessage($notifiable)
    {
        return [
            'مرحبا بك!', 
            ' ',
            ($this->comment->reply_on ? 'رد' : 'تعليق') . ' جديد' . ' على الاعلان "' . $this->comment->commentable->title . '"',
            url($this->comment->commentable->url()),
            ' ',
            'مع التحية,',
            setting('website_name')
        ];
    }

    public function toTwilioSMS($notifiable)
    {
        return $this->toMessage($notifiable);
    }

    public function toChatApiWhatsApp($notifiable)
    {
        return $this->toMessage($notifiable);
    }
}
