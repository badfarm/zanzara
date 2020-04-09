<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\Chat;
use Zanzara\Telegram\Type\ChatMember;
use Zanzara\Telegram\Type\File\File;
use Zanzara\Telegram\Type\File\StickerSet;
use Zanzara\Telegram\Type\File\UserProfilePhotos;
use Zanzara\Telegram\Type\Game\GameHighScore;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Update;

/**
 *
 */
trait TelegramTrait
{

    /**
     * @return Browser
     */
    protected abstract function getBrowser(): Browser;

    /**
     * @return Update
     */
    protected abstract function getUpdate(): Update;

    /**
     * @return ZanzaraMapper
     */
    protected abstract function getZanzaraMapper(): ZanzaraMapper;

    /**
     * @param int|null $offset
     * @return PromiseInterface
     */
    public function getUpdates(?int $offset = 1): PromiseInterface
    {
        $method = "getUpdates";

        $timeout = 50;

        $params = [
            "offset" => $offset,
            "limit" => 100, //telegram default is 100 if unspecified
            "timeout" => $timeout
        ];

        $query = http_build_query($params);

        $browser = $this->getBrowser()->withOptions(array(
            "timeout" => $timeout + 10 //timout browser necessary bigger than telegram timeout. They can't be equal
        ));

        return new ZanzaraPromise($this->getZanzaraMapper(), $browser->get("$method?$query"), Update::class);
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendmessage
     *
     * @param int $chat_id
     * @param string $text
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendMessage(int $chat_id, string $text, ?array $opt = [])
    {
        $required = compact("chat_id", "text");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendMessage", $params), Message::class);
    }

    /**
     * @param string $message
     * @return PromiseInterface
     */
    public function reply(string $message)
    {
        return $this->sendMessage($this->getUpdate()->getEffectiveChat()->getId(), $message);
    }

    /**
     * Use this method to specify a url and receive incoming updates via an outgoing webhook. Whenever there is an update
     * for the bot, we will send an HTTPS POST request to the specified url, containing a JSON-serialized Update. In case
     * of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setwebhook
     *
     * @param string $url
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setWebhook(string $url, ?array $opt = []): PromiseInterface
    {
        $required = compact("url");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setWebhook", $params));
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#forwardmessage
     *
     * @param int $chat_id
     * @param int $from_chat_id
     * @param int $message_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function forwardMessage(int $chat_id, int $from_chat_id, int $message_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "from_chat_id", "message_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("forwardMessage", $params), Message::class);
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendphoto
     *
     * @param int $chat_id
     * @param $photo
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendPhoto(int $chat_id, $photo, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "photo");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendPhoto", $params), Message::class);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player. Your audio
     * must be in the .MP3 or .M4A format. On success, the sent Message is returned. Bots can currently send audio files
     * of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendaudio
     *
     * @param int $chat_id
     * @param $audio
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendAudio(int $chat_id, $audio, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "audio");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendAudio", $params), Message::class);
    }

    /**
     * Use this method to send general files. On success, the sent Message is returned. Bots can currently send files of any
     * type of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#senddocument
     *
     * @param int $chat_id
     * @param $document
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendDocument(int $chat_id, $document, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "document");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendDocument", $params), Message::class);
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document). On
     * success, the sent Message is returned. Bots can currently send video files of up to 50 MB in size, this limit may
     * be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendvideo
     *
     * @param int $chat_id
     * @param $video
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVideo(int $chat_id, $video, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "video");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendVideo", $params), Message::class);
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound). On success, the sent Message
     * is returned. Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the
     * future.
     *
     * More on https://core.telegram.org/bots/api#sendanimation
     *
     * @param int $chat_id
     * @param $animation
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendAnimation(int $chat_id, $animation, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "animation");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendAnimation", $params), Message::class);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .OGG file encoded with OPUS (other formats may be sent as Audio or
     * Document). On success, the sent Message is returned. Bots can currently send voice messages of up to 50 MB in
     * size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendvoice
     *
     * @param int $chat_id
     * @param $voice
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVoice(int $chat_id, $voice, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "voice");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendVoice", $params), Message::class);
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long. Use this method to send video
     * messages. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendvideonote
     *
     * @param int $chat_id
     * @param $video_note
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVideoNote(int $chat_id, $video_note, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "video_note");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendVideoNote", $params), Message::class);
    }

    /**
     * Use this method to send a group of photos or videos as an album. On success, an array of the sent Messages is returned.
     *
     * More on https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param int $chat_id
     * @param $media
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendMediaGroup(int $chat_id, $media, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "media");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendMediaGroup", $params), Message::class);
    }

    /**
     * Use this method to send point on the map. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendlocation
     *
     * @param int $chat_id
     * @param $latitude
     * @param $longitude
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendLocation(int $chat_id, $latitude, $longitude, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "latitude", "longitude");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendLocation", $params), Message::class);
    }

    /**
     * Use this method to edit live location messages. A location can be edited until its live_period expires or editing is
     * explicitly disabled by a call to stopMessageLiveLocation. On success, if the edited message was sent by the bot,
     * the edited Message is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @param $latitude
     * @param $longitude
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageLiveLocation($latitude, $longitude, ?array $opt = []): PromiseInterface
    {
        $required = compact("latitude", "longitude");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("editMessageLiveLocation", $params), Message::class);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires. On success, if the message was
     * sent by the bot, the sent Message is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function stopMessageLiveLocation(?array $opt = []): PromiseInterface
    {
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("stopMessageLiveLocation", $opt), Message::class);
    }

    /**
     * Use this method to send information about a venue. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendvenue
     *
     * @param int $chat_id
     * @param $latitude
     * @param $longitude
     * @param string $title
     * @param string $address
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVenue(int $chat_id, $latitude, $longitude, string $title, string $address, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "latitude", "longitude", "title", "address");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendVenue", $params), Message::class);
    }

    /**
     * Use this method to send phone contacts. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendcontact
     *
     * @param int $chat_id
     * @param string $phone_number
     * @param string $first_name
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendContact(int $chat_id, string $phone_number, string $first_name, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "phone_number", "first_name");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendContact", $params), Message::class);
    }

    /**
     * Use this method to send a native poll. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendpoll
     *
     * @param int $chat_id
     * @param string $question
     * @param $options
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendPoll(int $chat_id, string $question, $options, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "question", "options");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendPoll", $params), Message::class);
    }

    /**
     * Use this method to send a dice, which will have a random value from 1 to 6. On success, the sent Message is returned.
     * (Yes, we're aware of the "proper" singular of die. But it's awkward, and we decided to help it change. One dice at
     * a time!)
     *
     * More on https://core.telegram.org/bots/api#senddice
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendDice(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendDice", $params), Message::class);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5
     * seconds or less (when a message arrives from your bot, Telegram clients clear its typing status). Returns True on
     * success.
     *
     * More on https://core.telegram.org/bots/api#sendchataction
     *
     * @param int $chat_id
     * @param string $action
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendChatAction(int $chat_id, string $action, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "action");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendChatAction", $params));
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
     *
     * More on https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getUserProfilePhotos(int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getUserProfilePhotos", $params), UserProfilePhotos::class);
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download
     * files of up to 20MB in size. On success, a File object is returned. The file can then be downloaded via the link
     * https://api.telegram.org/file/bot&lt;token&gt;/&lt;file_path&gt;, where &lt;file_path&gt; is taken from the
     * response. It is guaranteed that the link will be valid for at least 1 hour. When the link expires, a new one can
     * be requested by calling getFile again.
     *
     * More on https://core.telegram.org/bots/api#getfile
     *
     * @param string $file_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getFile(string $file_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("file_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getFile", $params), File::class);
    }

    /**
     * Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels, the
     * user will not be able to return to the group on their own using invite links, etc., unless unbanned first. The bot
     * must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on
     * success.
     *
     * More on https://core.telegram.org/bots/api#kickchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function kickChatMember(int $chat_id, int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("kickChatMember", $params));
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup or channel. The user will not return to the group
     * or channel automatically, but will be able to join via link, etc. The bot must be an administrator for this to
     * work. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function unbanChatMember(int $chat_id, int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("unbanChatMember", $params));
    }

    /**
     * Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup for this to
     * work and must have the appropriate admin rights. Pass True for all permissions to lift restrictions from a user.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param $permissions
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function restrictChatMember(int $chat_id, int $user_id, $permissions, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id", "permissions");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("restrictChatMember", $params));
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel. The bot must be an administrator in the
     * chat for this to work and must have the appropriate admin rights. Pass False for all boolean parameters to demote
     * a user. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#promotechatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function promoteChatMember(int $chat_id, int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("promoteChatMember", $params));
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param int $chat_id
     * @param int $user_id
     * @param string $custom_title
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatAdministratorCustomTitle(int $chat_id, int $user_id, string $custom_title, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id", "custom_title");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatAdministratorCustomTitle", $params));
    }

    /**
     * Use this method to set default chat permissions for all members. The bot must be an administrator in the group or a
     * supergroup for this to work and must have the can_restrict_members admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param int $chat_id
     * @param $permissions
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatPermissions(int $chat_id, $permissions, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "permissions");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatPermissions", $params));
    }

    /**
     * Use this method to generate a new invite link for a chat; any previously generated link is revoked. The bot must be
     * an administrator in the chat for this to work and must have the appropriate admin rights. Returns the new invite
     * link as String on success.
     *
     * More on https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function exportChatInviteLink(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("exportChatInviteLink", $params));
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats. The bot must be
     * an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatphoto
     *
     * @param int $chat_id
     * @param $photo
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatPhoto(int $chat_id, $photo, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "photo");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatPhoto", $params)); //bool
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats. The bot must be an administrator
     * in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteChatPhoto(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("deleteChatPhoto", $params));
    }

    /**
     * Use this method to change the title of a chat. Titles can't be changed for private chats. The bot must be an
     * administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchattitle
     *
     * @param int $chat_id
     * @param string $title
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatTitle(int $chat_id, string $title, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "title");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatTitle", $params));
    }

    /**
     * Use this method to change the description of a group, a supergroup or a channel. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatdescription
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatDescription(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatDescription", $params));
    }

    /**
     * Use this method to pin a message in a group, a supergroup, or a channel. The bot must be an administrator in the chat
     * for this to work and must have the 'can_pin_messages' admin right in the supergroup or 'can_edit_messages' admin
     * right in the channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param int $chat_id
     * @param int $message_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function pinChatMessage(int $chat_id, int $message_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("pinChatMessage", $params));
    }

    /**
     * Use this method to unpin a message in a group, a supergroup, or a channel. The bot must be an administrator in the
     * chat for this to work and must have the 'can_pin_messages' admin right in the supergroup or 'can_edit_messages'
     * admin right in the channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function unpinChatMessage(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("unpinChatMessage", $params));
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#leavechat
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function leaveChat(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("leaveChat", $params));
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel, etc.). Returns a Chat object on success.
     *
     * More on https://core.telegram.org/bots/api#getchat
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChat(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getChat", $params), Chat::class);
    }

    /**
     * Use this method to get a list of administrators in a chat. On success, returns an Array of ChatMember objects that
     * contains information about all chat administrators except other bots. If the chat is a group or a supergroup and
     * no administrators were appointed, only the creator will be returned.
     *
     * More on https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChatAdministrators(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getChatAdministrators", $params), ChatMember::class);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * More on https://core.telegram.org/bots/api#getchatmemberscount
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChatMembersCount(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getChatMembersCount", $params)); //integer
    }

    /**
     * Use this method to get information about a member of a chat. Returns a ChatMember object on success.
     *
     * More on https://core.telegram.org/bots/api#getchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChatMember(int $chat_id, int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getChatMember", $params), ChatMember::class);
    }

    /**
     * Use this method to set a new group sticker set for a supergroup. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in
     * getChat requests to check if the bot can use this method. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param int $chat_id
     * @param string $sticker_set_name
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatStickerSet(int $chat_id, string $sticker_set_name, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "sticker_set_name");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setChatStickerSet", $params));
    }

    /**
     * Use this method to delete a group sticker set from a supergroup. The bot must be an administrator in the chat for
     * this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in
     * getChat requests to check if the bot can use this method. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteChatStickerSet(int $chat_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("deleteChatStickerSet", $params));
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the
     * user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     *
     * More on https://core.telegram.org/bots/api#answercallbackquery
     *
     * @param string $callback_query_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function answerCallbackQuery(string $callback_query_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("callback_query_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("answerCallbackQuery", $params));
    }

    /**
     * Use this method to change the list of the bot's commands. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setmycommands
     *
     * @param $commands
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setMyCommands($commands, ?array $opt = []): PromiseInterface
    {
        $required = compact("commands");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setMyCommands", $params));
    }

    /**
     * Use this method to edit text and game messages. On success, if edited message is sent by the bot, the edited Message
     * is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagetext
     *
     * @param string $text
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageText(string $text, ?array $opt = []): PromiseInterface
    {
        $required = compact("text");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("editMessageText", $params), Message::class);
    }

    /**
     * Use this method to edit captions of messages. On success, if edited message is sent by the bot, the edited Message is
     * returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageCaption(?array $opt = []): PromiseInterface
    {
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("editMessageCaption", $opt), Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages. If a message is a part of a message
     * album, then it can be edited only to a photo or a video. Otherwise, message type can be changed arbitrarily. When
     * inline message is edited, new file can't be uploaded. Use previously uploaded file via its file_id or specify a
     * URL. On success, if the edited message was sent by the bot, the edited Message is returned, otherwise True is
     * returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagemedia
     *
     * @param $media
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageMedia($media, ?array $opt = []): PromiseInterface
    {
        $required = compact("media");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("editMessageMedia", $params), Message::class);
    }

    /**
     * Use this method to edit only the reply markup of messages. On success, if edited message is sent by the bot, the
     * edited Message is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageReplyMarkup(?array $opt = []): PromiseInterface
    {
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("editMessageReplyMarkup", $opt), Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot. On success, the stopped Poll with the final results is
     * returned.
     *
     * More on https://core.telegram.org/bots/api#stoppoll
     *
     * @param int $chat_id
     * @param int $message_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function stopPoll(int $chat_id, int $message_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("stopPoll", $params), Poll::class);
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
     * @param int $chat_id
     * @param int $message_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteMessage(int $chat_id, int $message_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("deleteMessage", $params));
    }

    /**
     * Use this method to send static .WEBP or animated .TGS stickers. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendsticker
     *
     * @param int $chat_id
     * @param $sticker
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendSticker(int $chat_id, $sticker, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "sticker");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendSticker", $params), Message::class);
    }

    /**
     * Use this method to get a sticker set. On success, a StickerSet object is returned.
     *
     * More on https://core.telegram.org/bots/api#getstickerset
     *
     * @param string $name
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getStickerSet(string $name, ?array $opt = []): PromiseInterface
    {
        $required = compact("name");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getStickerSet", $params), StickerSet::class);
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet and addStickerToSet methods
     * (can be used multiple times). Returns the uploaded File on success.
     *
     * More on https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @param int $user_id
     * @param $png_sticker
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function uploadStickerFile(int $user_id, $png_sticker, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "png_sticker");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("uploadStickerFile", $params), File::class);
    }

    /**
     * Use this method to create a new sticker set owned by a user. The bot will be able to edit the sticker set thus
     * created. You must use exactly one of the fields png_sticker or tgs_sticker. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param int $user_id
     * @param string $name
     * @param string $title
     * @param string $emojis
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function createNewStickerSet(int $user_id, string $name, string $title, string $emojis, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "name", "title", "emojis");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("createNewStickerSet", $params));
    }

    /**
     * Use this method to add a new sticker to a set created by the bot. You must use exactly one of the fields png_sticker
     * or tgs_sticker. Animated stickers can be added to animated sticker sets and only to them. Animated sticker sets
     * can have up to 50 stickers. Static sticker sets can have up to 120 stickers. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#addstickertoset
     *
     * @param int $user_id
     * @param string $name
     * @param $png_sticker
     * @param string $emojis
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function addStickerToSet(int $user_id, string $name, $png_sticker, string $emojis, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "name", "png_sticker", "emojis");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("addStickerToSet", $params));
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @param string $sticker
     * @param int $position
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setStickerPositionInSet(string $sticker, int $position, ?array $opt = []): PromiseInterface
    {
        $required = compact("sticker", "position");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setStickerPositionInSet", $params));
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @param string $sticker
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteStickerFromSet(string $sticker, ?array $opt = []): PromiseInterface
    {
        $required = compact("sticker");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("deleteStickerFromSet", $params));
    }

    /**
     * Use this method to set the thumbnail of a sticker set. Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setstickersetthumb
     *
     * @param string $name
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setStickerSetThumb(string $name, int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("name", "user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setStickerSetThumb", $params));
    }

    /**
     * Use this method to send answers to an inline query. On success, True is returned.No more than 50 results per query
     * are allowed.
     *
     * More on https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param string $inline_query_id
     * @param $results
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function answerInlineQuery(string $inline_query_id, $results, ?array $opt = []): PromiseInterface
    {
        $required = compact("inline_query_id", "results");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("answerInlineQuery", $params));
    }

    /**
     * Use this method to send invoices. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendinvoice
     *
     * @param int $chat_id
     * @param string $title
     * @param string $description
     * @param string $payload
     * @param string $provider_token
     * @param string $start_parameter
     * @param string $currency
     * @param $prices
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendInvoice(int $chat_id, string $title, string $description, string $payload, string $provider_token, string $start_parameter, string $currency, $prices, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "title", "description", "payload", "provider_token", "start_parameter", "currency", "prices");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendInvoice", $params), Message::class);
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API will
     * send an Update with a shipping_query field to the bot. Use this method to reply to shipping queries. On success,
     * True is returned.
     *
     * More on https://core.telegram.org/bots/api#answershippingquery
     *
     * @param string $shipping_query_id
     * @param $ok
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function answerShippingQuery(string $shipping_query_id, $ok, ?array $opt = []): PromiseInterface
    {
        $required = compact("shipping_query_id", "ok");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("answerShippingQuery", $params));
    }

    /**
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation in the form
     * of an Update with the field pre_checkout_query. Use this method to respond to such pre-checkout queries. On
     * success, True is returned. Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query
     * was sent.
     *
     * More on https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @param string $pre_checkout_query_id
     * @param $ok
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function answerPreCheckoutQuery(string $pre_checkout_query_id, $ok, ?array $opt = []): PromiseInterface
    {
        $required = compact("pre_checkout_query_id", "ok");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("answerPreCheckoutQuery", $params));
    }

    /**
     * Informs a user that some of the Telegram Passport elements they provided contains errors. The user will not be able
     * to re-submit their Passport to you until the errors are fixed (the contents of the field for which you returned
     * the error must change). Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param int $user_id
     * @param $errors
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setPassportDataErrors(int $user_id, $errors, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "errors");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setPassportDataErrors", $params));
    }

    /**
     * Use this method to send a game. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendgame
     *
     * @param int $chat_id
     * @param string $game_short_name
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendGame(int $chat_id, string $game_short_name, ?array $opt = []): PromiseInterface
    {
        $required = compact("chat_id", "game_short_name");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("sendGame", $params), Message::class);
    }

    /**
     * Use this method to set the score of the specified user in a game. On success, if the message was sent by the bot,
     * returns the edited Message, otherwise returns True. Returns an error, if the new score is not greater than the
     * user's current score in the chat and force is False.
     *
     * More on https://core.telegram.org/bots/api#setgamescore
     *
     * @param int $user_id
     * @param int $score
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setGameScore(int $user_id, int $score, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id", "score");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("setGameScore", $params), Message::class);
    }

    /**
     * Use this method to get data for high score tables. Will return the score of the specified user and several of his
     * neighbors in a game. On success, returns an Array of GameHighScore objects.
     *
     * More on https://core.telegram.org/bots/api#getgamehighscores
     *
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getGameHighScores(int $user_id, ?array $opt = []): PromiseInterface
    {
        $required = compact("user_id");
        $params = array_merge($required, $opt);
        return new ZanzaraPromise($this->getZanzaraMapper(), $this->callApi("getGameHighScores", $params), GameHighScore::class);
    }

    /**
     * @param string $method
     * @param array $params
     * @return PromiseInterface
     */
    public function callApi(string $method, array $params)
    {
        $headers = [
            "Content-type" => "application/json"
        ];

        return $this->getBrowser()->post($method, $headers, json_encode($params));
    }
}