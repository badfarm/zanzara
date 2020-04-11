# Zanzara
Asynchronous Telegram Bot Framework based on [ReactPHP](https://reactphp.org/)

---

### Features
* Full [Telegram Bot Api 4.7](https://core.telegram.org/bots/api) support (March 2020)
* Middleware chain for requests
* Fast since it's based on asynchronous non-blocking I/O model
* Lightweight (no web server or database required)
* Easy to get started
* Unit battle tested

### Installation
    composer require bohzio/zanzara
    
### Get started

Create a file named **_main.php_** and paste the following code:

```php
<?php

require __DIR__ . '/../autoload.php';

$bot = new Zanzara('token');

$bot->onCommand('start', function (Context $ctx) {
    $ctx->reply('Hello');
});

$bot->run();
```

Then run it through command line as follows

    php main.php

You should see

    Zanzara is listening...

Send _/start_ to your Bot and it will reply with _Hello_!

### Middleware
