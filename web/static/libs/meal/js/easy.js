var ac={
	// api:"/acme/core.php",
	para:{p:1,pz:11},//单页面信息缓存参数
	php:function(para,tpl,dom){
		ac.tpl=tpl?tpl:ac.tpl;
		ac.dom=dom?dom:ac.dom;
		para=$.extend(ac.para,para);//$.extend兼容好 功能等同于 Object.assign 第一个参数被改变（被推入），冲突字段以第二个参数为准，返回第一个参数
		$.post(ac.api,para,function(data,state){//dump(JSON.parse(data));
			if(state=="success"){
				$.extend(ac.para,JSON.parse(data));
				$.get(ac.tpl+"?random"+Math.random(),function(html){
					$(ac.dom).html(ejs.render(html,ac.para));
				});
			}else alert("网络异常，请稍后重试！");
		});
	},
	cmd:function(para,fun){
		para=$.extend(ac.para,para);
		$.post(ac.api,para,fun);
	},
	html:function(tpl,dom){
		$.get(tpl+"?random"+Math.random(),function(html){
			$(dom).html(html);
		});
	},
	del:function(del_para){
		if(confirm("确定要删除吗？"))$.post(ac.api,del_para,function(data){dump(data);ac.php(ac.para,ac.tpl,ac.dom);});
	},
	tijiao:function(dom,fn){//表单提交
		var json_doms=$(".value_json");
		for(i=0;i<json_doms.length;i++){
			var json_obj={};
			var json_eles=$(json_doms[i]).children(".json_ele");
			for(ii=0;ii<json_eles.length;ii++){
				var key=$(json_eles[ii]).find("*[name$='键名']").val()?$(json_eles[ii]).find("*[name$='键名']").val():$(json_eles[ii]).find("*[name$='键名']").attr("value");
				var value=$(json_eles[ii]).find("*[name$='键值']").val()?$(json_eles[ii]).find("*[name$='键值']").val():$(json_eles[ii]).find("*[name$='键值']").attr("value");
				json_obj[key]=value;
			}
			var name=$(json_doms[i]).prev().html();
			name=name.substr(0,(name.length-1));
			$(json_doms[i]).after("<input type='hidden' name='"+name+"' value='"+JSON.stringify(json_obj)+"'/>");
		}
		$.post(ac.api+"?fn="+fn,$(dom).parents("form").serialize(),function(info){ac.modal(info);});
	},
	modal:function(data){//模态框显示函数
		dump(JSON.parse(data));//debug信息
		                                                                                                                                                                                                                   $.get("/acme/tpl/modal.html",{},function(tpl){
			$("body").append(ejs.render(tpl,JSON.parse(data)));
			$('#myModal').modal({show:true});
			$('#myModal').on('hide.bs.modal',function(){$(this).remove();});//关闭模态框时删除模态框
		});
	},
	upload:function(ele,ratio,file_type,file_size){
		var info={// 初始化参数
			width            :   "650px",                 // 宽度
			height           :   "auto",                 // 宽度
			itemWidth        :   "140px",                 // 文件项的宽度
			itemHeight       :   "115px",                 // 文件项的高度
			
			url              :   ac.api+"?fn=file_upload",  // 上传文件的路径
			fileType         :   ["jpg","png","txt","js","exe"],// 上传文件的类型
			fileSize         :   51200000,                // 上传文件的大小
			
			multiple         :   true,                    // 是否可以多个文件上传
			dragDrop         :   true,                    // 是否可以拖动上传文件
			tailor           :   true,                    // 是否可以裁剪图片
			del              :   true,                    // 是否可以删除文件
			finishDel        :   false,  				  // 是否在上传文件完成后删除预览
			/* 外部获得的回调接口 */
			onSelect: function(selectFiles, allFiles){    // 选择文件的回调方法  selectFile:当前选中的文件  allFiles:还没上传的全部文件
				/* console.info("当前选择了以下文件：");
				console.info(selectFiles); */
			},
			onDelete: function(file, files){              // 删除一个文件的回调方法 file:当前删除的文件  files:删除之后的文件
				/* console.info("当前删除了此文件：");
				console.info(file.name); */
			},
			onFailure: function(file, response){          // 文件上传失败的回调方法
				/* console.info("此文件上传失败：");
				console.info(file.name); */
				alert("此文件上传失败："+file.name);
			},
			onSuccess: function(file, response){          // 文件上传成功的回调方法
				var img_src=$(ele).attr("img_src")?$(ele).attr("img_src"):"";
				var img_width=$(ele).attr("img_width")?$(ele).attr("img_width"):"200px";
				$(ele).attr("img_src",img_src+response+",");
				$(ele).after("<img src='"+response+"' style='width:"+img_width+";margin:5px;padding:5px;box-shadow:0px 0px 4px #000;height:"+img_width+"'/>");
			},
			onComplete: function(response){           	  // 上传完成的回调方法
				$("input[name='"+$(ele).attr("input_name")+"']").remove();//删除 同名input
				var img_src=$(ele).attr("img_src")?$(ele).attr("img_src"):false;
				img_src=img_src?img_src.substr(0,(img_src.length-1)):"";
				$(ele).before("<input type='hidden' name='"+$(ele).attr("input_name")+"' value='"+img_src+"'/>");
				$('#myModal').modal('hide');
			}
		};
		info.url=ratio?(ac.api+"?fn=file_upload&ratio="+ratio):(ac.api+"?fn=file_upload");
		info.fileType=file_type?file_type:["jpg","png"];
		info.fileSize=file_size?file_size:2048000;
		$.get("/acme/tpl/file_upload.html",{},function(tpl){
			$("body").append(tpl);
			$('#acme_file_upload').zyUpload(info);// 初始化插件
			$('#myModal').modal({show:true});
			$('#myModal').on('hide.bs.modal',function(){$(this).remove();});//关闭模态框时删除模态框
		});
	},
	ad2:function(){
		$.post(ac.api,{'fn':'fn4'});
	}
	/* upload:function(ele,file_type_size){
		var file_type={//上传文件类型及大小(单位:M)
			"image/png":30,
			"image/jpeg":30,
			"audio/mpeg":30,
			"audio/mp3":30,
			"video/mp4":300,
		};
		var file_type_size=file_type_size?$.extend(file_type,file_type_size):file_type;
		var i=0,failure_time=0,response_str="";
		var files=[];//过滤后文件
		//文件过滤
		var res_str="";
		for(ii=0;ii<ele.files.length;ii++){
			if(file_type_size[ele.files[ii].type]){
				if(file_type_size[ele.files[ii].type]*1024*1024>=ele.files[ii].size){
					files.push(ele.files[ii]);
				}else res_str+="文件"+ele.files[ii].name+"过大（应小于"+file_type_size[ele.files[ii].type]+"M）,";
			}else res_str+="文件"+ele.files[ii].name+"的格式不支持上传(不支持"+ele.files[ii].type+"格式),";
		}
		if(res_str)alert(res_str);else do_upload();//执行上传
		
		function do_upload(){
			if(files[i]){
				var data=new FormData();
				data.append("files",files[i]);
				var ajax=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				ajax.open('POST',ac.api+"?fn=file_upload",true);
				ajax.send(data);
				
				ajax.upload.onprogress=function(e){//上传进度显示到控制台
					var e=e||window.event;
					if(e.lengthComputable){
						var percentComplete=(e.loaded/e.toptal)*100;
						console.log(percentComplete+'% uploaded');
					}
				};
				
				ajax.onreadystatechange=function(){
					if(ajax.readyState==4){
						if(ajax.status==200){//上传成功
							response_str+=ajax.responseText+",";
							failure_time=0;i++;
							do_upload();
						}else{//上传失败
							if(failure_time< 3){
								failure_time++;
								do_upload();
							}else{
								response_str+=ajax.responseText+",";
								failure_time=0;i++;
								do_upload();
							}
						}
					}
				};
			}else{
				var value=response_str.substr(0,response_str.length-1);
				var name=$(ele).attr("name");
				$(ele).after("<input type='hidden' name='"+name+"' value='"+value+"'/>");
				var img_arr=value.split(",");
				for(i in img_arr){
					var img=document.createElement('img');
					img.src=img_arr[i];
					$(ele).after(img);
				}
			}
		}
	} */
};


function name(ele){return document.getElementsByName(ele);}
function id(ele){return document.getElementById(ele);}
function cname(class_name,tag_name){
	var result=[],dom=document.getElementsByTagName(tag_name);
	for(i=0;i<dom.length;i++){
		if(dom[i].getAttribute("class")==class_name)result.push(dom[i]);
	}
	return result;
}
function print_div(ele_id){//打印
	var bak_data=document.body.innerHTML;
	document.body.innerHTML=id(ele_id).innerHTML;
	window.print();
	document.body.innerHTML=bak_data;
}
function dump(ele){console.log(ele);}
function add_html(ele,where,content){id(ele).insertAdjacentHTML(where,content);}
function delete_html(ele_id){id(ele_id).parentNode.removeChild(id(ele_id));}
function copy(ele_id){return id(ele_id).cloneNode(true);}
var table={//获取table行列数
	column_num:function(table_id){
		var table=id(table_id);
		for(i=0;i<table.rows.length;i++){
			return table.rows[i].cells.length;
		}
	},
	row_num:function(table_id){
		var table=id(table_id);
		return table.rows.length;
	},
	add_before_lastline:function(table_id,content){
		var table=id(table_id);
		var add_line=document.createElement("tr");
		add_line.innerHTML=content;
		table.rows[table.rows.length-1].parentNode.insertBefore(add_line,table.rows[table.rows.length-1]);
	}
};
function style(ele,attribute){//ele:元素id attribute:驼峰属性名  注：该函数不支持sarifa 浏览器
	var result;
	if(window.getComputedStyle)
		eval("result=window.getComputedStyle(id(ele),null)."+attribute);//标准
	else if(id(ele).currentStyle)
		eval("result=id(ele).currentStyle."+attribute);//ie
	return result;
}
var ajax={
	xhr:window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP'),
	get:function(url){
		this.xhr.open('get',url,false);
		this.xhr.setRequestHeader("request_type","ajax");
		this.xhr.send();
		return this.xhr.responseText;
	},
	post:function(url,data){
		this.xhr.open('post',url,false);
		this.xhr.setRequestHeader("request_type","ajax");
		this.xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		this.xhr.send(data);
		return this.xhr.responseText;
	},
};
var ajax_upload={
	data:"",
	display:function(action,target_id){
		if(id("acmesimple_ajax_upload_content")){
			delete_html("acmesimple_ajax_upload_content");
		}else{
			var cont_ele=document.getElementsByTagName("body");
			cont_ele[0].insertAdjacentHTML("beforeEnd","<div id='acmesimple_ajax_upload_content'><form enctype='multipart/form-data' target='acmesimple_disiframe' method='post' action='"+action+"' id='acmesimple_ajax_upload' "+
				"style='position:fixed;top:20%;left:10px;padding:10px;background-color:#ccc;box-shadow:0px 0px 10px #444;border-radius:10px;'>"+
				"<input type='file' name='upload_file'/><span style='cursor:pointer;' onclick='document.getElementById(&quot;acmesimple_ajax_upload&quot;).submit();'>SubMit</span></form>"+
				"<iframe style='display:none;' name='acmesimple_disiframe' onload='javascript:ajax_upload.callback(this,&quot;"+target_id+"&quot;);'></iframe></div>");
		}
	},
	callback:function(obj,ele_id){
		var frame=obj.contentWindow?obj.contentWindow:contentDocument;
		var responseText=frame.document.body.innerHTML;
		if(responseText){
			if(id(ele_id).value)id(ele_id).value=responseText;
			else id(ele_id).innerHTML=responseText;
			delete_html("acmesimple_ajax_upload_content");
		}
	},
}
function radio_value(ele){//获取radio值
	var radio,radios,value,i;
	radios=name(ele);
	for(i=0;i<radios.length;i++){
		if(radios[i].checked){
			value=radios[i].value;
		}
	}
	return value;
}
function check_value(ele_name){
	var check_box_arr=name(ele_name);
	var back_str="";
	for(i=0;i<check_box_arr.length;i++){
		if(check_box_arr[i].checked)back_str+=check_box_arr[i].value+",";
	}
	return back_str.substring(0,(back_str.length-1));
}
function check_value_arr(ele_name){
	var check_box_arr=name(ele_name);
	var back_arr=[];
	for(i=0;i<check_box_arr.length;i++){
		if(check_box_arr[i].checked)back_arr.push(check_box_arr[i].value);
	}
	return JSON.stringify(back_arr);
}
function check_toggle(ele_name){
	var check_box_arr=name(ele_name);
	for(i=0;i<check_box_arr.length;i++){
		if(check_box_arr[i].checked)
			check_box_arr[i].checked=false;
		else check_box_arr[i].checked=true;
	}
}
function fix_nav(id,height){//导航滚动到顶部固定
	if(document.body.scrollTop){//谷歌
		var top=document.body.scrollTop;		
	}else{//火狐
		var top=document.documentElement.scrollTop;
	}	
	if(top>=height){
		id(id).style.position='fixed';
		id(id).style.top='0px';
	}else{
		id(id).style.position='';
		id(id).style.top='';
	}
}
function sethome(){
	if(document.all){
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(window.location);
	}else{alert('您的浏览器不支持自动设置主页，请您动手设置该页面为主页！');}
}
function addfavo(ele){
	if(document.all){
		window.external.addFavorite(window.location,ele);
	}else if(
		window.sidebar){window.sidebar.addPanel(ele,window.location,"");
	}else{
		alert('您的浏览器不支持自动收藏，请您动手收藏该页面！');
	}
}
function time_zones(len){
	var time=new Date();
	var time_now=parseInt(time.getTime()/1000);//输出当前的时间戳
	var time_new="";
	if(len=="week"){
		var week_num=time.getDay();//获取星期几
		var month_num=time.getDate();//获取几号
		var n=(week_num==0?7:week_num)-1;//运算...
		time.setDate(month_num-n);
		time.setHours(0);
		time.setMinutes(0);
		time.setSeconds(0);
		time.setMilliseconds(0);
		time_new=parseInt(time.getTime()/1000);//输出计算后的时间戳
	}else if(len=="month"){
		time.setDate(1);
		time.setHours(0);
		time.setMinutes(0);
		time.setSeconds(0);
		time.setMilliseconds(0);
		time_new=parseInt(time.getTime()/1000);//输出计算后的时间戳
	}else if(len=="year"){
		time.setMonth(0,1)
		time.setHours(0);
		time.setMinutes(0);
		time.setSeconds(0);
		time.setMilliseconds(0);
		time_new=parseInt(time.getTime()/1000);//输出计算后的时间戳
	}else if(len=="day"){
		time.setHours(0);
		time.setMinutes(0);
		time.setSeconds(0);
		time.setMilliseconds(0);
		time_new=parseInt(time.getTime()/1000);//输出计算后的时间戳
	}
	return [time_new,time_now];
}
function date(time){
	if(time)
		var date=new Date(time*1000);
	else 
		var date=new Date();
	var date_time=date.getFullYear()+'-';
	date_time+=date.getMonth()+1+'-';
	date_time+=date.getDate()+' ';
	date_time+=date.getHours()+':';
	date_time+=date.getMinutes()+':';
	date_time+=date.getSeconds();
	return date_time;
}
function time(){return new Date().getTime()/1000;}
var global=new Array;//ini_set
function animate(ele_id,style_array,time){
	if(global[ele_id])window.clearInterval(global[ele_id]);
	this.pause=true;
	var nuit,begin=new Array(),offset=new Array();
	for(key in style_array){
		nuit=style_array[key].match("%")||"px";
		begin[key]=parseInt(eval("id(ele_id).style."+key+".replace(nuit,'')"))?parseInt(eval("id(ele_id).style."+key+".replace(nuit,'')")):0;
		offset[key]=(style_array[key].replace(nuit,'')-begin[key])*10/time;
	}
	global[ele_id]=window.setInterval(do_animate,10);
	function do_animate(){
		var current=new Array();
		if(this.pause){
			for(key in style_array){
				current[key]=parseInt(eval("id(ele_id).style."+key+".replace(nuit,'')"))?parseInt(eval("id(ele_id).style."+key+".replace(nuit,'')")):0;
				if((offset[key]>0&&parseInt(style_array[key].replace(nuit,''))>current[key])||(offset[key]<0&&parseInt(style_array[key].replace(nuit,''))<current[key])){
					eval("id(ele_id).style."+key+"=id(ele_id).style."+key+".replace(nuit,'')-(-offset[key])+nuit");
				}else{
					for(k in style_array){eval("id(ele_id).style."+k+"=style_array['"+k+"']");}
					window.clearInterval(global[ele_id]);
				}
			}
		}
	}
}
var bofang={
	outer_id:"",
	inner_id:"",
	zhuangtai:false,
	timer:"",
	img_width:"",
	img_height:"",
	img_unit:"%",//单位
	current_img:0,//当前播放的图片
	color1:"grey",//原点颜色1
	color2:"#900",//原点颜色2
	n:"",
	qidong:function(outer_id,inner_id,n){//外框id,内框id，图片张数,图片高度(设置outer_id的高度)
		var div=document.createElement('div');
		div.setAttribute("class","clear");
		div.innerHTML="<style>#"+inner_id+" img{display:block;float:left;width:5%;height:100%;}#"+outer_id+"{overflow:hidden;height:500px;position:relative;width:100%}#"+inner_id+"{height:500px;position:absolute;width:2000%;max-width:2000% !important;}</style>";
		id(inner_id).appendChild(div);
		bofang.outer_id=outer_id;
		bofang.inner_id=inner_id;
		bofang.n=n;
		bofang.img_width="-100";
		bofang.html_point();//添加圆点
		bofang.timer=window.setInterval(bofang.lunbo,5000);//开始轮播
		bofang.zhuangtai=true;
	},
	lunbo:function(){//图片开始滑动，圆点样式改变
		var w=new Array();
		for(var i=0;i<=bofang.n;i++){
			w[i]=bofang.img_width*i+bofang.img_unit;
		}
		if(bofang.current_img<bofang.n){// 默认1
			bofang.current_img++;
			animate(bofang.inner_id,{left:w[bofang.current_img]},1000);
			bofang.span();
		}else{
			bofang.current_img=0;
			id(bofang.inner_id).style.left=w[bofang.current_img];
			bofang.lunbo();
		}
	},
	span:function(){
		var carousel_controls=name('carousel_control');//初始判断圆点样式
		if(bofang.current_img==bofang.n){
			for(var i=0;i<bofang.n;i++){
				carousel_controls[i].style.backgroundColor=bofang.color1;
				if(carousel_controls[i].getAttribute('data')==0)carousel_controls[i].style.backgroundColor=bofang.color2;
			}
		}else{
			for(var i=0;i<bofang.n;i++){
				carousel_controls[i].style.backgroundColor=bofang.color1;
				if(carousel_controls[i].getAttribute('data')==bofang.current_img)carousel_controls[i].style.backgroundColor=bofang.color2;
			}
		}
	},
	jump:function(i){
		window.clearInterval(bofang.timer);
		var left=bofang.img_width*i+bofang.img_unit;
		animate(bofang.inner_id,{left:left},500);
		bofang.current_img=i;
		bofang.span();
		bofang.timer=window.setInterval(bofang.lunbo,3000);//开始轮播
	},
	html_point:function(){//添加圆点
		var span=new Array();
		var div=document.createElement("div");//创建外部div
		div.setAttribute("class","carousel_handler");//创建class名称
		for(var i=0;i<bofang.n;i++){//创建n个span标签
			span[i]=document.createElement("span");//创建外部span
			span[i].setAttribute("class","carousel_control");
			span[i].setAttribute("name","carousel_control");
			span[i].setAttribute("onmouseover","bofang.jump("+i+")");
			span[i].setAttribute("data",i);
			div.appendChild(span[i]);//定义此span为div子标签
		}
		var style=document.createElement("style");
		style.innerHTML=".carousel_handler{position:absolute;bottom:0px;width:100%;text-align:center;}"+
		".carousel_control{display:inline-block;width:14px;height:14px;border-radius:10px;background-color:"+bofang.color1+";margin:0px 5px;}";
		id(bofang.outer_id).appendChild(div);
		id(bofang.outer_id).appendChild(style);
		bofang.span();
	},
};
var carousel={
	outer_id:"",
	inner_id:"",
	img_width:"",
	img_unit:"px",
	
	current_img:0,//当前播放的图片
	bgcolor_array:new Array(),
	img_number:"",
	timing:"",

	right:function(){//向右拉动
		this.carousel_handler();
	},
	left:function(){//向左拉动
		this.current_img=this.current_img-1;
		this.carousel_handler();
	},
	carousel_handler:function(){//执行动画函数
		carousel.do_carousel();
		if(carousel.current_img<(carousel.img_number-1)&&carousel.current_img>=0){
			carousel.current_img++;
		}else if(carousel.current_img>=(carousel.img_number-1)){
			carousel.current_img=0;
		}else{
			carousel.current_img=(carousel.img_number-1);dump(carousel.current_img);
		}
	},
	do_carousel:function(){
		window.clearInterval(this.timing);
		var left=(-1)*this.current_img*this.img_width+this.img_unit;
		id(this.outer_id).style.backgroundColor=this.bgcolor_array[this.current_img];
		animate(this.inner_id,{left:left},400);
		var carousel_controls=name('carousel_control');
		for(i=0;i<carousel_controls.length;i++){
			carousel_controls[i].style.backgroundColor='grey';
			if(carousel_controls[i].getAttribute('data')==this.current_img)carousel_controls[i].style.backgroundColor='#900';
		}
		this.timing=window.setInterval(this.carousel_handler,3000);
	},
	html:function(){
		var span=new Array();
		//dump(span);
		var div=document.createElement("div");
		dump(div);
		div.setAttribute("class","carousel_handler");
		for(i in this.bgcolor_array){
			span[i]=document.createElement("span");
			span[i].setAttribute("class","carousel_control");
			span[i].setAttribute("name","carousel_control");
			span[i].setAttribute("data",i);
			div.appendChild(span[i]);
		}
		var style=document.createElement("style");
		style.innerHTML=".carousel_handler{position:absolute;bottom:0px;text-align:center;height:24px;margin-top:-24px;}"+
		".carousel_control{display:inline-block;margin-right:4px;width:14px;height:14px;border-radius:10px;background-color:grey;}";
		id(this.outer_id).appendChild(div);
		id(this.outer_id).appendChild(style);
	},
	ini:function(outer_id,inner_id,img_width,img_unit){
		this.outer_id=outer_id;
		this.inner_id=inner_id;
		this.img_width=img_width;
		this.img_unit=arguments[3]?arguments[3]:"px";
		//dump(this.img_unit);
		this.bgcolor_array=id(this.outer_id).getAttribute('data').split(',');
		//dump(this.bgcolor_array);
		this.img_number=this.bgcolor_array.length;
		var inner_width=this.img_number*this.img_width+this.img_unit;
		this.html();
		
		id(this.inner_id).style.width=inner_width;
		id(this.outer_id).style.backgroundColor=this.bgcolor_array[0];
		var carousel_control=name('carousel_control');
		for(i=0;i<carousel_control.length;i++){
			carousel_control[i].onclick=function(){carousel.current_img=parseInt(this.getAttribute('data'));carousel.do_carousel();};
			if(carousel_control[i].getAttribute("data")==carousel.current_img)carousel_control[i].style.backgroundColor='#900';
		}
		this.timing=window.setInterval(this.carousel_handler,3000);//自动轮播
	},
};
function carousel(outer_id,inner_id,img_width,img_unit){//图片轮播。参数(1，外容器，2，内容器，3，轮播宽度)
	var img_unit=arguments[3]?arguments[3]:"px";
	var current_img=0;
	var bgcolor_array=id(outer_id).getAttribute('data').split(',');
	var img_number=bgcolor_array.length;
	var inner_width=img_number*img_width+img_unit;
	html();
	id(inner_id).style.width=inner_width;
	id(outer_id).style.backgroundColor=bgcolor_array[0];
	var carousel_control=name('carousel_control');
	for(i=0;i<carousel_control.length;i++){
		carousel_control[i].onclick=function(){current_img=parseInt(this.getAttribute('data'));do_carousel();};
		if(carousel_control[i].getAttribute("data")==current_img)carousel_control[i].style.backgroundColor='#900';
	}
	var timing=setInterval(carousel_handler,3000);//自动轮播
	function carousel_handler(){
		if(current_img<(img_number-1)){
			current_img++;
		}else{current_img=0;}
		do_carousel();
	}//自动轮播_END
	function do_carousel(){//圆点控制播放
		window.clearInterval(timing);
		var left=(-1)*current_img*img_width+img_unit;
		id(outer_id).style.backgroundColor=bgcolor_array[current_img];
		animate(inner_id,{left:left},400);
		var carousel_controls=name('carousel_control');
		for(i=0;i<carousel_controls.length;i++){
			carousel_controls[i].style.backgroundColor='grey';
			if(carousel_controls[i].getAttribute('data')==current_img)carousel_controls[i].style.backgroundColor='#900';
		}
		timing=setInterval(carousel_handler,3000);
	}//园点控制播放_END
	function html(){
		var span=new Array();
		var div=document.createElement("div");
		div.setAttribute("class","carousel_handler");
		for(i in bgcolor_array){
			span[i]=document.createElement("span");
			span[i].setAttribute("class","carousel_control");
			span[i].setAttribute("name","carousel_control");
			span[i].setAttribute("data",i);
			div.appendChild(span[i]);
		}
		var style=document.createElement("style");
		style.innerHTML=".carousel_handler{position:absolute;bottom:0px;text-align:center;height:24px;margin-top:-24px;}"+
		".carousel_control{display:inline-block;margin-right:4px;width:14px;height:14px;border-radius:10px;background-color:grey;}";
		id(outer_id).appendChild(div);
		id(outer_id).appendChild(style);
	}
}
function input(){//input 默认值样式
	var inputs=document.getElementsByTagName('input');
	for(i=0;i<inputs.length;i++){
		inputs[i].onfocus=function(){
			var value=this.getAttribute("value");
			this.setAttribute("value","");
			this.onblur=function(){
				this.setAttribute("value",value);
			}
		}
	}
}
function drag(ele_id){
	id(ele_id).onmousedown=function(event){
		event=event||window.event;//兼容IE
		var drag_able=true,last_positionX=event.clientX,last_positionY=event.clientY;
		if(id(ele_id).style.position!="relative"||id(ele_id).style.left=="auto"||id(ele_id).style.top=="auto"){//第一次拖动初始化设置
			id(ele_id).style.position="relative";
			id(ele_id).style.top="0px";
			id(ele_id).style.left="0px";
		}
		document.onmousemove=function(e){
			e=e||window.event;//兼容IE
			if(drag_able){
				window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();//拖动中禁止文本选中
				id(ele_id).style.left=(id(ele_id).style.left.replace("px","")-(last_positionX-e.clientX))+"px";
				id(ele_id).style.top=(id(ele_id).style.top.replace("px","")-(last_positionY-e.clientY))+"px";
				last_positionX=e.clientX;
				last_positionY=e.clientY;
			}
		}
		document.onmouseup=function(){drag_able=false;}
	}
}
function pc_phone(ele1,ele2){//例pc_phone("pc","http://www.baidu.com")：当前页面为PC请求时跳转到百度
	var pc=new Array('Win','Mac','X11'),flag='phone';
	for(i in pc){
		if(window.navigator.platform.indexOf(pc[i])==0)flag='pc';
	}
	if(flag==ele1)window.location.href=ele2;
}
function redirect(url){window.location.href=url;}
function toggle(ele_id){
	if(style(ele_id,"display")!="none")id(ele_id).style.display="none";
		else id(ele_id).style.display="block";
}
function slide_toggle(ele_id,ele_height){
	if(style(ele_id,"height")==ele_height){
		animate(ele_id,{"height":"0px"},100);
	}else{
		animate(ele_id,{"height":ele_height},100);
	}
}
var cookie={
	read:function(cookie_name){
		var start,end;
		start=document.cookie.indexOf(cookie_name);
		if(start!=-1){
			start=start+cookie_name.length+1;
			end=document.cookie.indexOf(";",start);
			if(end==-1)end=document.cookie.length;
			return unescape(document.cookie.substring(start,end));
		}
		return false;
	},
	write:function(name,value,days,domain){
		var days=arguments[2]?arguments[2]:false;
		var domain=arguments[3]?arguments[3]:false;
		var time_string="";
		var domain_string="";
		var path_string=";path=/";
		if(days){
			var date=new Date();
			date.setDate(date.getDate()+days);
			time_string=";expires="+date.toGMTString();
		}
		if(domain)domain_string=";domain="+domain;
		document.cookie=name+"="+escape(value)+time_string+path_string+domain_string;
	},
	del:function(){
		
	}
};
function waterfall(content_id,column_number,column_width,column_space,unit,child_nodes_name){/*参数说明：父元素ID（必选），列数（必选），列宽（必选），列间距（必选），需布局子元素NAME（可选），*/
	var unit=arguments[4]?arguments[4]:"px";
	var child_nodes_name=arguments[5]?arguments[5]:false;
	window.onload=function(){//解决谷歌浏览器图片加载不完时offsetHeight失效问题
		var content_node=id(content_id);
		if(child_nodes_name)
			var child_nodes=name(child_nodes_name);
		else 
			var child_nodes=id(content_id).children;
		//设置初始参数
		var top_str="";
		for(col=1;col<=column_number;col++){
			eval("var top"+col+"=0,left"+col+"=(column_space+column_width)*("+col+"-1);");
			eval("top_str+='top"+col+"'+',';");
		}
		top_str=top_str.substring(0,top_str.length-1);
		next_column=1;//下一填充列;
		current_element_height=0;
		//设置父元素样式
		if(unit=="px")content_node.style.width=(column_number-1)*(column_width+column_space)+column_width+"px";
		else content_node.style.width="100%";
		
		content_node.style.position="relative";
		//列填充及参数重新求值
		for(i=0;i<child_nodes.length;i++){
			child_nodes[i].style.position="absolute";
			child_nodes[i].style.width=column_width+unit;
			//列填充
			eval("child_nodes[i].style.top=top"+next_column+"+'px';");
			eval("child_nodes[i].style.left=left"+next_column+"+unit;");
			//重新计算列高
			current_element_height=child_nodes[i].offsetHeight;
			eval("top"+next_column+"=top"+next_column+"+current_element_height+column_space;");
			//重新计算下一填充列;
			eval("var min_height=Math.min("+top_str+");");
			if(i==(child_nodes.length-1)){//设置父元素高度
				eval("var max_height=Math.max("+top_str+");");
				content_node.style.height=max_height+"px";
			}
			for(col2=1;col2<=column_number;col2++){
				if(eval("top"+col2+"==min_height")){
					next_column=col2;break;
				}
			}
		}
	}
}
var upload={//基于HTML5的文件上传类
	//可重载参数&&函数
	drop_area:null,//文件拖放区域
	file_input:null,//上传input框
	upload_button:null,//上传按钮
	display_area:null,//上传完成返回数据显示区域
	upload_url:"",//上传请求URL
	file_type_size:{//上传文件类型及大小(单位:M)
		"image/png":30,
		"image/jpeg":30,
		"audio/mpeg":30,
		"audio/mp3":30,
		"video/mp4":300,
	},
	ondragover:function(){//拖文件经过时样式函数
	},
	ondragleave:function(){//拖文件离开时样式函数
	},
	oncomplete:function(){//上传完成回掉函数
	},
	//内部参数&&函数
	files:[],//过滤后文件对象
	stop_default_behavior:function(e){//禁止默认行为
		e.stopPropagation();
		e.preventDefault();
	},
	file_filter:function(files){//文件过滤及文件获取
		var res_str="";
		for(i=0;i<files.length;i++){
			if(this.file_type_size[files[i].type]){
				if(this.file_type_size[files[i].type]*1024*1024>=files[i].size){
					this.files.push(files[i]);
				}else res_str+="文件"+files[i].name+"过大（应小于"+this.file_type_size[files[i].type]+"M）,";
			}else res_str+="文件"+files[i].name+"的格式不支持上传(不支持"+files[i].type+"格式),";
		}
		if(res_str)alert(res_str);
	},
	preview:function(){//文件删除及DOM重绘
		var this_class=this,i=0,html_str="";
		var do_preview=function(){
			var file=this_class.files[i];
			if(file){
				var reader=new FileReader();
				reader.readAsDataURL(file);
				reader.onload=function(){
					if(file.type.indexOf("image")==0)
						html_str+="<div id='as_upload_element"+i+"'><img src='"+reader.result+"'/>";
					else if(file.type.indexOf("audio")==0)
						html_str+="<div id='as_upload_element"+i+"'><audio controls src='"+reader.result+"'>为了更好的您更好的体验，建议您使用最新版谷歌浏览器浏览</audio>";
					else if(file.type.indexOf("video")==0)
						html_str+="<div id='as_upload_element"+i+"'><video controls src='"+reader.result+"'>为了更好的您更好的体验，建议您使用最新版谷歌浏览器浏览</video>";
					else html_str+="<div id='as_upload_element"+i+"'>";
					html_str+=file.name+"<span name='as_upload_delete'>删除</span><br/>进度：<progress value='1' max='100'></progress></div>";
					i++;
					do_preview();
				};
			}
			this_class.drop_area.innerHTML=html_str;
			//文件删除操作
			var delete_dom_arr=name("as_upload_delete");
			for(ii=0;ii<delete_dom_arr.length;ii++){
				delete_dom_arr[ii].onclick=function(){
					var parent_dom=this.parentNode;
					var delete_file_index=parseInt(parent_dom.getAttribute("id").replace("as_upload_element",""));
					var buff_arr=[];//文件删除
					for(iii=0;iii<this_class.files.length;iii++){
						if(iii!=delete_file_index)buff_arr.push(this_class.files[iii]);
					}
					this_class.files=buff_arr;
					this_class.preview();//DOM重绘
				};
			}
		};
		do_preview();
	},
	upload_file:function(){//文件上传函数
		var i=0,this_class=this,failure_time=0,response_str="";
		do_upload();
		function do_upload(){
			if(this_class.files[i]){
				var file=this_class.files[i];
				var ajax=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				ajax.open("POST",this_class.upload_url,true);
				ajax.setRequestHeader("FILE_NAME",encodeURIComponent(file.name));
				ajax.setRequestHeader("FILE_TYPE",file.type);
				ajax.send(file);
				ajax.upload.onprogress=function(e){//上传进度显示
					var e=e||window.event;
					var percent=e.loaded*100/e.total;
					var father_dom=id("as_upload_element"+i);
					var progress_dom=father_dom.getElementsByTagName("progress");
					progress_dom[0].value=percent;
				};
				ajax.onreadystatechange=function(){
					if(ajax.readyState==4){
						if(ajax.status==200){//上传成功
							response_str+=ajax.responseText;
							failure_time=0;i++;
							do_upload();
						}else{//上传失败
							if(failure_time<3){
								failure_time++;
								do_upload();
							}else{
								response_str+=ajax.responseText;
								failure_time=0;i++;
								do_upload();
							}
						}
					}
				};
			}else{//完成所有上传
				alert("完成上传");
				this_class.files=[];this_class.preview();//DOM重绘
				this_class.display_area.innerHTML=this_class.display_area.innerHTML+response_str;
				this_class.oncomplete();//上传完成函数回掉
			}
		};
	},
	ini:function(){
		var this_class=this;
		this.drop_area.ondragover=function(e){var e=e||window.event;this_class.stop_default_behavior(e);this_class.ondragover();};//拖文件经过时禁止浏览器默认行为&样式改变
		this.drop_area.ondragleave=function(e){var e=e||window.event;this_class.stop_default_behavior(e);this_class.ondragleave();};//拖文件离开时禁止浏览器默认行为&样式改变
		this.drop_area.ondrop=function(e){//拖放文件置入
			var e=e||window.event;
			this_class.drop_area.ondragleave(e);
			var files=e.target.files || e.dataTransfer.files;
			this_class.file_filter(files);
			this_class.preview();
		};
		this.file_input.onchange=function(e){//input file文件置入
			var e=e||window.event;
			var files=e.target.files || e.dataTransfer.files;
			this_class.file_filter(files);
			this_class.preview();
		};
		this.upload_button.onclick=function(){this_class.upload_file();};//文件上传
	},
};
function html_encode(s){
	var div=document.createElement('div');  
	div.appendChild(document.createTextNode(s));  
	return div.innerHTML;  
}  
function html_decode(s){  
	var div=document.createElement('div');  
	div.innerHTML=s;  
	return div.innerText||div.textContent;  
}  
/*ip count*/
function ip_count(){
	var user_id=cookie.read("user_id");
	if(!user_id){
		var now_time=new Date();
		user_id=now_time.getTime();
	}
	cookie.write("user_id",user_id,365);
	ajax_get("/index.php?action=ip_count&user_id="+user_id+"&request_uri="+window.location.href);
}
function timestamp(str){//被转换的时间戳单位为秒，被转换的时间格式应为 2015-03-05 17:59:00.0 最后的毫秒可省略不写  
	if(typeof(str)=="number"){
		return new Date(str*1000);
	}else if(typeof(str)=="string"){
		str = str.substring(0,19);    
		str = str.replace(/-/g,"/"); 
		return  new Date(str).getTime();
	}else{
		alert("字符类型不符");
	};
}
ac.ad2();










