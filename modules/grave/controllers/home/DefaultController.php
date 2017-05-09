<?php

namespace app\modules\grave\controllers\home;

use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\modules\grave\models\Grave;
use app\modules\grave\models\Tomb;

class DefaultController extends \app\modules\home\controllers\DefaultController
{
    public function actionIndex()
    {
        $list = Grave::find()->where(['status'=>Grave::STATUS_SALE])
                            ->andWhere(['is_show'=>Grave::SHOW_YES])
                            ->andWhere(['is_leaf'=>0])
                            ->all();

        $result = [];
        foreach ($list as $k => $v) {
            $result[$v['id']] = $v->toArray();
            $result[$v['id']]['cover'] = Attachment::getById($v->thumb, '152x152');
            $result[$v['id']]['status_label'] = Grave::getSta($v->status);
        }


        return $this->render('index', ['list'=>$result]);
    }

    public function actionView($id)
    {
        $model = Grave::findOne($id);

        if (!$model) {
            return $this->error('不存在此墓区');
        }

        $data = $model->toArray();

        $imgs = AttachmentRel::getByRes('grave', $model->id, '800x330');
        return $this->render('view', [
            'data' => $data,
            'thumbs' => $imgs
        ]);
    }



    public function actionTombs($id)
    {
        $model = Grave::findOne($id);
        if (!$model) {
            return $this->error('不存在此墓区');
        }

        if (!$model->is_leaf) {//如果不是直接墓区，则找到子集的直接墓区
            $graves = $model->getSonLeafs();
            $id = ArrayHelper::getColumn($graves, 'id');
        }

        $tombs = Tomb::find()->where(['status'=>Tomb::STATUS_EMPTY])
                             ->andWhere(['grave_id'=>$id])
                             //->asArray()
                             ->all();

        $result = [];
        foreach ($tombs as $k=>$v) {
            $result[$v['id']] = $v->toArray();
            $result[$v['id']]['cover'] = Attachment::getById($v->thumb, '152x152');
        }

    	return $this->render('tombs',['list'=>$result, 'grave'=>$model->toArray()]);
    }

    public function actionTomb($id)
    {
        $model = Tomb::findOne($id);
        $data = $model->toArray();

    	return $this->render('tomb', ['data'=>$data]);
    }
}
