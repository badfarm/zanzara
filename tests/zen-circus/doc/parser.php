<?php

use Zanzara\Telegram\TelegramTrait;
use Zanzara\Telegram\Type\Chat;
use Zanzara\Telegram\Type\ChatMember;
use Zanzara\Telegram\Type\File\File;
use Zanzara\Telegram\Type\File\StickerSet;
use Zanzara\Telegram\Type\File\UserProfilePhotos;
use Zanzara\Telegram\Type\Game\GameHighScore;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;

require "../../../vendor/autoload.php";

$class = new ReflectionClass(TelegramTrait::class);
$methods = $class->getMethods();
//var_dump($methods);
$res = "";

$wiredReturnTypes = [
    'createNewStickerSet' => 'True',
    'addStickerToSet' => 'True',
    'setStickerSetThumb' => 'True',
    'exportChatInviteLink' => 'String',
];

$packagedClass = [
    'Update' => Update::class,
    'Message' => Message::class,
    'WebhookInfo' => WebhookInfo::class,
    'UserProfilePhotos' => UserProfilePhotos::class,
    'File' => File::class,
    'Chat' => Chat::class,
    'ChatMember' => ChatMember::class,
    'Poll' => Poll::class,
    'StickerSet' => StickerSet::class,
    'GameHighScore' => GameHighScore::class,
];

$excludedMethods = [
    'getUpdates',
    'doSendMessage',
    'callApi',
    'prepareMultipartData',
];

foreach ($methods as $method) {
    if (in_array($method->getName(), $excludedMethods)) {
        continue;
    }
    $res .= "| {$method->getName()} | ";
    $params = $method->getParameters();
    $paramsRes = "";
    foreach ($params as $param) {
        $paramsRes .= "```$" . "{$param->getName()}```";
        if ($param->getType()) {
            $paramsRes .= ": {$param->getType()}";
        }
        $paramsRes .= "<br>";
    }
    if ($paramsRes) {
        $paramsRes = substr($paramsRes, 0, strlen($paramsRes) - 4); // remove last <br>
    }
    $res .= $paramsRes;

    $doc = $method->getDocComment();
    $regex = "/@see\s([a-zA-Z]+)/";
    $matches = [];
    preg_match($regex, $doc, $matches);
    $returnType = $matches[1] ?? "void";
    if ($returnType === "void") {
        $matches = [];
        $regex = "/(Returns True|True is returned)/";
        preg_match($regex, $doc, $matches);
        $returnType = isset($matches[1]) ? "True" : "void";
    }
    $returnType = $wiredReturnTypes[$method->getName()] ?? $returnType;
    if (isset($packagedClass[$returnType])) {
        $invertedSlashes = fromBackwardToForwardSlashes($packagedClass[$returnType]);
        $returnType = "[$returnType](https://github.com/badfarm/zanzara/blob/develop/src/$invertedSlashes.php)";
    }
    $matches = [];
    $regex = "/More on (https:.+)/";
    preg_match($regex, $doc, $matches);
    $moreOn = $matches[1] ?? null;
    $res .= " | $returnType | $moreOn";

    $res .= "\n";
}

file_put_contents(__DIR__ . '/res.md', $res);
echo $res;

function fromBackwardToForwardSlashes($string)
{
    return str_replace("\\", "/", $string);
}