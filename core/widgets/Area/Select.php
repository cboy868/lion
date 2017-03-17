<?php

namespace app\core\widgets\Area;

use yii\web\View;
use yii\helpers\Html;
use app\core\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\base\Widget;
use app\core\models\Area;
/**
 * Webuploader Widget
 * <?php echo Select::widget(['options'=>['formData'=>['res_name'=>'article', 'db'=>true]]]);?>
 */
class Select extends Widget {

    public $pro;

    public $city;

    public $zone;

    public $pro_name;

    public $city_name;

    public $zone_name;

    static $flag = 0;
    /**
     * Renders the widget.
     */
    public function run() {

      $province_list = Area::find()->where(['level'=>1])->asArray()->all();
      $province_list = ArrayHelper::map($province_list, 'id', 'name');
      $self::$flag++;


      return $this->render('select', [
            'province_list' => $province_list,
            'flag' => self::$flag,
            'pro' => $this->pro,
            'city' => $this->city,
            'zone' => $this->zone,
            'pro_name' => $this->pro_name ? $this->pro_name : 'province_id',
            'city_name' => $this->city_name ? $this->city_name : 'city_id',
            'zone_name' => $this->zone_name ? $this->zone_name : 'zone_id',
          ]);
    }
}




  // protected $Area;

  //   protected $levels = array(1,2,3);

  //   protected $default = 2; // 天津

  //   public function __construct() 
  //   {
  //       $this->Area = D('Area');
  //   }
  
  //   public function render($params)
  //   {
  //       static $already = false;
  //       static $flag = 0;
  //       $params['params'] = json_encode($params);
  //       $level = & $params['level'];
  //       $level = in_array($level, $this->levels)?  $level : 3;
  //       $params['flag'] = isset($params['flag'])? $params['flag'] : $flag;
  //       $pro = $this->Area->getProvince();
  //       $pro = valueToKey($pro, 'id');
  //   $params['province'] = $pro;
  //       $params['already'] = $already;

  //       if (isset($params['default'])) {
  //           $params['default'] = $params['default'];
  //       } else {
  //           $params['default'] = $this->default;
  //       }
  //       if (!isset($params['pro'])) {
  //           // 缺省
  //           $params['pro'] = $params['default'];
  //       }

  //       $already = true;
  //       $flag++;
  //   return $this->fetch('Select/area',$params);
  // }



