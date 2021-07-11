<?php

namespace Alanrites\ProdSlackNotification;

use Notification;
use Alanrites\ProdSlackNotification\Notifications\TelescopeNotification;

class SlackNotification
{
    protected $telescopeEntry;

    public function __construct()
    {
        // 
    }

    public function send($telescopeEntry)
    {
        if($telescopeEntry->isReportableException() || $telescopeEntry->isFailedRequest() || $telescopeEntry->isFailedJob()) {
            Notification::route('slack', config('prodslacknotify.slack_hook'))->notify(new TelescopeNotification($telescopeEntry));
        }
        return $telescopeEntry;
    }
}