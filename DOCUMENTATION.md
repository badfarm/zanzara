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
Have you ever got a ```429``` error from Telegram? It happens when you send ```too many messages``` to one or more chats. The
official Telegram [documentation]() encourage you to spread notifications over longer intervals. We do it for you, just
use ```sendBulkMessage``` method:
```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$bot->onCommand("start", function (Context $ctx) {
    $chatIds = []; // ... read users from database
    $ctx->sendBulkMessage($chatIds, 'A new notification for you', ['parse_mode' => 'HTML']);
});

$bot->run();
```

#### Step by step messages (conversations)
We need a way to handle the state in a persistent way across "sessions". In the config with the setCache method you can
pass a cache implementation that follow [psr-6 interface](https://www.php-fig.org/psr/psr-6/).
By default Zanzara use these implementations:
- [ArrayAdapter](https://symfony.com/doc/current/components/cache/adapters/array_cache_adapter.html) if started in polling mode (this is not persistant, everything is deleted on every restart)
- [FilesystemAdapter](https://symfony.com/doc/current/components/cache/adapters/filesystem_adapter.html) if started in webhook mode 

Zanzara has a dependecy to [symfony cache](https://symfony.com/doc/current/components/cache.html), so you can use all the implementations provided in their website.

In this example without config, by default zanzara start in polling mode with ArrayAdapter as cache.
This cache implementation should be used only in development for quick prototyping, we suggest more robust cache adapter such as [redis](https://symfony.com/doc/current/components/cache/adapters/redis_adapter.html)
or [memcached](https://symfony.com/doc/current/components/cache/adapters/memcached_adapter.html)
```php
$bot = new Zanzara( $_ENV['BOT_KEY']);


$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage("Hi, what's your name?");
    $ctx->nextStep("checkName");
});

function checkName(Context $ctx)
{
    $ctx->sendMessage("{$ctx->getMessage()->getText()}, what is your age?");
    $ctx->nextStep("checkAge");
}

function checkAge(Context $ctx)
{
    if (ctype_digit($ctx->getMessage()->getText())) {
        $ctx->sendMessage("Ok perfect, bye");
        $ctx->endConversation(); //Must be used, this method clean the state for this conversation
    } else {
        $ctx->sendMessage("Must be a number, retry");
        $ctx->redoStep(); //can be omitted used only for readable purpose
    }
}

$bot->onCommand("help", function (Context $ctx) {
    $ctx->sendMessage("Lancia /start per iniziare");
});


$bot->run();
```

#### It's built on top of ReactPHP
Last but not least, you can take advantage of all [ReactPHP](https://reactphp.org/) features.

## Get started
Zanzara is a framework to build asynchronous Telegram bots in PHP.  
We suppose you're already familiar with [Telegram](https://core.telegram.org/bots) bots, PHP,
[Composer](https://getcomposer.org/) and that you've at least heard of [ReactPHP](https://reactphp.org/).  

#### Requirements
Just make sure to have PHP (>= 7.0) and [Composer](https://getcomposer.org/) installed on your machine.
  