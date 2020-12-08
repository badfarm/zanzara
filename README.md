<p align="center">
  <img src="https://github.com/badfarm/zanzara/blob/develop/zanzara_logo.png">
</p>

Asynchronous PHP Telegram Bot Framework built on top of [ReactPHP](https://reactphp.org/)

[![Bot API](https://img.shields.io/badge/Bot%20API-5.0%20(November%202020)-blue)](https://core.telegram.org/bots/api)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.2-blue)](https://www.php.net/)
[![Build Status](https://travis-ci.org/badfarm/zanzara.svg?branch=master)](https://travis-ci.org/badfarm/zanzara)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/badfarm/zanzara/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/badfarm/zanzara/?branch=develop)
[![Code style](https://img.shields.io/badge/code%20style-standard-green)](https://www.php-fig.org/psr/psr-2/)
[![License](https://img.shields.io/badge/license-MIT-green)](https://github.com/badfarm/zanzara/blob/develop/LICENSE.md)

---

### Features
* Long polling support (no webserver required)
* Middleware chain for requests
* Conversations and sessions (no database required)
* Based on [ReactPHP](https://reactphp.org/) asynchronous non-blocking I/O model
* Scheduled functions/timers provided by ReactPHP
* Bulk message sending (no more 429 annoying errors)
* Full [Telegram Bot Api 5.0](https://core.telegram.org/bots/api) support (November 2020)

### Installation
```
composer require badfarm/zanzara
```
    
### Quickstart

Create a file named ```bot.php``` and paste the following code:

```php
<?php

use Zanzara\Zanzara;
use Zanzara\Context;

require __DIR__ . '/vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
```

Then run it from command line as follows:

    $ php bot.php

Enjoy your bot!

Check [Wiki](https://github.com/badfarm/zanzara/wiki) for documentation.
