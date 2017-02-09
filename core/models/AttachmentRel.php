<?php

namespace app\core\models;

use Yii;
use app\core\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%attachment_rel}}".
 *
 * @property integer $res_id
 * @property string $res_name
 * @property integer $attach_id
 *
 * @property Attachment $attach
 */
class AttachmentRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'attach_id'], 'integer'],
            [['res_name', 'use'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'res_id' => 'Res ID',
            'res_name' => 'Res Name',
            'attach_id' => 'Attach ID',
            'use' => '用途',
        ];
    }

    public static function updateResId($res_name, $attach_id, $res_id, $res_title='')
    {
        $connection = Yii::$app->db;

        if ($res_title) {
            $connection->createCommand()
                        ->update(
                            Attachment::tableName(),
                            ['title'=>$res_title],
                            ['id'=>$attach_id]
                        )->execute();
        }

        return $connection->createCommand()
                          ->update(
                            self::tableName(), 
                            ['res_id' => $res_id], 
                            ['res_name'=>$res_name,'attach_id'=>$attach_id])
                          ->execute();
    }


    // public static function updateResIdByUse($res_name, $use, $res_id)
    // {

    //     Yii::$app->db->createCommand()
    //                       ->update(
    //                         self::tableName(), 
    //                         ['res_id' => $res_id], 
    //                         ['res_name'=>$res_name,'use'=>$use])
    //                       ->execute();
    // }


    public static function deleteRes($res_name, $res_id, $use, $out_attach_ids)
    {


        $attach_ids = self::find()->where(['res_name'=>$res_name, 'res_id'=>$res_id, 'use'=>$use])
                                  ->andFilterWhere(['not in', 'attach_id', $out_attach_ids])
                                  ->select(['attach_id'])
                                  ->asArray()
                                  ->all();

        $attach_ids = ArrayHelper::getColumn($attach_ids, 'attach_id');

        if (count($attach_ids) < 1) {
            return ;
        }
        // self::deleteAll(
        //             [
        //                 'and', 'res_name = :res_name', 'res_id=:res_id', '`use`=:use', 'attach_id=:attach_id'
        //             ],
        //             [ ':res_id' => $res_id, ':res_name'=>$res_name, ':use'=>$use, ':attach_id'=>$attach_ids]
        //         );


        Yii::$app->db->createCommand()
                     ->delete(AttachmentRel::tableName(),[
                            'res_name' => $res_name,
                            'res_id' => $res_id,
                            'use'    => $use,
                            'attach_id' => $attach_ids
                        ])
                     ->execute();

        Yii::$app->db->createCommand()
                          ->update(
                            Attachment::tableName(), 
                            ['status' => -1], 
                            ['id'=>$attach_ids])
                          ->execute();
        // p($attach_ids);die;
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttach()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'attach_id']);
    }


    public static function getByRes($res_name, $res_id, $type='', $use='', $out = [])
    {
        $rel = self::find()->where(['res_name'=>$res_name, 'res_id'=>$res_id])
                            ->andFilterWhere(['use'=>$use])
                            ->asArray()
                            ->all();

        $query = Attachment::find()->where([
            'id'=>\yii\helpers\ArrayHelper::getColumn($rel, 'attach_id'),
            'status' => Attachment::STATUS_ACTIVE
            ]);

        if (!empty($out[0])) {
            $query->andFilterWhere(['not in', 'id', $out]);
        }

        $list = $query->orderBy('id DESC')->asArray()->all();

        $type = $type ? $type.'@' : '';




        foreach ($list as $k => &$v) {

            $v['url'] = Attachment::getById($v['id'], $type);
            // $v['url'] = $v['path'] . '/'. $type . $v['name'];
        }
        
        return $list;
    }

    public static function getModels($res_name, $res_id, $type='', $use='')
    {
        $rel = self::find()->where(['res_name'=>$res_name, 'res_id'=>$res_id])
                            ->andFilterWhere(['use'=>$use])
                            ->asArray()
                            ->all();


        $query = Attachment::find()->where([
            'id'=>\yii\helpers\ArrayHelper::getColumn($rel, 'attach_id'),
            'status' => Attachment::STATUS_ACTIVE
            ]);

        $list = $query->all();


        $type = $type ? $type.'@' : '';


        foreach ($list as $k => &$v) {
            $v['url'] = $v['path'] . '/'. $type . $v['name'];
        }

        return $list;
    }



}
