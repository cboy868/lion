<?php
namespace app\core\web;

use yii;
use yii\base\Action;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;

class ThumbAction extends Action
{
    public function run()
    {
    	$thumb = Yii::$app->request->get('t');

        //补全地址
        $thumb = 'upload/' . $thumb; 

        $parse = explode('@', $thumb);
        $ori_name = $parse[1];
        $path = dirname($parse[0]);
        $size = explode('x', basename($parse[0]));

        Image::thumbnail($path . '/' . $ori_name, $size[0], $size[1], ManipulatorInterface::THUMBNAIL_INSET)->save($thumb);
        $uri = $_SERVER['REQUEST_URI'];

        return $this->controller->redirect([$uri]);
    }

}