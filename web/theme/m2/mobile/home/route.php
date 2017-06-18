<?php
$this->title="地图导航";

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oQtfKRzTPrz7sCqZCFIPZW360SUghMRu"></script>
</head>
<body>
<?php
$point = explode(',', g("point"));
if (!isset($point[0])) {
    echo '请先设置地图坐标';die;
}
?>

<script type="text/javascript">
    var api_url = 'http://api.map.baidu.com/direction';
    var geolocation = new BMap.Geolocation();
    var ya_lat = <?=$point[1]?>;
    var ya_lng = <?=$point[0]?>;

    geolocation.getCurrentPosition(function(r){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){

            var datas = {
                'origin' : 'latlng:' + r.point.lat + ',' + r.point.lng + '|name:我的位置',
                'destination' : 'latlng:' + ya_lat + ',' + ya_lng + '|name:<?=g("cp_name")?>',
                'region' : '<?=g("address")?>',
                'mode' : 'driving',
                'output' : 'html'
            };
            var params = [];
            for( key in datas ) {
                params.push(key+'='+datas[key]);
            }
            var query = params.join('&');
            var url = api_url + '?' + query;
            window.location = encodeURI(url);
        } else {
            alert('failed'+this.getStatus());
        }
    },{ enableHighAccuracy: true })
    //关于状态码
    //BMAP_STATUS_SUCCESS	检索成功。对应数值“0”。
    //BMAP_STATUS_CITY_LIST	城市列表。对应数值“1”。
    //BMAP_STATUS_UNKNOWN_LOCATION	位置结果未知。对应数值“2”。
    //BMAP_STATUS_UNKNOWN_ROUTE	导航结果未知。对应数值“3”。
    //BMAP_STATUS_INVALID_KEY	非法密钥。对应数值“4”。
    //BMAP_STATUS_INVALID_REQUEST	非法请求。对应数值“5”。
    //BMAP_STATUS_PERMISSION_DENIED	没有权限。对应数值“6”。(自 1.1 新增)
    //BMAP_STATUS_SERVICE_UNAVAILABLE	服务不可用。对应数值“7”。(自 1.1 新增)
    //BMAP_STATUS_TIMEOUT	超时。对应数值“8”。(自 1.1 新增)
</script>
</body>
</html>

