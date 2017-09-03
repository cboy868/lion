<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\news\models\Category;
/**
 * Site controller
 */
class FocusController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Focus';


    public function actions() {
        $actions = parent::actions();


        // 禁用""index,delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }


}
