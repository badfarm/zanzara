Sections:
* [Why Zanzara?](#why-zanzara)
* [Get started](#get-started)
* [Update listeners](#update-listeners)
* [Update object](#update-object)
* [Telegram Api methods](#telegram-api-methods)
* [Middleware](#middleware)
* [Conversations](#conversations)
* [Session](#session)
* [Bulk messaging](#bulk-messaging)
* [Error Handling](#error-handling)
* [Polling or Webhook](#polling-or-webhook)
* [Using a Local Bot API Server](#using-a-local-bot-api-server)
* [Examples](#examples)
* [Built with Zanzara](#built-with-zanzara)

# Why Zanzara?
There is plenty of PHP libraries which help you write Telegram bots, so why should you use Zanzara?

#### Polling support
We (developers) get annoyed easily, so if we are gonna make a Telegram Bot we want a working
environment set up ```as soon as possible```. Unlike other libraries that require you to configure a database and mess
up with webhooks/https-server/cron-job, you can copy-paste the following snippet and it just works:
```php
<?php

use Zanzara\Zanzara;
use Zanzara\Context;

require __DIR__ . '/vendor/autoload.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
```
Thanks to [ReactPHP](https://reactphp.org/), we can have a long-running process that
[pulls](https://core.telegram.org/bots/api#getupdates) updates from Telegram servers (```polling``` mode). This cannot
be achieved with ```traditional``` PHP.

#### Asynchronous
Your bot interacts with Telegram through http requests, ```a lot of http requests```. Why wait for a message to
be sent before performing a database query? Zanzara provides a way to call every Telegram Api method asynchronously and
get the result with a React promise. For example:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage('Hello')->then(
        function (Message $message) {
            // success
        },
        function (TelegramException $error) {
            // failed
        }
    );
    // ... in the meantime perform some queries on MySql
});

$bot->run();
```
Asynchronous http requests are just one feature that [ReactPHP](https://reactphp.org/) brings to the table. With its event-driven
non-blocking I/O model ReactPHP can drastically boost your bot performance.

#### Middleware chain
Usually web applications delegate operations like authorization and internalization checks to ```middleware```.
[ExpressJS](https://expressjs.com/en/guide/using-middleware.html) provides it,
[Laravel](https://laravel.com/docs/7.x/middleware) provides it, ```Zanzara``` provides it. Here a simple example:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

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
More on [Middleware](#middleware) section.

#### No more 429 annoying errors
Have you ever got a ```429``` error from Telegram? It happens when you send ```too many messages``` to one or more
chats. The official Telegram [documentation](https://core.telegram.org/bots/faq#broadcasting-to-users) encourages you to
spread notifications over longer intervals. We do it for you, just use the ```sendBulkMessage``` method:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("start", function (Context $ctx) {
    $chatIds = []; // ... read users from database
    $ctx->sendBulkMessage($chatIds, 'A new notification for you', ['parse_mode' => 'HTML']);
});

$bot->run();
```
More on [Bulk messaging](#bulk-messaging) section.

#### And other features like:
* [Conversations](#conversations)
* [Session](#session)

# Get started
#### What is Zanzara?
Zanzara is a framework to build asynchronous Telegram bots in PHP.
We suppose you're already familiar with [Telegram](https://core.telegram.org/bots) bots, PHP,
[Composer](https://getcomposer.org/) and that you've at least heard of [ReactPHP](https://reactphp.org/).

#### Requirements
Just make sure to have PHP (>= 7.2) and [Composer](https://getcomposer.org/) installed on your machine.
> We suppose you've already created a Telegram Bot through [@BotFather](https://telegram.me/BotFather) and you have
> a valid bot token. If not, please read the official Telegram
> [documentation](https://core.telegram.org/bots#creating-a-new-bot) before continuing.

#### Installation
You install Zanzara through ```composer``` as follows:
```
composer require badfarm/zanzara
```

#### Zanzara class
First thing to do is to instantiate the Zanzara class (ensure to have included the ```autoload.php``` file):
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);
```
Its constructor takes one mandatory parameter: your bot ```token```. We strongly encourage you to put it in an external
```.env``` file and include it through [dotenv](https://github.com/vlucas/phpdotenv) libraries.
> Note: by default Zanzara starts in [polling](https://core.telegram.org/bots/api#getupdates) mode. To use webhooks
> see [Polling or Webhook](#polling-or-webhook).

#### Listen for updates
Next thing to do is to tell the Framework that we want to listen for Telegram updates.
For example, to listen for the ```/start``` command:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {

});
```

You can find the complete list of listener methods in [Update listeners](#update-listeners) section.

[Here](#examples) for more examples.

#### The Context object
As you have seen, each listener method takes a ```callback``` function as parameter. The callback must always
accept one parameter of type ```Context```. The Context contains both the ```Update``` received from Telegram and the
methods that allow you to interact with the ```Telegram Api```. Here some examples:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $userId = $ctx->getMessage()->getFrom()->getId();

    $ctx->getUserProfilePhotos($userId);
    $ctx->sendMessage('I have just stolen your profile photos');
});

$bot->onCbQuery(function (Context $ctx) {
    $callbackQuery = $ctx->getCallbackQuery();

    if ($callbackQuery->getData() === '1') {
        $ctx->sendInvoice('1 Pepperoni Pizza', $_ENV['PROVIDER_TOKEN']);
    }
    $ctx->answerCallbackQuery();
});
```
For further info see [Update object](#update-object) and
[Telegram Api methods](#telegram-api-methods).

#### Run
After having defined the listeners just run your bot:
```php
$bot->run();
```
If everything is ok you should see such a ```Zanzara is listening...``` message.

# Update listeners
Here the listener methods for Telegram updates based on the type:

| Method | Parameters | Description |
| --- | --- | --- |
| onCommand | ```$command```: string<br>```$callback```: callable | Listen for the specified command |
| onText | ```$text```: string<br>```$callback```: callable | Listen for a message with the specified text |
| onMessage | ```$callback```: callable | Listen for a generic message |
| onReplyToMessage | ```$callback```: callable | Listen for a message that is a reply of another message |
| onEditedMessage | ```$callback```: callable | Listen for an edited message |
| onCbQueryText | ```$text```: string<br>```$callback```: callable | Listen for a callback query with the specified message text |
| onCbQueryData | ```$data```: array<br>```$callback```: callable | Listen for a callback query with the specified callback data |
| onCbQuery | ```$callback```: callable | Listen for a generic callback query |
| onShippingQuery | ```$callback```: callable | Listener for a shipping query |
| onPreCheckoutQuery | ```$callback```: callable | Listen for a pre checkout query |
| onSuccessfulPayment | ```$callback```: callable | Listen for a successful payment |
| onPassportData | ```$callback```: callable | Listen for a passport data message |
| onInlineQuery | ```$callback```: callable | Listen for an inline query |
| onChosenInlineResult | ```$callback```: callable | Listen for a chosen inline result |
| onChannelPost | ```$callback```: callable | Listen for a channel post |
| onEditedChannelPost | ```$callback```: callable | Listen for an edited channel post |
| onUpdate | ```$callback```: callable | Listen for a generic update |

Methods that take just a callable as parameter can be called more than once and ```every callback``` will be executed.
Moreover, listener methods are not exclusive, so for example:

```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("start", function (Context $ctx) {

});

$bot->onUpdate(function (Context $ctx) {

});

$bot->run();
```
In this case both ```onCommand``` and ```onUpdate``` callbacks will be executed.

# Update object
You access the Update object with ```$ctx->getUpdate()```. To make your code less cumbersome you can use the following
```Context```'s shortcut methods:

| Method | Return type |
| --- | --- |
| getUpdateId | int |
| getMessage | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) |
| getEditedMessage | [EditedMessage](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/EditedMessage.php) |
| getChannelPost | [ChannelPost](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/ChannelPost.php) |
| getEditedChannelPost | [EditedChannelPost](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/EditedChannelPost.php) |
| getInlineQuery | [InlineQuery](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/InlineQuery.php) |
| getChosenInlineResult | [ChosenInlineResult](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/ChosenInlineResult.php) |
| getCallbackQuery | [CallbackQuery](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/CallbackQuery.php) |
| getShippingQuery | [ShippingQuery](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Shipping/ShippingQuery.php) |
| getPreCheckoutQuery | [PreCheckoutQuery](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Shipping/PreCheckoutQuery.php) |
| getPoll | [Poll](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Poll/Poll.php) |
| getPollAnswer | [PollAnswer](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Poll/PollAnswer.php) |
| getEffectiveUser | [User](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/User.php) |
| getEffectiveChat | [Chat](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Chat.php) |

> Note: ```$ctx->getEffectiveChat()``` and ```$ctx->getEffectiveUser()``` allow to get user info regardless of the
> update type. For example if the Update is a ```Message``` the getEffectiveUser() method will return the same value
> of ```$ctx->getMessage()->getFrom()```. If, instead, the Update is a ```CallbackQuery``` the getEffectiveUser() method
> will return the same value of ```$ctx->getCallbackQuery()->getFrom()```.

All Update objects contain PHPDoc with the same info you find on the official
[Telegram Bot Api](https://core.telegram.org/bots/api#update), so you can avoid to jump between code and website any
time you need info about the api.

# Telegram Api methods
You interact with Telegram Api either through the ```Context``` object or the ```Telegram``` object provided by
```$bot->getTelegram()```.

Since Zanzara is based on [ReactPHP](https://reactphp.org/) the http requests are made with an asynchronous [http client](https://github.com/clue/reactphp-buzz).

Each method returns a ```PromiseInterface```. On success the promise returns the object declared as return type
of the method, an ```TelegramException``` otherwise. Here an example with ```sendMessage()```:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    // doc says: "Use this method to send text messages. On success, the sent @see Message is returned."
    $ctx->sendMessage('Hello')->then(
        function (Message $message) {
            // success
        },
        function (TelegramException $e) {
            echo $e->getErrorCode();
            echo $e->getDescription();
        }
    );
});
```
As you have seen we didn't specify a ```chat_id``` when calling ```$ctx->sendMessage('Hello')```. That's because
by default each method that requires a chat_id takes it from the Context's update. If you really want to send a message
to a different chat_id just specify it in the ```$opt``` array param:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $chatId = // ... read it from wherever
    $ctx->sendMessage('Hello', ['chat_id' => $chatId]);
});
```
Again, each method takes the required parameters followed by a param ```array $opt``` which allows you to specify
optional parameters. Here an example:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('Hello', ['reply_markup' => ['force_reply' => true]]);
});
```
#### Parse mode
With Zanzara you can specify a generic ```parse_mode``` that applies to all Telegram Api methods:
```php
<?php

$config = new Config();
$config->setParseMode(Config::PARSE_MODE_HTML);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);
```

#### Working with files
Some Telegram Api methods allow you to work with files. For example to ```send a photo``` you do:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("photo", function (Context $ctx) {
    $ctx->sendPhoto(new InputFile("file/photo.jpeg"));
});

$bot->run();
```
By default the file reading operation is ```synchronous```. This means that the loop is blocked until the whole file
is read.
If you want it to be asynchronous you can switch to [ReactPHP FileSystem](https://github.com/reactphp/filesystem):
```php
<?php

$config = new Config();
$config->useReactFileSystem(true);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onCommand("photo", function (Context $ctx) {
    $ctx->sendPhoto(new InputFile("file/photo.jpeg"));
});

$bot->run();
```
This way has only one drawback: currently it ```doesn't work``` on Windows machines, just on unix ones.
We hope that the ReactPHP team stabilizes the library as soon as possible adding support for Windows, but if this isn't
a problem for you, feel free to use it.

#### Complete method list:
| Method | Parameters | Return type | Documentation |
| --- | --- | --- | --- |
| logOut | | True | https://core.telegram.org/bots/api#logout
| close | | True | https://core.telegram.org/bots/api#close
| getMe | | [User](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/User.php) | https://core.telegram.org/bots/api#sendmessage
| sendMessage | ```$text```: string<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendmessage
| sendBulkMessage | ```$chatIds```: array<br>```$text```: string<br>```$opt```: array | void | https://core.telegram.org/bots/api#sendmessage
| setWebhook | ```$url```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#setwebhook
| getWebhookInfo |  | [WebhookInfo](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Webhook/WebhookInfo.php) | https://core.telegram.org/bots/api#getwebhookinfo
| deleteWebhook | ```$opt```: array | True | https://core.telegram.org/bots/api#deletewebhook
| forwardMessage | ```$chat_id```<br>```$from_chat_id```<br>```$message_id```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#forwardmessage
| copyMessage | ```$chat_id```<br>```$from_chat_id```<br>```$message_id```<br>```$opt```: array | [MessageId](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/MessageId.php) | https://core.telegram.org/bots/api#copymessage
| sendPhoto | ```$photo```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendphoto
| sendAudio | ```$audio```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendaudio
| sendDocument | ```$document```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#senddocument
| sendVideo | ```$video```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendvideo
| sendAnimation | ```$animation```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendanimation
| sendVoice | ```$voice```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendvoice
| sendVideoNote | ```$video_note```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendvideonote
| sendMediaGroup | ```$media```<br>```$opt```: array | array of [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendmediagroup
| sendLocation | ```$latitude```<br>```$longitude```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendlocation
| editMessageLiveLocation | ```$latitude```<br>```$longitude```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#editmessagelivelocation
| stopMessageLiveLocation | ```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#stopmessagelivelocation
| sendVenue | ```$latitude```<br>```$longitude```<br>```$title```: string<br>```$address```: string<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendvenue
| sendContact | ```$phone_number```: string<br>```$first_name```: string<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendcontact
| sendPoll | ```$question```: string<br>```$options```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendpoll
| sendDice | ```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#senddice
| sendChatAction | ```$action```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#sendchataction
| getUserProfilePhotos | ```$user_id```<br>```$opt```: array | [UserProfilePhotos](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/File/UserProfilePhotos.php) | https://core.telegram.org/bots/api#getuserprofilephotos
| getFile | ```$file_id```: string<br>```$opt```: array | [File](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/File/File.php) | https://core.telegram.org/bots/api#getfile
| kickChatMember | ```$chat_id```<br>```$user_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#kickchatmember
| unbanChatMember | ```$chat_id```<br>```$user_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#unbanchatmember
| restrictChatMember | ```$chat_id```<br>```$user_id```<br>```$permissions```<br>```$opt```: array | True | https://core.telegram.org/bots/api#restrictchatmember
| promoteChatMember | ```$chat_id```<br>```$user_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#promotechatmember
| setChatAdministratorCustomTitle | ```$chat_id```<br>```$user_id```<br>```$custom_title```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchatadministratorcustomtitle
| setChatPermissions | ```$chat_id```<br>```$permissions```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchatpermissions
| exportChatInviteLink | ```$chat_id```<br>```$opt```: array | void | https://core.telegram.org/bots/api#exportchatinvitelink
| setChatPhoto | ```$chat_id```<br>```$photo```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchatphoto
| deleteChatPhoto | ```$chat_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#deletechatphoto
| setChatTitle | ```$chat_id```<br>```$title```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchattitle
| setChatDescription | ```$chat_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchatdescription
| pinChatMessage | ```$chat_id```<br>```$message_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#pinchatmessage
| unpinChatMessage | ```$chat_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#unpinchatmessage
| unpinAllChatMessages | ```$opt```: array | True | https://core.telegram.org/bots/api#unpinallchatmessages
| leaveChat | ```$chat_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#leavechat
| getChat | ```$chat_id```<br>```$opt```: array | [Chat](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Chat.php) | https://core.telegram.org/bots/api#getchat
| getChatAdministrators | ```$chat_id```<br>```$opt```: array | array of [ChatMember](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/ChatMember.php) | https://core.telegram.org/bots/api#getchatadministrators
| getChatMembersCount | ```$chat_id```<br>```$opt```: array | void | https://core.telegram.org/bots/api#getchatmemberscount
| getChatMember | ```$chat_id```<br>```$user_id```<br>```$opt```: array | [ChatMember](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/ChatMember.php) | https://core.telegram.org/bots/api#getchatmember
| setChatStickerSet | ```$chat_id```<br>```$sticker_set_name```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#setchatstickerset
| deleteChatStickerSet | ```$chat_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#deletechatstickerset
| answerCallbackQuery | ```$opt```: array | True | https://core.telegram.org/bots/api#answercallbackquery
| setMyCommands | ```$commands```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setmycommands
| editMessageText | ```$text```: string<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#editmessagetext
| editMessageCaption | ```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#editmessagecaption
| editMessageMedia | ```$media```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#editmessagemedia
| editMessageReplyMarkup | ```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#editmessagereplymarkup
| stopPoll | ```$chat_id```<br>```$message_id```<br>```$opt```: array | [Poll](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Poll/Poll.php) | https://core.telegram.org/bots/api#stoppoll
| deleteMessage | ```$chat_id```<br>```$message_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#deletemessage
| sendSticker | ```$sticker```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendsticker
| getStickerSet | ```$name```: string<br>```$opt```: array | [StickerSet](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/File/StickerSet.php) | https://core.telegram.org/bots/api#getstickerset
| uploadStickerFile | ```$user_id```<br>```$png_sticker```<br>```$opt```: array | [File](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/File/File.php) | https://core.telegram.org/bots/api#uploadstickerfile
| createNewStickerSet | ```$user_id```<br>```$name```: string<br>```$title```: string<br>```$emojis```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#createnewstickerset
| addStickerToSet | ```$user_id```<br>```$name```: string<br>```$png_sticker```<br>```$emojis```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#addstickertoset
| setStickerPositionInSet | ```$sticker```: string<br>```$position```: int<br>```$opt```: array | True | https://core.telegram.org/bots/api#setstickerpositioninset
| deleteStickerFromSet | ```$sticker```: string<br>```$opt```: array | True | https://core.telegram.org/bots/api#deletestickerfromset
| setStickerSetThumb | ```$name```: string<br>```$user_id```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setstickersetthumb
| answerInlineQuery | ```$results```<br>```$opt```: array | True | https://core.telegram.org/bots/api#answerinlinequery
| sendInvoice | ```$title```: string<br>```$description```: string<br>```$payload```: string<br>```$provider_token```: string<br>```$start_parameter```: string<br>```$currency```: string<br>```$prices```<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendinvoice
| answerShippingQuery | ```$ok```<br>```$opt```: array | True | https://core.telegram.org/bots/api#answershippingquery
| answerPreCheckoutQuery | ```$ok```<br>```$opt```: array | True | https://core.telegram.org/bots/api#answerprecheckoutquery
| setPassportDataErrors | ```$user_id```<br>```$errors```<br>```$opt```: array | True | https://core.telegram.org/bots/api#setpassportdataerrors
| sendGame | ```$game_short_name```: string<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#sendgame
| setGameScore | ```$user_id```<br>```$score```: int<br>```$opt```: array | [Message](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Message.php) | https://core.telegram.org/bots/api#setgamescore
| getGameHighScores | ```$user_id```<br>```$opt```: array | array of [GameHighScore](https://github.com/badfarm/zanzara/blob/develop/src/Zanzara/Telegram/Type/Game/GameHighScore.php) | https://core.telegram.org/bots/api#getgamehighscores

# Middleware
Middleware is a core functionality for any application, it allows to perform actions before and after the request
is processed. With Zanzara middleware can be implemented either as ```callable```:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

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
or classes that implement a ```MiddlewareInterface``` which defines a ```handle(Context $ctx, $next)``` method:

```php
<?php

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Context $ctx, $next)
    {
        // ... do something before
        $next($ctx);
        // ... do something after
    }
}

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->reply('Hello');
})->middleware(new AuthMiddleware());

$bot->run();
```
In the above examples middleware are specific for a listener callback. You can make a middleware generic for every
callback calling the ```middleware()``` method on ```Zanzara``` class:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$m = function(Context $ctx, $next) {
    // do something before
    $next($ctx);
    // do something after
};

$bot->middleware($m);
```
Use ```get($key)``` and ```set($key, $value)``` methods of **Context** to share data between middleware.

# Conversations
Sometimes you need to send a series of chained messages to a user and save his answers, actually a  ```conversation```.
In this example we ask the user his name and age to, hypothetically, save them on MySql:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage("Hi, what's your name?");
    $ctx->nextStep("checkName");
});

function checkName(Context $ctx)
{
    $name = $ctx->getMessage()->getText();
    $ctx->setUserData('name', $name);
    $ctx->sendMessage("Hi $name, what is your age?");
    $ctx->nextStep("checkAge");
}

function checkAge(Context $ctx)
{
    $age = $ctx->getMessage()->getText();
    if (ctype_digit($age)) {
        $ctx->getUserDataItem('name')->then(function ($name) use ($ctx) {
            // ... save user data on MySql
            $ctx->sendMessage("Ok $name perfect, bye");
            $ctx->endConversation(); // clean the state for this conversation
        });
    } else {
        $ctx->sendMessage("Must be a number, retry");
    }
}

$bot->run();
```
As you've seen, you use the ```nextStep()``` method to declare the next function to be executed when the user will send a new
message and ```endConversation()``` when your conversation is over.

# Session
Sometimes you need to persist data between requests, we provide some methods to do that:

> Note: this feature doesn't require a database.

| Method | Parameters | Description |
| --- | --- | --- |
| ```setChatData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Sets an item for the chat-related data |
| ```getChatData``` | | Returns all the chat-related data |
| ```getChatDataItem``` | ```$key```: string | Gets an item of the chat-related data |
| ```deleteChatDataItem``` | ```$key```: string | Deletes an item from the chat-related data |
| ```deleteChatData``` | | Deletes all chat-related data |
| ```appendChatData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Append data to an existing chat cache item |
| ```setUserData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Sets an item for the user-related data |
| ```getUserData``` | | Returns all the user-related data |
| ```getUserDataItem``` | ```$key```: string | Gets an item of the user-related data |
| ```deleteUserDataItem``` | ```$key```: string | Deletes an item from the user-related data |
| ```deleteUserData``` | | Deletes all user-related data |
| ```appendUserData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Append data to an existing user cache item |
| ```setGlobalData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Sets an item for the global data |
| ```getGlobalData``` | | Returns all the global data |
| ```getGlobalDataItem``` | ```$key```: string | Gets an item of the global data |
| ```deleteGlobalDataItem``` | ```$key```: string | Deletes an item from the global data |
| ```deleteGlobalData``` | | Deletes all global data |
| ```appendGlobalData``` | ```$key```: string<br>```$data```: any<br>```$ttl``` | Append data to an existing global cache item |
| ```wipeCache``` | | Deletes all cache data |

You can save ```whatever``` you want in the cache: strings, arrays, objects, etc.

All these methods return a ReactPHP ```promise```, for example to retrieve an item from the cache you do:
```php
$ctx->getUserDataItem('key')->then(function ($value) {

});
```

By default to persist these data we use a ```in-memory array``` [cache](https://github.com/reactphp/cache)
implementation with a cache timeout of 180 seconds.
You can change the cache implementation (redis, filesystem, etc.) and the default timeout just by specifying them in
Zanzara ```Config```:
```php
<?php

$config = new Config();
$cache = // my cache
$config->setCache($cache);
$config->setCacheTtl(240);

$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->run();
```

# Bulk messaging
Telegram doesn't provide a way to send bulk notifications and if you try to send too many messages in a short amount
of time your requests could be rejected with a 429 error code. As
[Telegram](https://core.telegram.org/bots/faq#broadcasting-to-users) suggests, you should spread messages over a longer
interval. ```Zanzara``` takes care of that, just call the ```sendBulkMessage()``` method on the **Context** object:
```php
<?php

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand("start", function (Context $ctx) {
    $chatIds = []; // ... read users from database
    $ctx->sendBulkMessage($chatIds, 'A new notification for you', ['parse_mode' => 'HTML']);
});

$bot->run();
```
Under the hood Zanzara sends the messages with an interval of ```two seconds``` between them. You can configure the interval
with ```Config``` class:
```php
<?php

$config = new Config();
$config->setBulkMessageInterval(3.5);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);
```

# Error Handling
On errors ```Zanzara``` logs them to ```STDERR``` and to your log files (if a logger is provided). You can specify
a ```PSR-3``` Logger implementation as follows:
```php
<?php

$logger = // your logger.

$config = new Config();
$config->setLogger($logger);

$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->run();
```
If you want to perform further operations when errors happen, define a function that handles them:
```php
<?php

$config = new Config();
$config->setErrorHandler(function ($e, Context $ctx) {
    echo "Custom exception management";
});

$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->run();
```

# Polling or Webhook
#### Polling
By default Zanzara starts in ```polling``` mode. It is the best choice for most Telegram bots since it does not require
a web server with https enabled.

#### Webhook with ReactPHP http server
If you want to switch to ```webhook``` mode you need to set up an http server. ReactPHP comes with a built-in
[http server](https://github.com/reactphp/http). If you would like to use it:
```php
<?php

$config = new Config();
$config->setUpdateMode(Config::REACTPHP_WEBHOOK_MODE);
$config->setServerUri(8080);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->run();
```
This way you have a http server listening for Telegram updates on ```localhost:8080```. Telegram requires your webhook
to be exposed under ```https``` protocol. To try webhook mode locally you can use something like
[ngrok](https://ngrok.com/) in order to expose your local webserver to the internet. For ```production``` setup we
suggest you to follow [ReactPHP](https://github.com/reactphp/http) and [Telegram](https://core.telegram.org/bots/webhooks)
guides.
Before you actually start to receive updates you need to [set your bot's webhook](#set-webhook).

#### Webhook with other http servers
To use Zanzara with other http server, such as Apache or NGINX:
```php
<?php

$config = new Config();
$config->setUpdateMode(Config::WEBHOOK_MODE);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->run();
```
Again, for ```production``` setup we suggest you to follow [Telegram](https://core.telegram.org/bots/webhooks) guide.
Before you actually start to receive updates you need to [set your bot's webhook](#set-webhook).
> Note: using this mode you don't have features like [Conversations](#conversations) and [Session](#session) working out of the box, since by default they
> are based on in-memory cache systems. Anyway, you can have them working just by relying on other cache
> implementations..

#### Set webhook
We prepared a snippet to set the webhook. Assuming that you placed your ```hook.php``` script in the root of your
webserver:
```php
<?php

use Zanzara\Zanzara;

require __DIR__ . '/vendor/autoload.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);
$telegram = $bot->getTelegram();

$telegram->setWebhook('https://mydomain.com/hook.php')->then(
    function ($true) {
        echo 'Webhook set successfully';
    }
);

$bot->getLoop()->run();
```
As suggested by [Telegram](https://core.telegram.org/bots/api#setwebhook) to make sure your webhook can be called only
by Telegram servers, you can include your bot's token in the webhook url:
```php
$telegram->setWebhook('https://mydomain.com/hook.php/<token>')
```
Zanzara will take care of the token check, just enable it:
```php
<?php

$config = new Config();
$config->setUpdateMode(Config::WEBHOOK_MODE); // or Config::REACTPHP_WEBHOOK_MODE
$config->enableWebhookTokenCheck(true);

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->run();
```

# Using a Local Bot API Server
Starting from Telegram Bot Api **5.0** you can use a **local Api server**. Follow Telegram
[guide](https://core.telegram.org/bots/api#using-a-local-bot-api-server) to configure it. Then, specify your server's
url through the ```Config``` object:

```php

<?php

use Zanzara\Context;
use Zanzara\Config;
use Zanzara\Zanzara;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$config->setApiTelegramUrl('https://my-local-server.com');
$bot = new Zanzara("YOUR-BOT-TOKEN", $config);

$bot->onCommand('start', function (Context $ctx) {
    // ...
});

$bot->run();
```

# Examples
#### Command
```php
<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $firstName = $ctx->getEffectiveUser()->getFirstName();
    $ctx->sendMessage("Hi $firstName, I'm replying to /start command");
});

$bot->run();
```

#### InlineKeyboard
```php
<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $kb = ['reply_markup' =>
        ['inline_keyboard' => [[
            ['callback_data' => 'one', 'text' => 'Button One'],
            ['callback_data' => 'two', 'text' => 'Button Two']
        ]], 'resize_keyboard' => true]
    ];
    $ctx->sendMessage("I'm replying to /start command with an inline keyboard", $kb);
});

// reply to a generic callback query
$bot->onCbQuery(function (Context $ctx) {
    $ctx->sendMessage("You clicked 'Button one' or 'Button two'");
    $ctx->answerCallbackQuery();
});

// reply only to callback queries that have 'one' as 'callback_data'
$bot->onCbQueryData(['one'], function (Context $ctx) {
    $ctx->sendMessage("You clicked 'Button one'");
    $ctx->answerCallbackQuery();
});

// reply only to callback queries that have 'two' as 'callback_data'
$bot->onCbQueryData(['two'], function (Context $ctx) {
    $ctx->sendMessage("You clicked 'Button two'");
    $ctx->answerCallbackQuery();
});

$bot->run();
```

#### Keyboard
```php
<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $kb = ['reply_markup' =>
        ['keyboard' => [[
            ['text' => 'Button One'],
            ['text' => 'Button Two']
        ]], 'resize_keyboard' => true]
    ];
    $ctx->sendMessage("I'm replying to /start command with a keyboard", $kb);
});

$bot->onText('Button One', function (Context $ctx) {
    $ctx->sendMessage("You clicked 'Button one'");
});

$bot->onText('Button Two', function (Context $ctx) {
    $ctx->sendMessage("You clicked 'Button two'");
});

$bot->run();
```

#### Sessions
```php
<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $ctx->nextStep('askName');
    $ctx->sendMessage("What's your name?");
});

function askName(Context $ctx)
{
    $name = $ctx->getMessage()->getText();
    $ctx->setUserData('name', $name); // save name in cache
    $ctx->nextStep('askAge');
    $ctx->sendMessage("Hi $name, what a wonderful name! What's your age?");
}

function askAge(Context $ctx)
{
    // retrieve name from cache
    $ctx->getUserDataItem('name')->then(function ($name) use ($ctx) {
        $age = $ctx->getMessage()->getText();
        $ctx->sendMessage("$age ?! Dear $name, you are too old for me! Bye bye!");
        $ctx->endConversation();
    });
}

$bot->run();
```

#### Conversation
```php
<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../vendor/autoload.php';

$bot = new Zanzara("YOUR-BOT-TOKEN");

$bot->onCommand('start', function (Context $ctx) {
    $ctx->nextStep('askName');
    $ctx->sendMessage("What's your name?");
});

function askName(Context $ctx)
{
    $name = $ctx->getMessage()->getText();
    $ctx->nextStep('askAge');
    $ctx->sendMessage("Hi $name, what a wonderful name! What's your age?");
}

function askAge(Context $ctx)
{
    $age = $ctx->getMessage()->getText();
    $ctx->sendMessage("$age ?! You are too old for me! Bye bye!");
    $ctx->endConversation();
}

$bot->run();
```

# Built with Zanzara
* [@stargazers_bot](https://t.me/stargazers_bot) Bot that notifies you when someone stars a github project. [Source code](https://github.com/badfarm/stargazers-bot)