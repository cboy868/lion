<?php
namespace app\modules\memorial\widgets;

use app\modules\blog\models\Blog;
use app\modules\memorial\models\Memorial;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use app\modules\memorial\models\Remote;
use app\modules\user\models\Track;
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

    public $res_name;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $method = $this->method;
        return $this->$method();
    }

    private function info()
    {
        $memorial = Memorial::findOne($this->mid);
        return $this->render('mem/info', ['model' => $memorial]);
    }

    private function album()
    {
        $albums = Album::find()->where(['memorial_id' => $this->mid, 'privacy' => Album::PRIVACY_PUBLIC])
            ->orderBy('id desc')->limit(10)->all();
        $albums_ids = ArrayHelper::getColumn($albums, 'id');
        $photos = AlbumPhoto::find()->where(['album_id' => $albums_ids, 'status' => AlbumPhoto::STATUS_ACTIVE])
            ->limit(10)->all();


        return $this->render('mem/album', [
            'models' => $photos,
            'memorial_id' => $this->mid
        ]);
    }

    /**
     * @name 脚印
     */
    private function track()
    {
        $res_name = $this->res_name ? $this->res_name : Track::RES_MEMORIAL;
        $tracks = Track::find()->where(['res_name' => $res_name, 'res_id' => $this->mid])
            ->orderBy('id desc')
            ->limit(18)
            ->all();

        return $this->render('mem/track', [
            'tracks' => $tracks,
            'memorial_id' => $this->mid
        ]);
    }

    private function miss()
    {
        $list = Blog::find()->where(['res' => Blog::RES_MISS, 'memorial_id' => $this->mid])
            ->orderBy('id desc')
            ->limit(8)
            ->all();

        return $this->render('mem/miss', [
            'list' => $list,
            'memorial_id' => $this->mid
        ]);
    }

    private function archive()
    {
        $list = Blog::find()->where(['res' => Blog::RES_ARCHIVE, 'memorial_id' => $this->mid])
            ->orderBy('id desc')
            ->limit(8)
            ->all();

        return $this->render('mem/archive', [
            'list' => $list,
            'memorial_id' => $this->mid
        ]);
    }

    private function remote()
    {
        $list = Remote::find()->where(['memorial_id' => $this->mid])
                ->orderBy('id desc')
                ->limit(10)
                ->all();

        return $this->render('mem/remote', [
            'list' => $list,
            'memorial_id' => $this->mid
        ]);

    }


}