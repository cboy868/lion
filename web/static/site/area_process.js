/**
 * 区域选择处理
 */

var addAreaOptions = function(obj, items) 
{
    obj.find('option[value!="0"]').remove();
    if (items) {
        for(id in items) {
            var elem = '<option value="'+ id +'">'+ items[id] +'</option>';
            obj.append(elem);
        }
    }
}


var setArea = function(obj, pro, city,zone) 
{
    var box = $(obj);
    if (pro) {
        box.find('select[rel=province_id]').val(pro);
        var cities = city_list[pro];
        var _city = box.find('select[rel=city_id]');
        var _zone = box.find('select[rel=zone_id]');
        addAreaOptions(_city, cities);
        addAreaOptions(_zone);
        if (city) {
            _city.val(city);
            var zones = zone_list[city];
            addAreaOptions(_zone, zones);
            if (zone) {
                _zone.val(zone);
            }
        }
    }
}

var area_init = function(areaSelect)
{
    areaSelect.each(function(index, item){
        $this = $(item);

        $this.setValues = function(){
            alert('ok');
        }

        $this.find('select').each(function(i, obj){
            var obj = $(obj);
            if (obj.attr('rel') == 'province_id') {
                obj.val($this.data('pro'));

                // 改变
                obj.change(function(e){
                    var val = $(this).val(); 
                    var cities = city_list[val];
                    var _city = $(this).parent().find('select[rel=city_id]');
                    var _zone = $(this).parent().find('select[rel=zone_id]');
                    addAreaOptions(_city, cities);
                    addAreaOptions(_zone);
                });
            }

            if (obj.attr('rel') == 'city_id') {
                if ($this.data('pro')) {
                    var cities = city_list[$this.data('pro')];
                    addAreaOptions(obj, cities);
                }
                if ($this.data('city')) {
                    obj.val($this.data('city'));
                }
                // 改变
                obj.change(function(e){
                    var val = $(this).val(); 
                    var zones = zone_list[val];
                    var _zone = $(this).parent().find('select[rel=zone_id]');
                    addAreaOptions(_zone, zones);
                });
            }

            if (obj.attr('rel') == 'zone_id') {
                if ($this.data('city')) {
                    var zones = zone_list[$this.data('city')];
                    addAreaOptions(obj, zones);
                }
                if ($this.data('zone')) {
                    obj.val($this.data('zone'));
                }
            }
        });
    });

}

$(function(){
    var areaSelect = $('div.area-select');
    area_init(areaSelect);
});

