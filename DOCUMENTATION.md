# Documentation
The doc is so organized:
* [Why Zanzara?]()
* [Get started]()

## Why Zanzara?
There is plenty of PHP libraries which help you write Telegram bots, so why use Zanzara?

#### Easy
We (developers) get annoyed easily, so if we are gonna make a Telegram Bot we want a working 
environment set up ```as soon as possible```. Unlike other libraries that require you to configure a database and mess
up with webhooks/https-server/cron-job, you can copy-paste the following snippet and it just works:
```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
```
Thanks to [ReactPHP](https://reactphp.org/), we can have a long-running process that
[pulls](https://core.telegram.org/bots/api#getupdates) updates from Telegram servers.

#### Asynchronous
Your bot interacts with Telegram through http requests, ```a lot of http requests```. Why wait for a message to
be sent before performing a database query? Zanzara provides a way to call every Telegram Api method asynchronously and
get the result with a React promise. For example:
```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage('Hello')->then(
        function (Message $message) {
            // success
        },
        function (ErrorResponse $error) {
            // failed
        }
    );
    // ... in the meantime perform some queries on MySql
});

$bot->run();
```
#### Middleware
Usually web applications delegate operations like authorization and internalization checks to ```middleware```. 
[ExpressJS](https://expressjs.com/en/guide/using-middleware.html) provides it,
[Laravel](https://laravel.com/docs/7.x/middleware) provides it, ```Zanzara``` provides it. Here a simple example:
```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$m = function(Context $ctx, $next) {
    // do something before
    $next($ctx);
    // do something after
};

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage('Hello');
})->middleware($m);

$bot->run();
```
#### No more 429 annoying errors

#### Step by step messages (conversations)

#### It's built on top of ReactPHP
Last but not least, you can take advantage of all [ReactPHP](https://reactphp.org/) features.

## Get started
Zanzara is a framework to build asynchronous Telegram bots in PHP.  
We suppose you're already familiar with [Telegram](https://core.telegram.org/bots) bots, PHP,
[Composer](https://getcomposer.org/) and that you've at least heard of [ReactPHP](https://reactphp.org/).  

#### Requirements
Just make sure to have PHP (>= 7.0) and [Composer](https://getcomposer.org/) installed on your machine.
  