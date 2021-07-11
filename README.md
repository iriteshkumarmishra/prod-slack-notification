# prod-slack-notification
Get notification in real time in your slack channel for exceptions

If you have Laravel Telescope installed, then you can use this package to trigger a notification to your Slack channel if any exception happens in your app in production.
It helps to find bugs and fix it before even your client reports it.

How To configure, What are the steps : 
1. Require this package. <composer require alanrites/prod-slack-notification>
2. Publish the config values <php artisan vendor:publish --provider="Alanrites\ProdSlackNotification\SlackNotificationServiceProvider" --tag="config">
3. Change prodslacknotify.php according to your need
4. Add a single line of code in your TelescopeServiceProvider.php inside Telescope::filter <SlackNotification::send($entry);>
