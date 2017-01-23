<?php

namespace app\modules\grave\models;

use Yii;
use yii\base\Model;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\Grave;
use app\core\base\Upload;
/**
 * ContactForm is the model behind the contact form.
 */
class TombForm extends Model
{
    public $row_start = 1;
    public $row_end;
    public $col_start = 1;
    public $col_end;

    public $grave_id;
    public $hole = 2;
    public $price;
    public $area_total;
    public $area_use;
    public $note;
    public $thumb;
    public $cost;


    public function rules()
    {
        return [
            [['grave_id', 'hole'], 'integer'],
            [['price', 'cost', 'area_total', 'area_use'], 'number'],
            [['thumb'], 'safe'],
            [['note'], 'string'],
            [['row_start', 'row_end', 'col_start', 'col_end', 'price', 'grave_id'], 'required'],
        ];
    }


    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'row_start' => '起始排',
            'row_end' => '截止排',
            'col_start' => '起始列',
            'col_end' => '截止列',

            'grave_id' => '墓区',
            'special' => 'Special',
            'hole' => '墓穴个数',
            'price' => '墓价',
            'cost' => '石材成本',
            'area_total' => '建筑面积',
            'area_use' => '使用面积',
            'note' => '备注',
            'thumb' => '封面',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function create()
    {

        if ($this->row_end < $this->row_start) {
            $this->addError('row_start', '截止小于起始，请假检查.');
            return false;
        }

        if ($this->col_end < $this->col_start) {
            $this->addError('col_start', '截止小于起始，请假检查.');
            return false;
        }

        if (!$this->row_end || !$this->row_start) {
            $this->addError('row_start', '起始截止不可为0.');
            return false;
        }

        if (!$this->col_start || !$this->col_end) {
            $this->addError('col_start', '起始截止不可为0.');
            return false;
        }

        $grave = Grave::findOne($this->grave_id);

        if (!$grave) {
            //不存在此墓区
            $this->addError('grave_id', '不存在此墓区.');
            return false;
        }

        //查找已经存在的墓位 
        $tombs = Tomb::find()->where(['<>', 'status', Tomb::STATUS_DELETE])
                             ->andWhere(['grave_id'=>$this->grave_id])
                             ->select(['id','row', 'col'])
                             ->asArray()
                             ->all();
        $ts = [];
        foreach ($tombs as $k => $tomb) {
            $ts[$tomb['row'] . '_' . $tomb['col']] = $tomb;
        }

        

        $data = [
            'grave_id' => $this->grave_id,
            'hole'      => $this->hole,
            'price'     => $this->price,
            'cost'      => $this->cost,
            'area_total'=> $this->area_total,
            'area_use'  => $this->area_use,
            'note'      => $this->note,
        ];

        $up = Upload::getInstance($this, 'thumb', 'tomb');

        if ($up) {
            $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
            $up->save();
            $info = $up->getInfo();
            $data['thumb'] = $info['mid'];
        }

        for ($i=$this->row_start; $i <= $this->row_end; $i++) { 
            for ($j=$this->col_start; $j <= $this->col_end; $j++) { 
                if (isset($ts[$i . '_' . $j])) {
                    continue;
                }
                $tomb = new  Tomb;
                $tomb->load($data, '');
                
                $tomb->row = $i;
                $tomb->col = $j;
                $tomb->tomb_no = self::tombNo($tomb, $grave);
                $tomb->save();
            }
        }

        return true;
       
    }

    private static function tombNo($tomb, $grave)
    {
        $tomb_no = "%s%s排%s号";

        $row = $tomb->row < 0 ? "特" . abs($tomb->row) : $tomb->row;
        $col = $tomb->col < 0 ? "特" . abs($tomb->col) : $tomb->col;

        return sprintf($tomb_no, $grave->name, $row, $col);


    }
   
}
