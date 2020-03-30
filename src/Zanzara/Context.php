<?php

declare(strict_types=1);

namespace Zanzara;

use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\ChosenInlineResult;
use Zanzara\Telegram\Type\EditedChannelPost;
use Zanzara\Telegram\Type\EditedMessage;
use Zanzara\Telegram\Type\InlineQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Poll\PollAnswer;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Update;

/**
 * @see Telegram shortcut methods
 * @method PromiseInterface callApi(string $method, array $params)
 * @method PromiseInterface sendMessage(int $chat_id, string $text, ?array $opt = [])
 * @method PromiseInterface forwardMessage(int $chat_id, int $from_chat_id, int $message_id, ?array $opt = [])
 * @method PromiseInterface sendPhoto(int $chat_id, $photo, ?array $opt = [])
 * @method PromiseInterface sendAudio(int $chat_id, $audio, ?array $opt = [])
 * @method PromiseInterface sendDocument(int $chat_id, $document, ?array $opt = [])
 * @method PromiseInterface sendVideo(int $chat_id, $video, ?array $opt = [])
 * @method PromiseInterface sendAnimation(int $chat_id, $animation, ?array $opt = [])
 * @method PromiseInterface sendVoice(int $chat_id, $voice, ?array $opt = [])
 * @method PromiseInterface sendVideoNote(int $chat_id, $video_note, ?array $opt = [])
 * @method PromiseInterface sendMediaGroup(int $chat_id, $media, ?array $opt = [])
 * @method PromiseInterface sendLocation(int $chat_id, $latitude, $longitude, ?array $opt = [])
 * @method PromiseInterface editMessageLiveLocation($latitude, $longitude, ?array $opt = [])
 * @method PromiseInterface stopMessageLiveLocation(?array $opt = [])
 * @method PromiseInterface sendVenue(int $chat_id, $latitude, $longitude, string $title, string $address, ?array $opt = [])
 * @method PromiseInterface sendContact(int $chat_id, string $phone_number, string $first_name, ?array $opt = [])
 * @method PromiseInterface sendPoll(int $chat_id, string $question, $options, ?array $opt = [])
 * @method PromiseInterface sendDice(int $chat_id, ?array $opt = [])
 * @method PromiseInterface sendChatAction(int $chat_id, string $action, ?array $opt = [])
 * @method PromiseInterface getUserProfilePhotos(int $user_id, ?array $opt = [])
 * @method PromiseInterface getFile(string $file_id, ?array $opt = [])
 * @method PromiseInterface kickChatMember(int $chat_id, int $user_id, ?array $opt = [])
 * @method PromiseInterface unbanChatMember(int $chat_id, int $user_id, ?array $opt = [])
 * @method PromiseInterface restrictChatMember(int $chat_id, int $user_id, $permissions, ?array $opt = [])
 * @method PromiseInterface promoteChatMember(int $chat_id, int $user_id, ?array $opt = [])
 * @method PromiseInterface setChatAdministratorCustomTitle(int $chat_id, int $user_id, string $custom_title, ?array $opt = [])
 * @method PromiseInterface setChatPermissions(int $chat_id, $permissions, ?array $opt = [])
 * @method PromiseInterface exportChatInviteLink(int $chat_id, ?array $opt = [])
 * @method PromiseInterface setChatPhoto(int $chat_id, $photo, ?array $opt = [])
 * @method PromiseInterface deleteChatPhoto(int $chat_id, ?array $opt = [])
 * @method PromiseInterface setChatTitle(int $chat_id, string $title, ?array $opt = [])
 * @method PromiseInterface setChatDescription(int $chat_id, ?array $opt = [])
 * @method PromiseInterface pinChatMessage(int $chat_id, int $message_id, ?array $opt = [])
 * @method PromiseInterface unpinChatMessage(int $chat_id, ?array $opt = [])
 * @method PromiseInterface leaveChat(int $chat_id, ?array $opt = [])
 * @method PromiseInterface getChat(int $chat_id, ?array $opt = [])
 * @method PromiseInterface getChatAdministrators(int $chat_id, ?array $opt = [])
 * @method PromiseInterface getChatMembersCount(int $chat_id, ?array $opt = [])
 * @method PromiseInterface getChatMember(int $chat_id, int $user_id, ?array $opt = [])
 * @method PromiseInterface setChatStickerSet(int $chat_id, string $sticker_set_name, ?array $opt = [])
 * @method PromiseInterface deleteChatStickerSet(int $chat_id, ?array $opt = [])
 * @method PromiseInterface answerCallbackQuery(string $callback_query_id, ?array $opt = [])
 * @method PromiseInterface setMyCommands($commands, ?array $opt = [])
 *
 * @see Update shortcut methods
 * @method int getUpdateId()
 * @method Message|null getMessage()
 * @method EditedMessage|null getEditedMessage()
 * @method ChannelPost|null getChannelPost()
 * @method EditedChannelPost|null getEditedChannelPost()
 * @method InlineQuery|null getInlineQuery()
 * @method ChosenInlineResult|null getChosenInlineResult()
 * @method CallbackQuery|null getCallbackQuery()
 * @method ShippingQuery|null getShippingQuery()
 * @method PreCheckoutQuery|null getPreCheckoutQuery()
 * @method Poll|null getPoll()
 * @method PollAnswer|null getPollAnswer()
 *
 */
class Context
{

    /**
     * The update received from Telegram.
     *
     * @var Update
     */
    private $update;

    /**
     * @var Telegram
     */
    private $telegram;

    /**
     * Array used to pass data between middleware.
     *
     * @var array
     */
    private $data = [];

    /**
     * @param Update $update
     * @param Telegram $telegram
     */
    public function __construct(Update $update, Telegram $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return Telegram
     */
    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $res = null;
        if (method_exists($this->telegram, $name)) {
            $res = call_user_func_array([$this->telegram, $name], $arguments);
        } else if (method_exists($this->update, $name)) {
            $res = call_user_func_array([$this->update, $name], $arguments);
        }
        return $res;
    }

}
