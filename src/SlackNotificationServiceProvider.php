<?php

namespace Alanrites\ProdSlackNotification;

use Illuminate\Support\ServiceProvider;

class SlackNotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'prodslacknotify');
        $this->app->bind('slacknotification', function($app) {
            return new SlackNotification();
        });
    }

    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('prodslacknotify.php'),
            ], 'config');
        }
    }
}