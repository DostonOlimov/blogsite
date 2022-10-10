<?php

namespace app\models;

use aki\telegram\Telegram;
use Exception;
use Yii;

class Telegram_aki 
{
    public $chat_id;
    // cunstructor must be take chat_id 
    public function __construct($chat_id)
    {
        $this->chat_id = $chat_id;

    }
    
    public function sendMessage($text){
       $path = Yii::getAlias('@frontend/web/images/57.jpg');
      
        Yii::$app->telegram->sendPhoto([
            'chat_id' => $this->chat_id,
            'photo' => $path,
            'caption' => 'this is test'
        ]); 

    }
   

}