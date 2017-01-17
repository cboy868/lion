<?php

namespace app\core\widgets\comment;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;
use app\core\widgets\comment\CommentForm;
use app\core\models\Comment as Com;
use app\core\widgets\comment\CommentSearch;
/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['formData'=>['res_name'=>'article', 'db'=>true]]]);?>
 */
class Comment extends Widget {
   

   public $res_name;

   public $res_id;

   public $privacy;

   public $pid;

   public $to;

    /**
     * Renders the widget.
     */
    public function run() {

        $model = new CommentForm;

        return $this->render('comment', [
            'res_name'=>$this->res_name, 
            'res_id'  =>$this->res_id,
            'pid'     =>$this->pid,
            // 'privacy' =>$this->privacy,
            'to'      =>$this->to,
            'dataProvider' => $this->getComments(),
            // 'privacys'=> [Com::PRIVACY_PRIVATE=>'评论', Com::PRIVACY_PUBLIC=>'悄悄话'],
            'model'=>$model]);
    }


    private function getComments()
    {
        $searchModel = new CommentSearch();

        $params['CommentSearch'] = [
          'res_name' => $this->res_name,
          'res_id'   => $this->res_id,
          'status'   => Com::STATUS_PUBLISH,
          'privacy'  => Com::PRIVACY_PUBLIC
        ];

        $dataProvider = $searchModel->search($params);

        return $dataProvider;

    }

}
