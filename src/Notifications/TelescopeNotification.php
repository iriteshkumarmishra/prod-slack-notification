<?php

namespace Alanrites\ProdSlackNotification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class TelescopeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $_slackMsgContent;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($telescopeEntry) 
    {
        $this->_slackMsgContent = $telescopeEntry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        $message = $this->_slackMsgContent;
        $appUrl = url('/');
        $telescopeLink = null;
        switch($message->type) {
            case 'exception':
                $telescopeLink = $appUrl . '/telescope/exceptions/' . $message->uuid;
                break;
            case 'request':
                $telescopeLink = $appUrl . '/telescope/requests/' . $message->uuid;
                break;
            case 'job':
                $telescopeLink = $appUrl . '/telescope/jobs/' . $message->uuid;
                break;
            case 'schedule':
                $telescopeLink = $appUrl . '/telescope/schedule/' . $message->uuid;
                break;
        }
        $slackMsg = isset($telescopeLink) ? $telescopeLink : json_encode($message);
        return (new SlackMessage)
                ->from(config('prodslacknotify.from_name'), ':bug:')
                ->to(config('prodslacknotify.slack_channel_name'))
                ->content('Exception or Failed request in ' . $appUrl . '. See details : ' .$slackMsg);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}