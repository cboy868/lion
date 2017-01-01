var cookie={  
	//读取COOKIES,n为COOKIE名
	get:function(name){  
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
		if(arr=document.cookie.match(reg)){
			return unescape(arr[2]);
		}else{
			return null;
		}
	},

	//写入COOKIES,n为Cookie名，v为value
	set:function(name, value){ 
		var Days = 1;
		var exp = new Date();
		exp.setTime(exp.getTime() + Days*24*60*60*1000);
		document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	},

	del:function(name){  
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval=cookie.get(name);
		if(cval!=null)
			document.cookie= name + "="+cval+";expires="+exp.toGMTString();
		}
};
// cookie.del('carList');
var Cart = {
	addItem:function(skuId, goodsId, quantity, unitPrice, title){

		if (quantity == 0) {
			Cart.delItem(skuId);
		};

		if (skuId != '' && quantity != '') {
			var goodsList = cookie.get("carList"); //车内商品ID列表
			if (goodsList !=null && goodsList !="" && goodsList != "null") {

				if (!Cart.hasOne(skuId)) {
					goodsList += "&"+skuId+"="+goodsId+"|"+quantity+"|"+unitPrice;//+"|"+title+"|"+url+"|"+cover+"|"+intro;
					cookie.set("carList",goodsList);//更新购物车清单
					totalGoods = cookie.get("totalGoods"); //当前车内含有商品的总数
					totalGoods++; //总数+1
					cookie.set("totalGoods",totalGoods);
				} else {
					Cart.updateQuantity(skuId, quantity);
				}

				// alert(cookie.get('carList'));
			} else {
				goodsList="&" + skuId+"="+goodsId+"|"+quantity+"|"+unitPrice;//+"|"+title+"|"+url+"|"+cover+"|"+intro;
                cookie.set("carList",goodsList);//更新购物车清单
                cookie.set("totalGoods",1);
			};
		}

	},

	getList:function(){
		return cookie.get('carList');
	},

	getItems:function(){
		var goodsList = cookie.get('carList');
		var arr=goodsList.split("&");
		var result = [];
		for(i=1;i<arr.length;i++){

			var skuId = arr[i].substr(0,arr[i].indexOf("="));
			var data = arr[i].split('|');

			var obj = {
				'id' : data[0],
				'num' : data[1],
				'price' : data[2],
				// 'title' : data[3],
				// 'url' : data[4],
				// 'cover' : data[5],
				// 'intro' : data[6],
			}

			result.push(obj);
		}
	},


	 //修改某物品数量
	updateQuantity:function(skuId,quantity){
		goodsList = cookie.get("carList"); //车内商品ID列表


		var arr=goodsList.split("&");
		var sub=Cart.getSubPlace(skuId);//获取该物品在COOKIE数组中的下标位置

		var arr2=arr[sub].split("|");
		arr2[1]=quantity;
		var tempStr=arr2.join("|");//由数组重组字符串


		arr[sub] = tempStr;
		var newProList = arr.join("&");//由数组重组字符串

		cookie.set("carList",newProList);//更新购物车清单

	},  //修改物品结束


	clear:function(){
		cookie.del('carList');
	},

	
	delItem:function(skuId){
		goodsList = cookie.get("carList"); //车内商品ID列表

		var arr=goodsList.split("&");

		for(i=1;i<arr.length;i++){
		    if(arr[i].substr(0,arr[i].indexOf("="))==skuId) {
		        arr.splice(i, 1);
		    }
		}

		var newProList = arr.join("&");//由数组重组字符串

		cookie.set("carList",newProList);//更新购物车清单
	},

	//反回数组下标
	getSubPlace:function(skuId){
		goodsList = cookie.get("carList"); //车内商品ID列表
		var arr=goodsList.split("&");
		for(i=1;i<arr.length;i++){
		    if(arr[i].substr(0,arr[i].indexOf("="))==skuId) {
		        return i;
		    }
		}
	},

	getQuantity:function(skuId){
		goodsList = cookie.get("carList"); //车内商品ID列表

		var arr=goodsList.split("&");
		var sub=Cart.getSubPlace(skuId);//获取该物品在COOKIE数组中的下标位置
		var arr2=arr[sub].split("|");
		return arr2[1];
	},

	getTotalType:function(){
		goodsList = cookie.get("carList"); //车内商品ID列表
		if (!goodsList) {return 0};
		return goodsList.split("&").length - 1;
	},

	getTotalNum:function(){
		goodsList = cookie.get("carList"); //车内商品ID列表
		if (!goodsList) {return 0};

		var arr = goodsList.split("&");
		var total = 0;

		for(i=1;i<arr.length;i++){
		    var data = arr[i].split('|');
		    total += parseInt(data[1]);
		}

		return total;
	},

	getTotalPrice:function(){
		goodsList = cookie.get("carList"); //车内商品ID列表
		if (!goodsList) {return 0};
		
		var arr = goodsList.split("&");
		var total = 0;

		for(i=1;i<arr.length;i++){
		    var data = arr[i].split('|');
		    var price = parseFloat(data[2]);
		    var num = parseInt(data[1]);

		    total += price * num;
		}

		return total;
	},


	reloadHtml:function(){
		goodsList = cookie.get("carList"); //车内商品ID列表

		if (!goodsList) {
			// $('.clof').addClass('hide');
			$('.shop_cars_dis').html("￥ 0.00");
			return ;
		};

		var arr=goodsList.split("&");
		for(i=1;i<arr.length;i++){
			var skuId = arr[i].substr(0,arr[i].indexOf("="));
			var goodsId = arr[i].substring(arr[i].indexOf("=")+1, arr[i].indexOf("|"));
			var attr = arr[i].split("|");
			var num = attr[1];
			$('.num[sku-id='+skuId+']').val(num);
			$('.cl' + goodsId + skuId).val(num);
		}

		$('.shop_cars_dis').html("￥"+Cart.getTotalPrice()+" 元 "+Cart.getTotalType()+" 样 "+Cart.getTotalNum()+" 份");
		
	},


	hasOne:function(skuId){
     	goodsList = cookie.get("carList"); //车内商品ID列表
		var arr=goodsList.split("&");
		for(i=1;i<arr.length;i++){
			if(arr[i].substr(0,arr[i].indexOf("="))==skuId) {
				return true;
			}
		}
		return false;
     },  //检测结束
}