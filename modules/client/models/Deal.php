<?php

namespace app\modules\client\models;

use Yii;

/**
 * This is the model class for table "{{%client_deal}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $guide_id
 * @property integer $agent_id
 * @property integer $recep_id
 * @property string $res_name
 * @property integer $res_id
 * @property string $date
 * @property integer $status
 */
class Deal extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_deal}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id'], 'required'],
            [['id', 'client_id', 'guide_id', 'agent_id', 'recep_id', 'res_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['res_name', 'name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'guide_id' => 'Guide ID',
            'agent_id' => 'Agent ID',
            'recep_id' => 'Recep ID',
            'res_name' => 'Res Name',
            'res_id' => 'Res ID',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }


    public static function create($client_id, $guide_id, $agent_id, $res_name, $res_id, $name, $recep_id=0)
    {
        $client = new self();
        $data = [
            'client_id' => $client_id,
            'guide_id' => $guide_id,
            'agent_id' => $agent_id,
            'res_name' => $res_name,
            'res_id'   => $res_id,
            'date'     => date('Y-m-d H:i:s'),
            'recep_id' => $recep_id,
            'name'     => $name
        ];

        $client->load($data, '');
        return $client->save();
    }
}
