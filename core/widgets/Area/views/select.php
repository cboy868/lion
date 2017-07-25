<?php 
use app\assets\AreaAsset;
use app\core\helpers\Html;
AreaAsset::register($this);

?>


<div style="display:inline-block" class="area-select sel-<?=$flag?>" data-pro="<?=$pro?>" data-city="<?=$city?>" data-zone="<?=$zone?>">
<label for="province-<?=$flag?>">省-</label>

<?php echo Html::dropDownList($pro_name, null, [0=>'请选择省份']+$province_list, ['id'=>'province['.$flag.']', 'class'=>'input-control area_province', 'rel'=>'province_id']) ?>

  <label for="city-<?=$flag?>">市-</label>
  <select id="city-<?=$flag?>" rel="city_id" name="<?=$city_name?>" class="area_city" style="width:10em">
    <option value="0">请选择</option>
  </select>

    <?php if ($zone_show):?>
<label for="zone-<?=$flag?>">
  区-
  </label>
  <select id="zone-<?=$flag?>" rel="zone_id" name="<?=$zone_name?>" style="width:10em;" class="area_zone">
    <option value="0">请选择</option>
  </select>
    <?php endif;?>
</div>

