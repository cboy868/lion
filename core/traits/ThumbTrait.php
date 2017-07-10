<?php

namespace app\core\traits;

use Yii;
use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;


trait ThumbTrait {
   public function getThumb($size='', $default='/static/images/default.png')
    {
        return Attachment::getById($this->thumb, $size, $default);
    }
}