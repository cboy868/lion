<?php

namespace app\modules\api\models\common;

use app\modules\cms\models\PostImage;

/**
 * This is the model class for table "{{%post}}".
 * @property PostData[] $postDatas
 */
class Post extends \app\modules\cms\models\Post
{
    public function getCover($size='')
    {
        return PostImage::getById($this->thumb, $size);
    }

}
