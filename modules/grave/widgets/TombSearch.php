<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\grave\widgets;



use app\modules\grave\models\search\TombSearch as Search;
use app\modules\grave\models\Grave;
use app\core\helpers\ArrayHelper;



/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class TombSearch extends \yii\base\Widget
{


    public $form;
    // public $options = [];



    /**
     * Renders the widget.
     */
    public function run() {


        $grave = Grave::find()->where(['<>', 'status', Grave::STATUS_DEL])
                              ->andWhere(['is_leaf'=>1])
                              ->orderBy('id asc')
                              ->asArray()
                              ->all();

        $grave_ids = ArrayHelper::map($grave, 'id', 'name');


        $model = new Search;
        $model->search(\Yii::$app->request->queryParams);


        return $this->render('tomb', ['model'=>$model, 'grave'=>$grave_ids, 'form'=>$this->form]);
    }





}