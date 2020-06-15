<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$config = new Config();
$config->setCache(new \React\Cache\ArrayCache());
$config->setUpdateMode(Config::POLLING_MODE);

$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

/**
 *  There are 3 separed cache environment:
 *
 *  - chatdata --> indexed by chatid
 *  - userdata --> indexed by userid
 *  - globaldata --> global data, shared by every user/chat
 *
 *  Example for chatdata but it's applicable for each of them:
 *
 *  $ctx->setChatData("key1", "value1")
 *  $ctx->setChatData("key2", "value2")
 *  With these methods I'm writing inside the cache data of the chatId of the context.
 *  You can get that that data with $ctx->getChatData(). This method will return in a promise
 *  the assoc array of the data previusly saved. In this case ["key1" => "value1", "key2" => "value2"].
 *  The key must be a string but the value can be a generic object (another assoc array for example).
 *  If you want to access only one item of the chat you must use $ctx->getItemChatData("key2"). This method in a promise
 *  will return only the value associated with key2.
 *  You can delete all the items in chatData of a context with $ctx->deleteChatData().
 *  If you want to delete only one item you can use $ctx->deleteItemChatData("key1").
 *
 *  For userdata it's the same, but it's indexed on the userId of the context.
 *
 *  The only differenct with global data is that it can be accessed with the $ctx(only for simplicity but it's
 *  not referred to the context) and with the $bot instance.
 *
 *
 */

$bot->onCommand("chatdata", function (Context $ctx) {

    $ctx->setChatData("eta", 22);
    $ctx->setChatData("name", "mattia");
    $ctx->setChatData("address", "piscine di Brebbia, n 6");

    //return the assoc array of all the chat data of the chatId context
    $ctx->getChatData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        $ctx->sendMessage(implode(",", $arrayData));
    });

    //return the value of the key name
    $ctx->getChatDataItem("name")->then(function ($data) use ($ctx) {
        //send data back to the user
        $ctx->sendMessage($data);
    });

    $ctx->deleteChatDataItem("name")->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("deleted item");
        }
    });

    $ctx->getChatData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        $ctx->sendMessage(implode(",", $arrayData));
    });

    $ctx->deleteChatData()->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("all chat data deleted");
        }
    });

    //return the assoc array of all the chat data of the chatId context
    $ctx->getChatData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items

        if ($arrayData) {
            $ctx->sendMessage(implode(",", $arrayData));
        } else {
            $ctx->sendMessage("empty");
        }
    });
});

$bot->onCommand("userdata", function (Context $ctx) {

    $ctx->setUserData("eta", 22);
    $ctx->setUserData("name", "mattia");
    $ctx->setUserData("address", "piscine di Brebbia, n 6");

    //return the assoc array of all the chat data of the chatId context
    $ctx->getUserData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        $ctx->sendMessage(implode(",", $arrayData));
    });

    //return the value of the key name
    $ctx->getUserDataItem("name")->then(function ($data) use ($ctx) {
        //send data back to the user
        $ctx->sendMessage($data);
    });

    $ctx->deleteUserDataItem("name")->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("deleted item");
        }
    });

    $ctx->getChatData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        if ($arrayData) {
            $ctx->sendMessage(implode(",", $arrayData));
        } else {
            $ctx->sendMessage("empty");
        }
    });

    $ctx->deleteUserData()->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("all chat data deleted");
        }
    });

    //return the assoc array of all the chat data of the chatId context
    $ctx->getUserData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items

        if ($arrayData) {
            $ctx->sendMessage(implode(",", $arrayData));
        } else {
            $ctx->sendMessage("empty");
        }
    });
});

$bot->onCommand("globaldata", function (Context $ctx) {

    $ctx->setGlobalData("eta", 22);
    $ctx->setGlobalData("name", "mattia");
    $ctx->setGlobalData("address", "piscine di Brebbia, n 6");

    //return the assoc array of all the chat data of the chatId context
    $ctx->getGlobalData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        $ctx->sendMessage(implode(",", $arrayData));
    });

    //return the value of the key name
    $ctx->getGlobalDataItem("name")->then(function ($data) use ($ctx) {
        //send data back to the user
        $ctx->sendMessage($data);
    });

    $ctx->deleteGlobalDataItem("name")->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("deleted item");
        }
    });

    $ctx->getGlobalData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items
        if ($arrayData) {
            $ctx->sendMessage(implode(",", $arrayData));
        } else {
            $ctx->sendMessage("empty");
        }
    });

    $ctx->deleteGlobalData()->then(function ($result) use ($ctx) {
        if ($result) {
            $ctx->sendMessage("all chat data deleted");
        }
    });

    //return the assoc array of all the chat data of the chatId context
    $ctx->getGlobalData()->then(function ($arrayData) use ($ctx) {
        //I can send it back to the user creating a list of the items

        if ($arrayData) {
            $ctx->sendMessage(implode(",", $arrayData));
        } else {
            $ctx->sendMessage("empty");
        }
    });
});

$bot->onCommand('appendUser', function (Context $ctx) {
    $random = rand(1000, 9999);
    $ctx->appendUserData('myData', $random)->then(function ($res) use ($ctx) {
        $ctx->getUserDataItem('myData')->then(function ($data) use ($ctx) {
            $ctx->sendMessage(json_encode($data));
        });
    });
});

$bot->onCommand('appendChat', function (Context $ctx) {
    $random = rand(1000, 9999);
    $ctx->appendChatData('myData', $random)->then(function ($res) use ($ctx) {
        $ctx->getChatDataItem('myData')->then(function ($data) use ($ctx) {
            $ctx->sendMessage(json_encode($data));
        });
    });
});

$bot->onCommand('appendGlobal', function (Context $ctx) {
    $random = rand(1000, 9999);
    $ctx->appendGlobalData('myData', $random)->then(function ($res) use ($ctx) {
        $ctx->getGlobalDataItem('myData')->then(function ($data) use ($ctx) {
            $ctx->sendMessage(json_encode($data));
        });
    });
});

$bot->run();




