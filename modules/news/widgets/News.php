<?php
namespace app\modules\news\widgets;

use app\modules\sys\models\Menu;
use app\modules\user\models\MenuRel;
use yii;
use app\core\helpers\ArrayHelper;
use app\modules\mod\models\Code;
use app\core\db\ActiveRecord;
use app\modules\client\models\Client;
use app\core\helpers\Url;

use app\modules\news\models\News as NewsModel;

/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class News extends \yii\base\Widget
{
    public $name='news';

    public $limit = 20;

    public $type='new';//mine我发布的,today今天,new最新
    /**
     * Renders the widget.
     */
    public function run() {
        $method = $this->name;
        return $this->$method();
    }



    private function news()
    {
        $query = NewsModel::find();
        if ($this->type == 'new') {
            $query->orderBy('id desc');
        }

        $models = $query->limit($this->limit)->all();

        return $this->render($this->type, ['models'=>$models]);
    }







}