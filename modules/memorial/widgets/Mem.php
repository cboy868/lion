<?php
namespace app\modules\memorial\widgets;

use app\modules\memorial\models\Memorial;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use yii\helpers\ArrayHelper;
/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class Mem extends \yii\base\Widget
{

    public $mid;

    public $method;

    public $limit = 10;
    /**
     * Renders the widget.
     */
    public function run() {
        $method = $this->method;
        return $this->$method();
    }

    private function info()
    {
        $memorial = Memorial::findOne($this->mid);
        return $this->render('mem/info', ['model'=>$memorial]);
    }

    private function album()
    {
        $albums = Album::find()->where(['memorial_id'=>$this->mid,'privacy'=>Album::PRIVACY_PUBLIC])
            ->orderBy('id desc')->limit(10)->all();
        $albums_ids = ArrayHelper::getColumn($albums, 'id');
        $photos = AlbumPhoto::find()->where(['album_id'=>$albums_ids, 'status'=>AlbumPhoto::STATUS_ACTIVE])
            ->limit(10)->all();


        return $this->render('mem/album', [
            'models'=>$photos,
            'memorial_id' => $this->mid
        ]);
    }


}