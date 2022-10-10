<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;


class Doston extends Widget
{
    public $color_class = 'bg-danger';
    
    public function init(){
        parent::init();
    }

    public function run(){
        $var = 'ftyghu';

        echo $var;

    }
}
