




















if(typeof doyoo=='undefined' || !doyoo){
var d_genId=function(){
var id ='',ids='0123456789abcdef';
for(var i=0;i<34;i++){ id+=ids.charAt(Math.floor(Math.random()*16));  }  return id;
};
var doyoo={
env:{
secure:false,
mon:'http://m9104.talk99.cn/monitor',
chat:'http://chat7123b.talk99.cn/chat',
file:'http://yun-static.soperson.com/131221',
compId:10031994,
confId:10054066,
vId:d_genId(),
lang:'',
fixFlash:1,
fixMobileScale:0,
subComp:9532,
_mark:'f1c744ffdc95edd9f6c797acad38d62a56d1d530be0f615cbd17bc2b9b269e0f44050638487045f4'
},
chat:{
    mobileColor:'',
    mobileHeight:80,
    mobileChatHintBottom:0,
    mobileChatHintMode:0,
    mobileChatHintColor:'',
    mobileChatHintSize:0
}

, monParam:{
index:-1,
preferConfig:0,

style:{mbg:'http://www.yihedoors.com/images/talk99.jpg',mh:235,mw:300,
elepos:'0 0 0 0 0 0 0 0 118 72 66 23 204 72 204 23 0 0 0 0',
mbabg:'',
mbdbg:'',
mbpbg:''},

title:'\u5728\u7ebf\u5ba2\u670d',
text:'\u5c0a\u656c\u7684\u5ba2\u6237\u60a8\u597d\uff0c\u6b22\u8fce\u5149\u4e34\u672c\u516c\u53f8\u7f51\u7ad9\uff01\u6211\u662f\u4eca\u5929\u7684\u5728\u7ebf\u503c\u73ed\u5ba2\u670d\uff0c\u70b9\u51fb\u201c\u5f00\u59cb\u4ea4\u8c08\u201d\u5373\u53ef\u4e0e\u6211\u5bf9\u8bdd\u3002',
auto:5,
group:'10041301',
start:'00:00',
end:'24:00',
mask:false,
status:false,
fx:0,
mini:1,
pos:1,
offShow:0,
loop:0,
autoHide:0,
hidePanel:0,
miniStyle:'#0680b2',
miniWidth:'340',
miniHeight:'490',
showPhone:0,
monHideStatus:[0,0,0],
monShowOnly:'',
autoDirectChat:-1,
allowMobileDirect:0,
minBallon:1,
chatFollow:1
}


, panelParam:{
category:'icon',
preferConfig:0,
position:1,
vertical:180,
horizon:5


,mode:1,
target:'10041301',
online:'http://a.looyu.com/10031994/74d37695a8464caf9ae9d16d2f517e22.jpg',
offline:'http://a.looyu.com/10031994/74d37695a8464caf9ae9d16d2f517e22.jpg',
width:150,
height:408,
status:0,
closable:1,
regions:[],
collapse:0



}



};

if(typeof talk99Init == 'function'){
talk99Init(doyoo);
}
if(!document.getElementById('doyoo_panel')){
var supportJquery=typeof jQuery!='undefined';
var doyooWrite=function(html){
document.writeln(html);
}

doyooWrite('<div id="doyoo_panel"></div>');


doyooWrite('<div id="doyoo_monitor"></div>');


doyooWrite('<div id="talk99_message"></div>')

doyooWrite('<div id="doyoo_share" style="display:none;"></div>');
doyooWrite('<lin'+'k rel="stylesheet" type="text/css" href="http://yun-static.soperson.com/131221/oms.css?17051301"></li'+'nk>');
doyooWrite('<scr'+'ipt type="text/javascript" src="http://yun-static.soperson.com/131221/oms.js?170513" charset="utf-8"></scr'+'ipt>');
}
}
