<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\WhatsAppChatApiChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        return ['mail', WhatsAppChatApiChannel::class];
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

    public function toWhatsApp($notifiable)
    {
        return [
            'مرحبا بك!', 
            '',
            ($this->comment->reply_on ? 'رد' : 'تعليق') . ' جديد' . ' على الاعلان "' . $this->comment->commentable->title . '"',
            url($this->comment->commentable->url()),
            '',
            'مع التحية,',
            setting('website_name')
        ];
    }
}
