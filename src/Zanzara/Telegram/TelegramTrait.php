<?php

declare(strict_types=1);

namespace Zanzara\Telegram;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Http\Message\ResponseException;
use React\Promise\PromiseInterface;
use RingCentral\Psr7\MultipartStream;
use Zanzara\Config;
use Zanzara\MessageQueue;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\Chat;
use Zanzara\Telegram\Type\ChatInviteLink;
use Zanzara\Telegram\Type\ChatMember;
use Zanzara\Telegram\Type\ChatAdministratorRights;
use Zanzara\Telegram\Type\File\File;
use Zanzara\Telegram\Type\File\StickerSet;
use Zanzara\Telegram\Type\File\UserProfilePhotos;
use Zanzara\Telegram\Type\Game\GameHighScore;
use Zanzara\Telegram\Type\Input\InputFile;
use Zanzara\Telegram\Type\MenuButton;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\MessageId;
use Zanzara\Telegram\Type\Miscellaneous\BotCommand;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Response\TelegramException;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\User;
use Zanzara\Telegram\Type\WebApp\SentWebAppMessage;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;
use Zanzara\ZanzaraLogger;
use Zanzara\ZanzaraMapper;
use function React\Promise\all;

/**
 * Class that interacts with Telegram Api.
 * Made trait in order to be used both by Telegram and Context classes.
 *
 * @see Telegram
 * @see Context
 */
trait TelegramTrait
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Browser
     */
    protected $browser;

    /**
     * @var Update|null
     */
    protected $update;

    /**
     * Use this method to receive incoming updates using long polling (wiki). An Array of @see Update objects is returned.
     *
     * More on https://core.telegram.org/bots/api#getupdates
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function getUpdates(array $opt = []): PromiseInterface
    {
        $method = "getUpdates";
        $query = http_build_query($opt);

        // timeout browser necessary bigger than telegram timeout. They can't be equal
        $browser = $this->browser->withTimeout($opt['timeout'] + 10);

        return $this->wrapPromise($browser->get("$method?$query"), $method, $opt, Update::class);
    }

    /**
     * A simple method for testing your bot's auth token. Requires no parameters. Returns basic information about the
     * bot in form of a User object.
     *
     * @return PromiseInterface
     */
    public function getMe(): PromiseInterface
    {
        return $this->callApi("getMe", [], User::class);
    }

    /**
     * Use this method to send text messages. On success, the sent @see Message is returned.
     *
     * By default the message is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendmessage
     *
     * @param string $text
     * @param array $opt = [
     *     'chat_id' => 123456789,
     *     'parse_mode' => 'HTML',
     *     'disable_web_page_preview' => true,
     *     'disable_notification' => true,
     *     'protect_content' => true,
     *     'reply_to_message_id' => 123456789,
     *     'allow_sending_without_reply' => true,
     *     'reply_markup' => ['force_reply' => true],
     *     'reply_markup' => ['inline_keyboard' => [[
     *          ['text' => 'text', 'callback_data' => 'data', 'url' => 'HTTPS or tg:// URL']
     *      ]]],
     *      'reply_markup' => ['resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true, 'keyboard' => [[
     *          ['text' => 'text', 'request_contact' => true, 'request_location' => true, 'request_poll' => ['type' => 'quiz']]
     *      ]]],
     *     'reply_markup' => ['remove_keyboard' => true, 'selective' => true]
     * ]
     * @return PromiseInterface
     */
    public function sendMessage(string $text, array $opt = [])
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("text");
        $params = array_merge($required, $opt);
        return $this->doSendMessage($params);
    }

    /**
     * Do not use it. Use @see TelegramTrait::sendMessage() instead.
     *
     * @internal
     * @param array $params
     * @return PromiseInterface
     */
    public function doSendMessage(array $params): PromiseInterface
    {
        return $this->callApi("sendMessage", $params, Message::class);
    }

    /**
     * Use this method to send a message to many chats. This method takes care of sending the message
     * with a delay in order avoid 429 Telegram errors (https://core.telegram.org/bots/faq#broadcasting-to-users).
     *
     * Eg. $ctx->sendBulkMessage([1111111111, 2222222222, 333333333], 'A wonderful notification', [parse_mode => 'HTML']);
     *
     * More on https://core.telegram.org/bots/api#sendmessage
     *
     * @param array $chatIds
     * @param string $text
     * @param array $opt
     */
    public function sendBulkMessage(array $chatIds, string $text, array $opt = []): void
    {
        $this->container->get(MessageQueue::class)
            ->push($chatIds, $text, $opt);
    }

    /**
     * Use this method to specify a url and receive incoming updates via an outgoing webhook. Whenever there is an update
     * for the bot, we will send an HTTPS POST request to the specified url, containing a JSON-serialized Update. In case
     * of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setwebhook
     *
     * @param string $url
     * @param array $opt
     * @return PromiseInterface
     */
    public function setWebhook(string $url, array $opt = []): PromiseInterface
    {
        $required = compact("url");
        $params = array_merge($required, $opt);
        return $this->callApi("setWebhook", $params);
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a @see WebhookInfo object.
     * If the bot is using getUpdates, will return an object with the url field empty.
     *
     * More on https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @return PromiseInterface
     */
    public function getWebhookInfo(): PromiseInterface
    {
        return $this->callApi("getWebhookInfo", [], WebhookInfo::class);
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates. Returns True on
     * success. Requires no parameters.
     *
     * More on https://core.telegram.org/bots/api#deletewebhook
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteWebhook($opt = []): PromiseInterface
    {
        return $this->callApi("deleteWebhook", $opt);
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent @see Message is returned.
     *
     * More on https://core.telegram.org/bots/api#forwardmessage
     *
     * @param $chat_id
     * @param $from_chat_id
     * @param $message_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function forwardMessage($chat_id, $from_chat_id, $message_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "from_chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("forwardMessage", $params, Message::class);
    }

    /**
     * Use this method to copy messages of any kind. The method is analogous to the method forwardMessages, but the
     * copied message doesn't have a link to the original message. Returns the MessageId of the sent message on success.
     *
     * More on https://core.telegram.org/bots/api#copymessage
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @param $chat_id
     * @param $from_chat_id
     * @param $message_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function copyMessage($chat_id, $from_chat_id, $message_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "from_chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("copyMessage", $params, MessageId::class);
    }

    /**
     * Use this method to send photos. On success, the sent @see Message is returned.
     *
     * The photo param can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the photo is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendphoto
     *
     * @param $photo
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendPhoto($photo, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("photo");
        $params = array_merge($required, $opt);
        return $this->callApi("sendPhoto", $params, Message::class);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player. Your audio
     * must be in the .MP3 or .M4A format. On success, the sent @see Message is returned. Bots can currently send audio files
     * of up to 50 MB in size, this limit may be changed in the future.
     *
     * The audio and thumb params can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the audio is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendaudio
     *
     * @param $audio
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendAudio($audio, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("audio");
        $params = array_merge($required, $opt);
        return $this->callApi("sendAudio", $params, Message::class);
    }

    /**
     * Use this method to send general files. On success, the sent @see Message is returned. Bots can currently send files of any
     * type of up to 50 MB in size, this limit may be changed in the future.
     *
     * The document and thumb params can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the document is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#senddocument
     *
     * @param $document
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendDocument($document, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("document");
        $params = array_merge($required, $opt);
        return $this->callApi("sendDocument", $params, Message::class);
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document). On
     * success, the sent @see Message is returned. Bots can currently send video files of up to 50 MB in size, this limit may
     * be changed in the future.
     *
     * The video and thumb params can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the video is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendvideo
     *
     * @param $video
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendVideo($video, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("video");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVideo", $params, Message::class);
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound). On success, the sent @see Message
     * is returned. Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the
     * future.
     *
     * The animation and thumb params can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the animation is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendanimation
     *
     * @param $animation
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendAnimation($animation, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("animation");
        $params = array_merge($required, $opt);
        return $this->callApi("sendAnimation", $params, Message::class);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .OGG file encoded with OPUS (other formats may be sent as Audio or
     * Document). On success, the sent @see Message is returned. Bots can currently send voice messages of up to 50 MB in
     * size, this limit may be changed in the future.
     *
     * The voice param can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the voice is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendvoice
     *
     * @param $voice
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendVoice($voice, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("voice");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVoice", $params, Message::class);
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long. Use this method to send video
     * messages. On success, the sent @see Message is returned.
     *
     * The video_note and thumb params can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the video note is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendvideonote
     *
     * @param $video_note
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendVideoNote($video_note, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("video_note");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVideoNote", $params, Message::class);
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album. Documents and audio files can
     * be only group in an album with messages of the same type. On success, an array of @see Message 's that were sent
     * is returned.
     *
     * By default the media group is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param $media
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendMediaGroup($media, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("media");
        $params = array_merge($required, $opt);
        return $this->callApi("sendMediaGroup", $params, Message::class);
    }

    /**
     * Use this method to send point on the map. On success, the sent @see Message is returned.
     *
     * By default the location is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendlocation
     *
     * @param $latitude
     * @param $longitude
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendLocation($latitude, $longitude, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("latitude", "longitude");
        $params = array_merge($required, $opt);
        return $this->callApi("sendLocation", $params, Message::class);
    }

    /**
     * Use this method to edit live location messages. A location can be edited until its live_period expires or editing is
     * explicitly disabled by a call to stopMessageLiveLocation. On success, if the edited message was sent by the bot,
     * the edited @see Message is returned, otherwise True is returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @param $latitude
     * @param $longitude
     * @param array $opt
     * @return PromiseInterface
     */
    public function editMessageLiveLocation($latitude, $longitude, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        $required = compact("latitude", "longitude");
        $params = array_merge($required, $opt);
        return $this->callApi("editMessageLiveLocation", $params, Message::class);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires. On success, if the message was
     * sent by the bot, the sent @see Message is returned, otherwise True is returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function stopMessageLiveLocation(array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        return $this->callApi("stopMessageLiveLocation", $opt, Message::class);
    }

    /**
     * Use this method to send information about a venue. On success, the sent @see Message is returned.
     *
     * By default the venue is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendvenue
     *
     * @param $latitude
     * @param $longitude
     * @param string $title
     * @param string $address
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendVenue($latitude, $longitude, string $title, string $address, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("latitude", "longitude", "title", "address");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVenue", $params, Message::class);
    }

    /**
     * Use this method to send phone contacts. On success, the sent @see Message is returned.
     *
     * By default the contact is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendcontact
     *
     * @param string $phone_number
     * @param string $first_name
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendContact(string $phone_number, string $first_name, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("phone_number", "first_name");
        $params = array_merge($required, $opt);
        return $this->callApi("sendContact", $params, Message::class);
    }

    /**
     * Use this method to send a native poll. On success, the sent @see Message is returned.
     *
     * By default the poll is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendpoll
     *
     * @param string $question
     * @param $options
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendPoll(string $question, $options, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("question", "options");
        $params = array_merge($required, $opt);
        return $this->callApi("sendPoll", $params, Message::class);
    }

    /**
     * Use this method to send a dice, which will have a random value from 1 to 6. On success, the sent @see Message is returned.
     * (Yes, we're aware of the "proper" singular of die. But it's awkward, and we decided to help it change. One dice at
     * a time!)
     *
     * By default the dice is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#senddice
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendDice(array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        return $this->callApi("sendDice", $opt, Message::class);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5
     * seconds or less (when a message arrives from your bot, Telegram clients clear its typing status). Returns True on
     * success.
     *
     * By default the chat action is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendchataction
     *
     * @param string $action
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendChatAction(string $action, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("action");
        $params = array_merge($required, $opt);
        return $this->callApi("sendChatAction", $params);
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a @see UserProfilePhotos object.
     *
     * More on https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getUserProfilePhotos($user_id, array $opt = []): PromiseInterface
    {
        $required = compact("user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getUserProfilePhotos", $params, UserProfilePhotos::class);
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download
     * files of up to 20MB in size. On success, a @see File object is returned. The file can then be downloaded via the link
     * https://api.telegram.org/file/bot&lt;token&gt;/&lt;file_path&gt;, where &lt;file_path&gt; is taken from the
     * response. It is guaranteed that the link will be valid for at least 1 hour. When the link expires, a new one can
     * be requested by calling getFile again.
     *
     * More on https://core.telegram.org/bots/api#getfile
     *
     * @param string $file_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getFile(string $file_id, array $opt = []): PromiseInterface
    {
        $required = compact("file_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getFile", $params, File::class);
    }

    /**
     * Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels, the
     * user will not be able to return to the group on their own using invite links, etc., unless unbanned first. The bot
     * must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on
     * success.
     *
     * More on https://core.telegram.org/bots/api#kickchatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function kickChatMember($chat_id, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("kickChatMember", $params);
    }

    /**
     * Use this method to ban a user in a group, a supergroup or a channel. In the case of supergroups and channels,
     * the user will not be able to return to the chat on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#banchatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function banChatMember($chat_id, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("banChatMember", $params);
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup or channel. The user will not return to the
     * group or channel automatically, but will be able to join via link, etc. The bot must be an administrator for this
     * to work. By default, this method guarantees that after the call the user is not a member of the chat, but will be
     * able to join it. So if the user is a member of the chat they will also be removed from the chat. If you don't
     * want this, use the parameter only_if_banned. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function unbanChatMember($chat_id, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("unbanChatMember", $params);
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup for this to
     * work and must have the appropriate admin rights. Pass True for all permissions to lift restrictions from a user.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param $permissions
     * @param array $opt
     * @return PromiseInterface
     */
    public function restrictChatMember($chat_id, $user_id, $permissions, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id", "permissions");
        $params = array_merge($required, $opt);
        return $this->callApi("restrictChatMember", $params);
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel. The bot must be an administrator in the
     * chat for this to work and must have the appropriate admin rights. Pass False for all boolean parameters to demote
     * a user. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#promotechatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function promoteChatMember($chat_id, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("promoteChatMember", $params);
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param $chat_id
     * @param $user_id
     * @param string $custom_title
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatAdministratorCustomTitle($chat_id, $user_id, string $custom_title, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id", "custom_title");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatAdministratorCustomTitle", $params);
    }

    /**
     * Use this method to set default chat permissions for all members. The bot must be an administrator in the group or a
     * supergroup for this to work and must have the can_restrict_members admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param $chat_id
     * @param $permissions
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatPermissions($chat_id, $permissions, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "permissions");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatPermissions", $params);
    }

    /**
     * Use this method to generate a new invite link for a chat; any previously generated link is revoked. The bot must be
     * an administrator in the chat for this to work and must have the appropriate admin rights. Returns the new invite
     * link as String on success.
     *
     * More on https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function exportChatInviteLink($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("exportChatInviteLink", $params);
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats. The bot must be
     * an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatphoto
     *
     * @param $chat_id
     * @param $photo
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatPhoto($chat_id, $photo, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "photo");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatPhoto", $params); //bool
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats. The bot must be an administrator
     * in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteChatPhoto($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteChatPhoto", $params);
    }

    /**
     * Use this method to change the title of a chat. Titles can't be changed for private chats. The bot must be an
     * administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchattitle
     *
     * @param $chat_id
     * @param string $title
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatTitle($chat_id, string $title, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "title");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatTitle", $params);
    }

    /**
     * Use this method to change the description of a group, a supergroup or a channel. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatdescription
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatDescription($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatDescription", $params);
    }

    /**
     * Use this method to pin a message in a group, a supergroup, or a channel. The bot must be an administrator in the chat
     * for this to work and must have the 'can_pin_messages' admin right in the supergroup or 'can_edit_messages' admin
     * right in the channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param $chat_id
     * @param $message_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function pinChatMessage($chat_id, $message_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("pinChatMessage", $params);
    }

    /**
     * Use this method to unpin a message in a group, a supergroup, or a channel. The bot must be an administrator in the
     * chat for this to work and must have the 'can_pin_messages' admin right in the supergroup or 'can_edit_messages'
     * admin right in the channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function unpinChatMessage($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("unpinChatMessage", $params);
    }

    /**
     * Use this method to clear the list of pinned messages in a chat. If the chat is not a private chat, the bot must
     * be an administrator in the chat for this to work and must have the 'can_pin_messages' admin right in a supergroup
     * or 'can_edit_messages' admin right in a channel. Returns True on success.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#unpinallchatmessages
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function unpinAllChatMessages(array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        return $this->callApi("unpinAllChatMessages", $opt);
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#leavechat
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function leaveChat($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("leaveChat", $params);
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel, etc.). Returns a @see Chat object on success.
     *
     * More on https://core.telegram.org/bots/api#getchat
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getChat($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChat", $params, Chat::class);
    }

    /**
     * Use this method to get a list of administrators in a chat. On success, returns an Array of @see ChatMember objects that
     * contains information about all chat administrators except other bots. If the chat is a group or a supergroup and
     * no administrators were appointed, only the creator will be returned.
     *
     * More on https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getChatAdministrators($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatAdministrators", $params, ChatMember::class);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * More on https://core.telegram.org/bots/api#getchatmemberscount
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getChatMembersCount($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatMembersCount", $params); //integer
    }


    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * More on https://core.telegram.org/bots/api#getchatmembercount
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getChatMemberCount($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatMemberCount", $params); //integer
    }

    /**
     * Use this method to get information about a member of a chat. Returns a @see ChatMember object on success.
     *
     * More on https://core.telegram.org/bots/api#getchatmember
     *
     * @param $chat_id
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getChatMember($chat_id, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatMember", $params, ChatMember::class);
    }

    /**
     * Use this method to set a new group sticker set for a supergroup. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in
     * getChat requests to check if the bot can use this method. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param $chat_id
     * @param string $sticker_set_name
     * @param array $opt
     * @return PromiseInterface
     */
    public function setChatStickerSet($chat_id, string $sticker_set_name, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "sticker_set_name");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatStickerSet", $params);
    }

    /**
     * Use this method to delete a group sticker set from a supergroup. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in
     * getChat requests to check if the bot can use this method. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteChatStickerSet($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteChatStickerSet", $params);
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the
     * user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     *
     * By default it replies to the callback_query_id of the context's update. Use $opt param to specify a different
     * callback_query_id. Eg. $opt = ['callback_query_id' => 'abcdefgh'];
     *
     * More on https://core.telegram.org/bots/api#answercallbackquery
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function answerCallbackQuery(array $opt = []): PromiseInterface
    {
        if (!isset($opt['callback_query_id']) && $this->update) {
            $opt['callback_query_id'] = $this->update->getCallbackQuery()->getId();
        }
        return $this->callApi("answerCallbackQuery", $opt);
    }

    /**
     * Use this method to change the list of the bot's commands. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setmycommands
     *
     * @param $commands
     * @param array $opt
     * @return PromiseInterface
     */
    public function setMyCommands($commands, array $opt = []): PromiseInterface
    {
        $required = compact("commands");
        $params = array_merge($required, $opt);
        return $this->callApi("setMyCommands", $params);
    }

    /**
     * Use this method to delete the list of the bot's commands for the given scope and user language. After deletion,
     * higher level commands will be shown to affected users. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletemycommands
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteMyCommands(array $opt = []): PromiseInterface
    {
        return $this->callApi("deleteMyCommands", $opt);
    }

    /**
     * Use this method to get the current list of the bot's commands for the given scope and user language. Returns
     * Array of BotCommand on success. If commands aren't set, an empty list is returned.
     *
     * More on https://core.telegram.org/bots/api#getmycommands
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function getMyCommands(array $opt = []): PromiseInterface
    {
        return $this->callApi("getMyCommands", $opt, BotCommand::class);
    }

    /**
     * Use this method to change the bot's menu button in a private chat, or the default menu button.
     *
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     * @param array $opt = [
     *     'chat_id' => 123456789, // If not specified, default bot's menu button will be changed
     *     'menu_button' => ['type' => 'commands'],
     *     'menu_button' => ['type' => 'web_app', 'text' => 'Text on the button', 'web_app' => ['url' => 'https://']]
     * ]
     * @return PromiseInterface
     */
    public function setChatMenuButton(array $opt = []): PromiseInterface
    {
        return $this->callApi("setChatMenuButton", $opt);
    }

    /**
     * Use this method to get the current value of the bot's menu button in a private chat, or the default menu button.
     *
     * Returns @see MenuButton on success.
     *
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     * @param array $opt = [
     *     'chat_id' => 123456789, // If not specified, default bot's menu button will be returned
     * ]
     * @return PromiseInterface
     */
    public function getChatMenuButton(array $opt = []): PromiseInterface
    {
        return $this->callApi("getChatMenuButton", $opt, MenuButton::class);
    }

    /**
     * Use this method to change the default administrator rights requested by the bot
     * when it's added as an administrator to groups or channels.
     * These rights will be suggested to users, but they are free to modify the list before adding the bot.
     *
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
     * @param array $opt = [
     *     'rights' => [ // If not specified, the default administrator rights will be cleared.
     *       'is_anonymous' => true, 'can_manage_chat' => true, 'can_delete_messages' => true,
     *       'can_manage_video_chats' => true, 'can_restrict_members' => true, 'can_promote_members' => true,
     *       'can_change_info' => true, 'can_invite_users' => true, 'can_post_messages' => true,
     *       'can_edit_messages' => true, 'can_pin_messages' => true, 'can_manage_topics' => true
     *     ],
     *     'for_channels' => false
     * ]
     * @return PromiseInterface
     */
    public function setMyDefaultAdministratorRights(array $opt = []): PromiseInterface
    {
        return $this->callApi("setMyDefaultAdministratorRights", $opt);
    }

    /**
     * Use this method to get the current default administrator rights of the bot.
     *
     * Returns @see ChatAdministratorRights on success.
     *
     * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
     * @param array $opt = [
     *     'for_channels' => true, // Pass True to get default administrator rights of the bot in channels.
     * ]
     * @return PromiseInterface
     */
    public function getMyDefaultAdministratorRights(array $opt = []): PromiseInterface
    {
        return $this->callApi("getMyDefaultAdministratorRights", $opt, ChatAdministratorRights::class);
    }

    /**
     * Use this method to edit text and game messages. On success, if edited message is sent by the bot, the edited @see Message
     * is returned, otherwise True is returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#editmessagetext
     *
     * @param string $text
     * @param array $opt = [
     *     'reply_markup' => ['inline_keyboard' => [[
     *          ['callback_data' => 'data', 'text' => 'text']
     *      ]]]
     * ]
     * @return PromiseInterface
     */
    public function editMessageText(string $text, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        $required = compact("text");
        $params = array_merge($required, $opt);
        return $this->callApi("editMessageText", $params, Message::class);
    }

    /**
     * Use this method to edit captions of messages. On success, if edited message is sent by the bot, the edited @see Message is
     * returned, otherwise True is returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function editMessageCaption(array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        return $this->callApi("editMessageCaption", $opt, Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages. If a message is a part of a message
     * album, then it can be edited only to a photo or a video. Otherwise, message type can be changed arbitrarily. When
     * inline message is edited, new file can't be uploaded. Use previously uploaded file via its file_id or specify a
     * URL. On success, if the edited message was sent by the bot, the edited @see Message is returned, otherwise True is
     * returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#editmessagemedia
     *
     * @param $media
     * @param array $opt
     * @return PromiseInterface
     */
    public function editMessageMedia($media, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        $required = compact("media");
        $params = array_merge($required, $opt);
        return $this->callApi("editMessageMedia", $params, Message::class);
    }

    /**
     * Use this method to edit only the reply markup of messages. On success, if edited message is sent by the bot, the
     * edited @see Message is returned, otherwise True is returned.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param array $opt
     * @return PromiseInterface
     */
    public function editMessageReplyMarkup(array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        return $this->callApi("editMessageReplyMarkup", $opt, Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot. On success, the stopped @see Poll with the final results is
     * returned.
     *
     * More on https://core.telegram.org/bots/api#stoppoll
     *
     * @param $chat_id
     * @param $message_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function stopPoll($chat_id, $message_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("stopPoll", $params, Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:- A message can only
     * be deleted if it was sent less than 48 hours ago.- A dice message in a private chat can only be deleted if it was
     * sent more than 24 hours ago.- Bots can delete outgoing messages in private chats, groups, and supergroups.- Bots
     * can delete incoming messages in private chats.- Bots granted can_post_messages permissions can delete outgoing
     * messages in channels.- If the bot is an administrator of a group, it can delete any message there.- If the bot has
     * can_delete_messages permission in a supergroup or a channel, it can delete any message there.Returns True on
     * success.
     *
     * More on https://core.telegram.org/bots/api#deletemessage
     *
     * @param $chat_id
     * @param $message_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteMessage($chat_id, $message_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteMessage", $params);
    }

    /**
     * Use this method to send static .WEBP or animated .TGS stickers. On success, the sent @see Message is returned.
     *
     * The sticker param can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * By default the sticker is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendsticker
     *
     * @param $sticker
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendSticker($sticker, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("sticker");
        $params = array_merge($required, $opt);
        return $this->callApi("sendSticker", $params, Message::class);
    }

    /**
     * Use this method to get a sticker set. On success, a @see StickerSet object is returned.
     *
     * More on https://core.telegram.org/bots/api#getstickerset
     *
     * @param string $name
     * @param array $opt
     * @return PromiseInterface
     */
    public function getStickerSet(string $name, array $opt = []): PromiseInterface
    {
        $required = compact("name");
        $params = array_merge($required, $opt);
        return $this->callApi("getStickerSet", $params, StickerSet::class);
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet and addStickerToSet methods
     * (can be used multiple times). Returns the uploaded @see File on success.
     *
     * More on https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @param $user_id
     * @param $png_sticker
     * @param array $opt
     * @return PromiseInterface
     */
    public function uploadStickerFile($user_id, $png_sticker, array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "png_sticker");
        $params = array_merge($required, $opt);
        return $this->callApi("uploadStickerFile", $params, File::class);
    }

    /**
     * Use this method to create a new sticker set owned by a user. The bot will be able to edit the sticker set thus
     * created. You must use exactly one of the fields png_sticker, tgs_sticker, or webm_sticker. Returns True on success.
     *
     * The sticker param value in $opt can be either a string or a @see InputFile. Note that if you use the latter the
     * file reading operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * More on https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param $user_id
     * @param string $name
     * @param string $title
     * @param string $emojis
     * @param array $opt
     * @return PromiseInterface
     */
    public function createNewStickerSet($user_id, string $name, string $title, string $emojis, array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "name", "title", "emojis");
        $params = array_merge($required, $opt);
        return $this->callApi("createNewStickerSet", $params);
    }

    /**
     * Use this method to add a new sticker to a set created by the bot. You must use exactly one of the fields png_sticker
     * or tgs_sticker, or webm_sticker. Animated stickers can be added to animated sticker sets and only to them. Animated sticker sets
     * can have up to 50 stickers. Static sticker sets can have up to 120 stickers. Returns True on success.
     *
     * The sticker param value in $opt can be either a string or a @see InputFile. Note that if you use the latter the
     * file reading operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * More on https://core.telegram.org/bots/api#addstickertoset
     *
     * @param $user_id
     * @param string $name
     * @param string $emojis
     * @param array $opt
     * @return PromiseInterface
     */
    public function addStickerToSet($user_id, string $name, string $emojis, array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "name", "emojis");
        $params = array_merge($required, $opt);
        return $this->callApi("addStickerToSet", $params);
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @param string $sticker
     * @param int $position
     * @param array $opt
     * @return PromiseInterface
     */
    public function setStickerPositionInSet(string $sticker, int $position, array $opt = []): PromiseInterface
    {
        $required = compact("sticker", "position");
        $params = array_merge($required, $opt);
        return $this->callApi("setStickerPositionInSet", $params);
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @param string $sticker
     * @param array $opt
     * @return PromiseInterface
     */
    public function deleteStickerFromSet(string $sticker, array $opt = []): PromiseInterface
    {
        $required = compact("sticker");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteStickerFromSet", $params);
    }

    /**
     * Use this method to set the thumbnail of a sticker set. Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     *
     * The thumb param in $opt can be either a string or a @see InputFile. Note that if you use the latter the file reading
     * operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * More on https://core.telegram.org/bots/api#setstickersetthumb
     *
     * @param string $name
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function setStickerSetThumb(string $name, $user_id, array $opt = []): PromiseInterface
    {
        $required = compact("name", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("setStickerSetThumb", $params);
    }

    /**
     * Use this method to send answers to an inline query. On success, True is returned.No more than 50 results per query
     * are allowed.
     *
     * By default it replies to the inline_query_id of the context's update. Use $opt param to specify a different
     * inline_query_id. Eg. $opt = ['inline_query_id' => 'abcdefgh'];
     *
     * More on https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param $results
     * @param array $opt
     * @return PromiseInterface
     */
    public function answerInlineQuery($results, array $opt = []): PromiseInterface
    {
        if (!isset($opt['inline_query_id']) && $this->update) {
            $opt['inline_query_id'] = $this->update->getInlineQuery()->getId();
        }
        $required = compact("results");
        $params = array_merge($required, $opt);
        return $this->callApi("answerInlineQuery", $params);
    }

    /**
     * Use this method to set the result of an interaction with a Web App and send a corresponding message
     * on behalf of the user to the chat from which the query originated.
     *
     * On success, a {@see SentWebAppMessage} object is returned.
     *
     * @see https://core.telegram.org/bots/api#answerwebappquery
     * @param String $web_app_query_id Unique identifier for the query to be answered
     * @param array $result A JSON-serialized object describing the message to be sent
     * @param array $opt
     * @return PromiseInterface
     */
    public function answerWebAppQuery(string $web_app_query_id, array $result, array $opt = []): PromiseInterface
    {
        $required = compact("web_app_query_id","result");
        $params = array_merge($required, $opt);
        return $this->callApi("answerWebAppQuery", $params, SentWebAppMessage::class);
    }

    /**
     * Use this method to send invoices. On success, the sent @see Message is returned.
     *
     * By default the invoice is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendinvoice
     *
     * @param string $title
     * @param string $description
     * @param string $payload
     * @param string $provider_token
     * @param string|null $start_parameter optional
     * @param string $currency
     * @param $prices
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendInvoice(string $title, string $description, string $payload, string $provider_token, ?string $start_parameter, string $currency, $prices, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("title", "description", "payload", "provider_token", "start_parameter", "currency", "prices");
        $params = array_merge($required, $opt);
        return $this->callApi("sendInvoice", $params, Message::class);
    }

    /**
     * @param array $params
     * @return PromiseInterface
     */
    public function doSendInvoice(array $params): PromiseInterface
    {
        if (!isset($params['chat_id']) && $this->update) {
            $params['chat_id'] = $this->update->getEffectiveChat()->getId();
        }
        return $this->callApi("sendInvoice", $params, Message::class);
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API will
     * send an Update with a shipping_query field to the bot. Use this method to reply to shipping queries. On success,
     * True is returned.
     *
     * By default it replies to the shipping_query_id of the context's update. Use $opt param to specify a different
     * shipping_query_id. Eg. $opt = ['shipping_query_id' => 'abcdefgh'];
     *
     * More on https://core.telegram.org/bots/api#answershippingquery
     *
     * @param $ok
     * @param array $opt
     * @return PromiseInterface
     */
    public function answerShippingQuery($ok, array $opt = []): PromiseInterface
    {
        if (!isset($opt['shipping_query_id']) && $this->update) {
            $opt['shipping_query_id'] = $this->update->getShippingQuery()->getId();
        }
        $required = compact("ok");
        $params = array_merge($required, $opt);
        return $this->callApi("answerShippingQuery", $params);
    }

    /**
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation in the form
     * of an Update with the field pre_checkout_query. Use this method to respond to such pre-checkout queries. On
     * success, True is returned. Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query
     * was sent.
     *
     * By default it replies to the pre_checkout_query_id of the context's update. Use $opt param to specify a different
     * pre_checkout_query_id. Eg. $opt = ['pre_checkout_query_id' => 'abcdefgh'];
     *
     * More on https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @param $ok
     * @param array $opt
     * @return PromiseInterface
     */
    public function answerPreCheckoutQuery($ok, array $opt = []): PromiseInterface
    {
        if (!isset($opt['pre_checkout_query_id']) && $this->update) {
            $opt['pre_checkout_query_id'] = $this->update->getPreCheckoutQuery()->getId();
        }
        $required = compact("ok");
        $params = array_merge($required, $opt);
        return $this->callApi("answerPreCheckoutQuery", $params);
    }

    /**
     * Informs a user that some of the Telegram Passport elements they provided contains errors. The user will not be able
     * to re-submit their Passport to you until the errors are fixed (the contents of the field for which you returned
     * the error must change). Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param $user_id
     * @param $errors
     * @param array $opt
     * @return PromiseInterface
     */
    public function setPassportDataErrors($user_id, $errors, array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "errors");
        $params = array_merge($required, $opt);
        return $this->callApi("setPassportDataErrors", $params);
    }

    /**
     * Use this method to send a game. On success, the sent @see Message is returned.
     *
     * By default the game is sent to the chat_id of the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#sendgame
     *
     * @param string $game_short_name
     * @param array $opt
     * @return PromiseInterface
     */
    public function sendGame(string $game_short_name, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveChatId($opt);
        $required = compact("game_short_name");
        $params = array_merge($required, $opt);
        return $this->callApi("sendGame", $params, Message::class);
    }

    /**
     * Use this method to set the score of the specified user in a game. On success, if the message was sent by the bot,
     * returns the edited @see Message, otherwise returns True. Returns an error, if the new score is not greater than the
     * user's current score in the chat and force is False.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#setgamescore
     *
     * @param $user_id
     * @param int $score
     * @param array $opt
     * @return PromiseInterface
     */
    public function setGameScore($user_id, int $score, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        $required = compact("user_id", "score");
        $params = array_merge($required, $opt);
        return $this->callApi("setGameScore", $params, Message::class);
    }

    /**
     * Use this method to get data for high score tables. Will return the score of the specified user and several of his
     * neighbors in a game. On success, returns an Array of @see GameHighScore objects.
     *
     * By default the chat_id is taken from the context's update. Use $opt param to specify a different
     * chat_id. Eg. $opt = ['chat_id' => 123456789];
     *
     * By default the message_id is taken from the context's update. Use $opt param to specify a different
     * message_id. Eg. $opt = ['message_id' => 123456789];
     *
     * By default the inline_message_id is taken from the context's update. Use $opt param to specify a different
     * inline_message_id. Eg. $opt = ['inline_message_id' => 123456789];
     *
     * More on https://core.telegram.org/bots/api#getgamehighscores
     *
     * @param $user_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function getGameHighScores($user_id, array $opt = []): PromiseInterface
    {
        $opt = $this->resolveMessageId($opt);
        $required = compact("user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getGameHighScores", $params, GameHighScore::class);
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally. You must log out the
     * bot before running it locally, otherwise there is no guarantee that the bot will receive updates. After a
     * successful call, you can immediately log in on a local server, but will not be able to log in back to the
     * cloud Bot API server for 10 minutes. Returns True on success. Requires no parameters.
     *
     * More on https://core.telegram.org/bots/api#logout
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @return PromiseInterface
     */
    public function logOut(): PromiseInterface
    {
        return $this->callApi("logOut");
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another. You need to delete
     * the webhook before calling this method to ensure that the bot isn't launched again after server restart. The
     * method will return error 429 in the first 10 minutes after the bot is launched. Returns True on success.
     * Requires no parameters.
     *
     * More on https://core.telegram.org/bots/api#close
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @return PromiseInterface
     */
    public function close(): PromiseInterface
    {
        return $this->callApi("close");
    }

    /**
     * Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. The link can be revoked using the method
     * revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
     *
     * More on https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @param $chat_id
     * @param array $opt
     * @return PromiseInterface
     */
    public function createChatInviteLink($chat_id, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("createChatInviteLink", $params, ChatInviteLink::class);
    }

    /**
     * Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. The link can be revoked using the method
     * revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
     *
     * More on https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @param $chat_id
     * @param $invite_link
     * @param array $opt
     * @return PromiseInterface
     */
    public function editChatInviteLink($chat_id, $invite_link, array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "invite_link");
        $params = array_merge($required, $opt);
        return $this->callApi("editChatInviteLink", $params, ChatInviteLink::class);
    }

    /**
     * Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. The link can be revoked using the method
     * revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
     *
     * More on https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @param $chat_id
     * @param $invite_link
     * @return PromiseInterface
     */
    public function revokeChatInviteLink($chat_id, $invite_link): PromiseInterface
    {
        $required = compact("chat_id", "invite_link");
        return $this->callApi("revokeChatInviteLink", $required, ChatInviteLink::class);
    }

    /**
     * Use this method to approve a chat join request. The bot must be an administrator in the chat for this to work and
     * must have the can_invite_users administrator right. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#approvechatjoinrequest
     *
     * @param $chat_id mixed Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param $user_id mixed Unique identifier of the target user
     * @return PromiseInterface
     */
    public function approveChatJoinRequest($chat_id, $user_id): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        return $this->callApi("approveChatJoinRequest", $required);
    }

    /**
     * Use this method to decline a chat join request. The bot must be an administrator in the chat for this to work and
     * must have the can_invite_users administrator right. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @param $chat_id mixed Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param $user_id mixed Unique identifier of the target user
     * @return PromiseInterface
     */
    public function declineChatJoinRequest($chat_id, $user_id): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        return $this->callApi("declineChatJoinRequest", $required);
    }

    /**
     * Use this method to ban a channel chat in a supergroup or a channel. Until the chat is unbanned, the owner of the
     * banned chat won't be able to send messages on behalf of any of their channels. The bot must be an administrator
     * in the supergroup or channel for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @param $chat_id mixed Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param $sender_chat_id mixed Unique identifier of the target sender chat
     * @return PromiseInterface
     */
    public function banChatSenderChat($chat_id, $sender_chat_id): PromiseInterface
    {
        $required = compact("chat_id", "sender_chat_id");
        return $this->callApi("banChatSenderChat", $required);
    }

    /**
     * Use this method to unban a previously banned channel chat in a supergroup or channel. The bot must be an administrator
     * for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @param $chat_id mixed Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param $sender_chat_id mixed Unique identifier of the target sender chat
     * @return PromiseInterface
     */
    public function unbanChatSenderChat($chat_id, $sender_chat_id): PromiseInterface
    {
        $required = compact("chat_id", "sender_chat_id");
        return $this->callApi("unbanChatSenderChat", $required);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $class
     * @param string[] $headers
     * @return PromiseInterface
     */
    public function callApi(string $method, array $params = [], string $class = 'Scalar', $headers = ["Content-type" => "application/json"])
    {
        if ($this->container->get(Config::class)->getParseMode() && !isset($params['parse_mode'])) {
            $params['parse_mode'] = $this->container->get(Config::class)->getParseMode();
        }
        $browser = $this->browser;
        if (isset($params['request_timeout'])) {
            $browser = $browser->withTimeout($params['request_timeout']);
        }
        foreach ($params as $param) {
            if ($param instanceof InputFile) {

                $async = $this->container->get(Config::class)->isReactFileSystem();

                if ($async) {
                    return $this->prepareMultipartDataAsync($params)->then(function ($result) use ($browser, $class, $params, $method) {
                        $headers = array("Content-Length" => $result->getSize(), "Content-Type" => "multipart/form-data; boundary={$result->getBoundary()}");
                        return $this->wrapPromise($browser->post($method, $headers, $result), $method, $params, $class);
                    });
                } else {
                    $multipart = $this->prepareMultipartData($params);
                    $headers = array("Content-Length" => $multipart->getSize(), "Content-Type" => "multipart/form-data; boundary={$multipart->getBoundary()}");
                    return $this->wrapPromise($browser->post($method, $headers, $multipart), $method, $params, $class);
                }
            }
        }
        return $this->wrapPromise($browser->post($method, $headers, json_encode($params)), $method, $params, $class);
    }

    /**
     *
     * Create MultipartStream, iterate over params to find InputFile
     *
     * @param $params
     * @return PromiseInterface
     */
    private function prepareMultipartDataAsync($params)
    {
        $filesystem = $this->container->get(\React\Filesystem\Filesystem::class);
        $multipart_data = [];
        $promises = [];
        foreach ($params as $key => $value) {

            if ($value instanceof InputFile) {
                array_push($promises, $filesystem->getContents($value->getPath())->then(function ($contents) use ($value, $key) {
                    $data = ['name' => $key];
                    $data['contents'] = $contents;
                    $data['filename'] = basename($value->getPath());
                    return $data;
                }, function ($error) {
                    $this->container->get(ZanzaraLogger::class)->error($error);
                    return $error;
                }));

            } else {
                $data = ['name' => $key];
                $data['contents'] = is_array($value) ? json_encode($value) : strval($value);
                array_push($multipart_data, $data);
            }
        }

        return all($promises)->then(function ($files) use ($multipart_data) {
            foreach ($files as $key => $value) {
                array_push($multipart_data, $value);
            }
            return new MultipartStream($multipart_data);
        }, function ($error) {
            $this->container->get(ZanzaraLogger::class)->error($error);
            return $error;
        });
    }

    private function prepareMultipartData($params)
    {
        $multipart_data = [];
        foreach ($params as $key => $value) {
            $data = ['name' => $key];
            if ($value instanceof InputFile) {
                if (file_exists($value->getPath())) {
                    $fileData = file_get_contents($value->getPath());
                    $data['contents'] = $fileData;
                    $data['filename'] = basename($value->getPath());
                } else {
                    $this->container->get(ZanzaraLogger::class)->error("File not found: {$value->getPath()}");
                }

            } else {
                $data['contents'] = is_array($value) ? json_encode($value) : strval($value);
            }
            array_push($multipart_data, $data);
        }
        return new MultipartStream($multipart_data);
    }

    /**
     * ZanzaraPromise class was removed since it swallowed the promise chain.
     * We actually have to call the original promise, get the response and propagate the casted response along
     * the promise chain.
     * For the rejected promise, we have to cast the original exception to a TelegramException and rethrow it
     * in order to let the user receive the exception in his onRejected function.
     *
     * Unfortunately, we don't have control on user's callback input parameter anymore. In this way the user
     * needs to manage the otherwise() promise callback to see the error.
     *
     * @param PromiseInterface $promise
     * @param string $method
     * @param array $params
     * @param string $class
     * @return PromiseInterface
     */
    private function wrapPromise(PromiseInterface $promise, string $method, array $params = [], string $class = "Scalar"): PromiseInterface
    {
        $mapper = $this->container->get(ZanzaraMapper::class);
        $logger = $this->container->get(ZanzaraLogger::class);

        return $promise
            ->then(function (ResponseInterface $response) use ($class, $mapper) {
                $json = (string)$response->getBody();
                $object = json_decode($json);

                if (is_scalar($object->result) && $class === "Scalar") {
                    return $object->result;
                }

                return $mapper->mapObject($object->result, $class);
            }, function ($e) use ($method, $params, $logger, $mapper) {
                if ($e instanceof ResponseException) {
                    // with the introduction of Local Api server (https://core.telegram.org/bots/api#using-a-local-bot-api-server)
                    // we can no longer assume that the response is with the TelegramException format, so catch any mapping
                    // exception
                    try {
                        $json = (string)$e->getResponse()->getBody();
                        $e = $mapper->mapJson($json, TelegramException::class);
                    } catch (\Exception $ignore) {
                        // ignore
                    }
                }
                $logger->errorTelegramApi($method, $params, $e);
                throw $e;
            });
    }

    /**
     * @param array $opt
     * @return array
     */
    public function resolveMessageId(array $opt): array
    {
        // if the user doesn't provide inline_message_id, chat_id or message_id the framework tries to resolve them
        // based on the Update's type
        if ($this->update) {
            if (!isset($opt['inline_message_id']) && !isset($opt['chat_id']) && !isset($opt['message_id'])) {
                if ($this->update->getUpdateType() == CallbackQuery::class) {
                    $cbQuery = $this->update->getCallbackQuery();
                    if ($cbQuery->getInlineMessageId()) {
                        $opt['inline_message_id'] = $cbQuery->getInlineMessageId();
                    } else if ($cbQuery->getMessage()) {
                        $opt['message_id'] = $cbQuery->getMessage()->getMessageId();
                    }
                }
                // set chat_id only if inline_message_id wasn't set
                if (!isset($opt['inline_message_id']) && $this->update->getEffectiveChat()) {
                    $opt['chat_id'] = $this->update->getEffectiveChat()->getId();
                }
            }
        }
        return $opt;
    }

    /**
     * @param array $opt
     * @return array
     */
    public function resolveChatId(array $opt): array
    {
        if (!isset($opt['chat_id']) && $this->update && $this->update->getEffectiveChat()) {
            $opt['chat_id'] = $this->update->getEffectiveChat()->getId();
        }
        return $opt;
    }

}