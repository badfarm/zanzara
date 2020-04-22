# Zanzara
Asynchronous PHP Telegram Bot Framework built on top of [ReactPHP](https://reactphp.org/)

---

### Features
* Full [Telegram Bot Api 4.7](https://core.telegram.org/bots/api) support (March 2020)
* Middleware chain for requests
* Step by step messages (conversations)
* Fast since it's based on asynchronous non-blocking I/O model
* Lightweight (no web server or database required)
* Bulk message sending (no more 429 annoying errors)

### Installation
```
composer require bohzio/zanzara
```
    
### Get started

Create a file named ```main.php``` and paste the following code:

```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
```

Then run it from command line as follows:

    $ php main.php

Enjoy your bot!

Check [Wiki](https://github.com/bohzio/zanzara/wiki) for documentation.