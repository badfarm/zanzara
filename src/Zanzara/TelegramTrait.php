<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;

/**
 *
 */
trait TelegramTrait
{

    /**
     * @return Browser
     */
    public abstract function getBrowser(): Browser;

    /**
     * @return Update
     */
    public abstract function getUpdate(): Update;

    /**
     * @return ZanzaraMapper
     */
    public abstract function getZanzaraMapper(): ZanzaraMapper;

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
    public function forwardMessage(int $chat_id, int $from_chat_id, int $message_id, ?array $opt = [])
    {
        $required = compact("chat_id", "from_chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("forwardMessage", $params);
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
    public function sendPhoto(int $chat_id, $photo, ?array $opt = [])
    {
        $required = compact("chat_id", "photo");
        $params = array_merge($required, $opt);
        return $this->callApi("sendPhoto", $params);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .MP3 or .M4A format. On success, the sent Message is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendaudio
     *
     * @param int $chat_id
     * @param $audio
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendAudio(int $chat_id, $audio, ?array $opt = [])
    {
        $required = compact("chat_id", "audio");
        $params = array_merge($required, $opt);
        return $this->callApi("sendAudio", $params);
    }

    /**
     * Use this method to send general files. On success, the sent Message is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#senddocument
     *
     * @param int $chat_id
     * @param $document
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendDocument(int $chat_id, $document, ?array $opt = [])
    {
        $required = compact("chat_id", "document");
        $params = array_merge($required, $opt);
        return $this->callApi("sendDocument", $params);
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document).
     * On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendvideo
     *
     * @param int $chat_id
     * @param $video
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVideo(int $chat_id, $video, ?array $opt = [])
    {
        $required = compact("chat_id", "video");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVideo", $params);
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent Message is returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendanimation
     *
     * @param int $chat_id
     * @param $animation
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendAnimation(int $chat_id, $animation, ?array $opt = [])
    {
        $required = compact("chat_id", "animation");
        $params = array_merge($required, $opt);
        return $this->callApi("sendAnimation", $params);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .OGG file encoded with OPUS (other formats may be sent as Audio or Document).
     * On success, the sent Message is returned. Bots can currently send voice messages of up to 50 MB in size,
     * this limit may be changed in the future.
     *
     * More on https://core.telegram.org/bots/api#sendvoice
     *
     * @param int $chat_id
     * @param $voice
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVoice(int $chat_id, $voice, ?array $opt = [])
    {
        $required = compact("chat_id", "voice");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVoice", $params);
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages. On success, the sent Message is returned.
     *
     * More on https://core.telegram.org/bots/api#sendvideonote
     *
     * @param int $chat_id
     * @param $video_note
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendVideoNote(int $chat_id, $video_note, ?array $opt = [])
    {
        $required = compact("chat_id", "video_note");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVideoNote", $params);
    }

    /**
     * Use this method to send a group of photos or videos as an album.
     * On success, an array of the sent Messages is returned.
     *
     * More on https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param int $chat_id
     * @param $media
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendMediaGroup(int $chat_id, $media, ?array $opt = [])
    {
        $required = compact("chat_id", "media");
        $params = array_merge($required, $opt);
        return $this->callApi("sendMediaGroup", $params);
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
    public function sendLocation(int $chat_id, $latitude, $longitude, ?array $opt = [])
    {
        $required = compact("chat_id", "latitude", "longitude");
        $params = array_merge($required, $opt);
        return $this->callApi("sendLocation", $params);
    }

    /**
     * Use this method to edit live location messages. A location can be edited until its live_period expires or editing
     * is explicitly disabled by a call to stopMessageLiveLocation.
     * On success, if the edited message was sent by the bot, the edited Message is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#editmessagelivelocation
     * @param $latitude
     * @param $longitude
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function editMessageLiveLocation($latitude, $longitude, ?array $opt = [])
    {
        $required = compact("latitude", "longitude");
        $params = array_merge($required, $opt);
        return $this->callApi("editMessageLiveLocation", $params);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires.
     * On success, if the message was sent by the bot, the sent Message is returned, otherwise True is returned.
     *
     * More on https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function stopMessageLiveLocation(?array $opt = [])
    {
        $params = array_merge($opt);
        return $this->callApi("stopMessageLiveLocation", $params);
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
    public function sendVenue(int $chat_id, $latitude, $longitude, string $title, string $address, ?array $opt = [])
    {
        $required = compact("chat_id", "latitude", "longitude", "title", "address");
        $params = array_merge($required, $opt);
        return $this->callApi("sendVenue", $params);
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
    public function sendContact(int $chat_id, string $phone_number, string $first_name, ?array $opt = [])
    {
        $required = compact("chat_id", "phone_number", "first_name");
        $params = array_merge($required, $opt);
        return $this->callApi("sendContact", $params);
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
    public function sendPoll(int $chat_id, string $question, $options, ?array $opt = [])
    {
        $required = compact("chat_id", "question", "options");
        $params = array_merge($required, $opt);
        return $this->callApi("sendPoll", $params);
    }

    /**
     * Use this method to send a dice, which will have a random value from 1 to 6.
     * On success, the sent Message is returned. (Yes, we're aware of the “proper” singular of die. But it's awkward,
     * and we decided to help it change. One dice at a time!)
     *
     * More on https://core.telegram.org/bots/api#senddice
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendDice(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("sendDice", $params);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot,
     * Telegram clients clear its typing status). Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#sendchataction
     *
     * @param int $chat_id
     * @param string $action
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function sendChatAction(int $chat_id, string $action, ?array $opt = [])
    {
        $required = compact("chat_id", "action");
        $params = array_merge($required, $opt);
        return $this->callApi("sendChatAction", $params);
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
    public function getUserProfilePhotos(int $user_id, ?array $opt = [])
    {
        $required = compact("user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getUserProfilePhotos", $params);
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size. On success, a File object is returned.
     * The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>,
     * where <file_path> is taken from the response. It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling getFile again.
     *
     * More on https://core.telegram.org/bots/api#getfile
     *
     * @param string $file_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getFile(string $file_id, ?array $opt = [])
    {
        $required = compact("file_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getFile", $params);
    }

    /**
     * Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels,
     * the user will not be able to return to the group on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#kickchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function kickChatMember(int $chat_id, int $user_id, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("kickChatMember", $params);
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup or channel.
     * The user will not return to the group or channel automatically, but will be able to join via link, etc.
     * The bot must be an administrator for this to work. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function unbanChatMember(int $chat_id, int $user_id, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("unbanChatMember", $params);
    }

    /**
     * Use this method to restrict a user in a supergroup.
     * The bot must be an administrator in the supergroup for this to work and must have the appropriate admin rights.
     * Pass True for all permissions to lift restrictions from a user. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param $permissions
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function restrictChatMember(int $chat_id, int $user_id, $permissions, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id", "permissions");
        $params = array_merge($required, $opt);
        return $this->callApi("restrictChatMember", $params);
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Pass False for all boolean parameters to demote a user. Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#promotechatmember
     *
     * @param int $chat_id
     * @param int $user_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function promoteChatMember(int $chat_id, int $user_id, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("promoteChatMember", $params);
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param int $chat_id
     * @param int $user_id
     * @param string $custom_title
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatAdministratorCustomTitle(int $chat_id, int $user_id, string $custom_title, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id", "custom_title");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatAdministratorCustomTitle", $params);
    }

    /**
     * Use this method to set default chat permissions for all members. The bot must be an administrator in the group
     * or a supergroup for this to work and must have the can_restrict_members admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param int $chat_id
     * @param $permissions
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatPermissions(int $chat_id, $permissions, ?array $opt = [])
    {
        $required = compact("chat_id", "permissions");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatPermissions", $params);
    }

    /**
     * Use this method to generate a new invite link for a chat; any previously generated link is revoked.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns the new invite link as String on success.
     *
     * More on https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function exportChatInviteLink(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("exportChatInviteLink", $params);
    }

    /**
     * Use this method to set a new profile photo for the chat. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatphoto
     *
     * @param int $chat_id
     * @param $photo
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatPhoto(int $chat_id, $photo, ?array $opt = [])
    {
        $required = compact("chat_id", "photo");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatPhoto", $params);
    }

    /**
     * Use this method to delete a chat photo. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteChatPhoto(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteChatPhoto", $params);
    }

    /**
     * Use this method to change the title of a chat. Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchattitle
     *
     * @param int $chat_id
     * @param string $title
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatTitle(int $chat_id, string $title, ?array $opt = [])
    {
        $required = compact("chat_id", "title");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatTitle", $params);
    }

    /**
     * Use this method to change the description of a group, a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatdescription
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatDescription(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatDescription", $params);
    }

    /**
     * Use this method to pin a message in a group, a supergroup, or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right
     * in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param int $chat_id
     * @param int $message_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function pinChatMessage(int $chat_id, int $message_id, ?array $opt = [])
    {
        $required = compact("chat_id", "message_id");
        $params = array_merge($required, $opt);
        return $this->callApi("pinChatMessage", $params);
    }

    /**
     * Use this method to unpin a message in a group, a supergroup, or a channel.
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right
     * in the supergroup or ‘can_edit_messages’ admin right in the channel.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function unpinChatMessage(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("unpinChatMessage", $params);
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
    public function leaveChat(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("leaveChat", $params);
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one
     * conversations, current username of a user, group or channel, etc.).
     * Returns a Chat object on success.
     *
     * More on https://core.telegram.org/bots/api#getchat
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChat(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChat", $params);
    }

    /**
     * Use this method to get a list of administrators in a chat.
     * On success, returns an Array of ChatMember objects that contains information about
     * all chat administrators except other bots. If the chat is a group or a supergroup and no administrators
     * were appointed, only the creator will be returned.
     *
     * More on https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function getChatAdministrators(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatAdministrators", $params);
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
    public function getChatMembersCount(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatMembersCount", $params);
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
    public function getChatMember(int $chat_id, int $user_id, ?array $opt = [])
    {
        $required = compact("chat_id", "user_id");
        $params = array_merge($required, $opt);
        return $this->callApi("getChatMember", $params);
    }

    /**
     * Use this method to set a new group sticker set for a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param int $chat_id
     * @param string $sticker_set_name
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function setChatStickerSet(int $chat_id, string $sticker_set_name, ?array $opt = [])
    {
        $required = compact("chat_id", "sticker_set_name");
        $params = array_merge($required, $opt);
        return $this->callApi("setChatStickerSet", $params);
    }

    /**
     * Use this method to delete a group sticker set from a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method.
     * Returns True on success.
     *
     * More on https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param int $chat_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function deleteChatStickerSet(int $chat_id, ?array $opt = [])
    {
        $required = compact("chat_id");
        $params = array_merge($required, $opt);
        return $this->callApi("deleteChatStickerSet", $params);
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards.
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     * On success, True is returned.
     *
     * More on https://core.telegram.org/bots/api#answercallbackquery
     *
     * @param string $callback_query_id
     * @param array|null $opt
     * @return PromiseInterface
     */
    public function answerCallbackQuery(string $callback_query_id, ?array $opt = [])
    {
        $required = compact("callback_query_id");
        $params = array_merge($required, $opt);
        return $this->callApi("answerCallbackQuery", $params);
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
    public function setMyCommands($commands, ?array $opt = [])
    {
        $required = compact("commands");
        $params = array_merge($required, $opt);
        return $this->callApi("setMyCommands", $params);
    }


}
