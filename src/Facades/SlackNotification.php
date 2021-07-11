<?php

namespace Alanrites\ProdSlackNotification\Facades;

use Illuminate\Support\Facades\Facade;

class SlackNotification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'slacknotification';
    }
}