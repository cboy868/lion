/*
Add on 2015-07-28 by Zuber
用于获取obj下的所有input对象，并根据input取值
input 类型包含，text,hidden,select,checkbox
*/


/*
例：

获取selectors筛选器里的所有元素
var _M = $(".container").GetVal({
        selectors: ".text-control,[name=private]:checked,[name=peoplecount]:checked,input[type=hidden]",
        Exselectors: "#birthdayDate1,#gonedayDate1,#birthdayDate2,#gonedayDate2"
    });

    装载错误信息
    _M.seterr("Title", 'value==""', "<strong>纪念馆名称</strong>&nbsp;不能为空!");
    _M.seterr("Title", 'value=="11"', "<strong>纪念馆名称</strong>&nbsp;不能等于11!");

    执行装载后的错误验证
    _M.runerr() 

    直接执行返回错误
    if (_M.err("Title", _M.data.Title == "", "不允许为空")) return;
*/

; (function ($) {
    'use strict';     
    $.fn.extend({
        GetVal: function (options) {

            var defaults = {
                key: "name",        //将name作为键值对的Key
                selectors: "*",     //查询条件
                Exselectors: "",    //排除
                OneErrReturn: false,         //是否检查错误
                GetData: void (0),
                err_val: "value",            //执行错误脚本的时候，将字符串带有value的替换成对比的data值
                obj:this
            }

            var obj = this;
            var str = "";

            //设置默认值
            $.extend(defaults, options);

            //返回数据对象
            var _Map = new Map(defaults);

            //拆分查询条件，组装多个对象
            for (var i = 0; i < defaults.selectors.split(',').length; i++) {
                var select = defaults.selectors.split(',')[i];
                $(obj).find(select).each(function () {
                    var k, v, v_dom;
                    //元素的类型  div，input，select。。。。
                    var tag = this.tagName.toLowerCase();
                    //定义key
                    k = $(this).attr(defaults.key);
                    //元素的值
                    //if (tag == "select") { v = $(this).find("option:selected").val(); }
                    //else { v = $(this).val(); }

                    switch (tag) {
                        case "select":
                            v = $(this).find("option:selected").val();
                            break;
                        case "textarea":
                            v = $(this).html();
                            k = $(this).attr("id");
                            break;
                        case "div":
                            v = $(this).html();
                            k = $(this).attr("id");
                            break;
                        default:
                            v = $(this).val();
                    }
                    //元素对象
                    v_dom = $(this);
                    //赋值，封装
                    _Map.set(k, v, v_dom);
                })
            }

            //组装后，按查询条件过滤对象
            for (var i = 0; i < defaults.Exselectors.split(',').length; i++) {
                //查询条件
                var select = defaults.Exselectors.split(',')[i];
                //查询出需要删除的对象
                $(obj).find(select).each(function () {
                    //获取key
                    var k = $(this).attr(defaults.key);
                    //验证
                    if (typeof (k) != "undefined") {
                        //验证是否存在要删的元素
                        if (typeof (_Map.key[k]) != "undefined") {
                            //删除元素
                            _Map.remove(k);
                        }
                    }
                })
            }
            return _Map;
        },
        validate: function (key) {

        }
    })
})(jQuery);

//自定义对象
function Map(options) {
    var defaults = { key: "name", OneErrReturn: false, err_val: "value",obj:this };
    $.extend(defaults, options);

    this.keys = new Array();    //主键
    this.data = new Array();    //val值
    this.objs = new Array();    //元素对象
    this.err_keys = new Array();//错误消息对象
    
    //错误信息
    this.err = function (key, err_Ex, err_Msg) {

        this.seterr(key, err_Ex, err_Msg);

        if (typeof err_Ex == "boolean") {

            //直接检查检查到错误
            if (err_Ex) { err_status = true; }
            else { err_status = false; }
        }
            //表达式
        else {

            var obj_val = "this.get(key).data";
            var reg = new RegExp(defaults.err_val, "g");
            var sdfd = err_Ex.replace(reg, obj_val);
            if (eval(sdfd))
            { err_status = true; }
            else { err_status = false; }
        }

        //检查到错误
        if (err_status)
        {
            this.showerr_border(key);
            this.showerr(err_Msg);
        }

        return err_status;
    };

    //显示错误对话框
    this.showerr = function (err_Msg) {
        //显示错误  可扩展到显示DIV错误
        new $.Zebra_Dialog(err_Msg, { 'type': 'warning', 'title': '警告' });
    }

    //添加错误红色边框
    this.showerr_border = function (key) {
        //获取dom
        var obj_dom = this.get(key).objs;

        //标记错误CSS
        $(obj_dom).focus();
        $(obj_dom).addClass("err");

        //值改变，单击，输入事件  可恢复错误
        $(obj_dom).change(function () { $(obj_dom).removeClass("err"); });
        $(obj_dom).click(function () { $(obj_dom).removeClass("err"); });
        $(obj_dom).keydown(function () { $(obj_dom).removeClass("err"); });

    }

    //存入错误对象
    this.seterr = function (key, err_Ex, err_Msg) {

        //错误状态
        var err_status = false;

        //不存在错误的键
        if (this.err_keys[key] == null) {
            this.err_keys.push(key);
            eval("this.err_keys." + key + "={ err_Ex:new Array(),err_Msg:new Array()}");
        }

        //push错误信息
        this.err_keys[key].err_Ex.push(err_Ex);
        this.err_keys[key].err_Msg.push(err_Msg);
    };

    //执行错误检查
    this.runerr = function (keys) {

        //刷新数据
        this.refresh();

        //错误状态
        var err_status = false;

        //返回错误消息
        var errmsg = "";

        //替换关键字
        var reg = new RegExp(defaults.err_val, "g");

        //检查全部错误
        if (keys == "*" || keys == undefined) {
            for (var i = 0; i < this.err_keys.length; i++) {
                
                //遍历错误列表
                for (var j = 0; j < this.err_keys[this.err_keys[i]].err_Ex.length; j++) {
                    //对比的数据
                    var obj_val = "this.get('" + this.err_keys[i] + "').data";
                    //需要执行的语句
                    var eal = this.err_keys[this.err_keys[i]].err_Ex[j].replace(reg, obj_val);
                    if (eval(eal)) {
                        //检查到错误
                        this.showerr_border(this.err_keys[i]);
                        err_status = true;
                        errmsg = errmsg + this.err_keys[this.err_keys[i]].err_Msg[j] + "</br>";
                    }
                }
            }
        }
            //检查部分错误
        else {
            keys = "," + keys.toLowerCase() + ",";
            for (var i = 0; i < this.err_keys.length; i++) {
                //查找到需要验证的错误
                if (keys.indexOf("," + this.err_keys[i].toLowerCase() + ",") >= 0) {
                    //this.err_keys[this.err_keys[j]]
                    for (var j = 0; j < this.err_keys[this.err_keys[i]].err_Ex.length; j++) {
                        //对比的数据
                        var obj_val = "this.get('" + this.err_keys[i] + "').data";
                        //需要执行的语句
                        var eal = this.err_keys[this.err_keys[i]].err_Ex[j].replace(reg, obj_val);
                        if (eval(eal)) {
                            //检查到错误
                            this.showerr_border(this.err_keys[i]);
                            err_status = true;
                            errmsg = errmsg + this.err_keys[this.err_keys[i]].err_Msg[j] + "</br>";
                        }
                    }
                }
            }
        }

        if (err_status) { this.showerr(errmsg); }
        return err_status;
    };

    //刷新数据
    this.refresh = function () {
        for (var i = 0; i < this.keys.length; i++)
        {
            var key = this.keys[i];
            var tag = this.objs[key].context.tagName;
            if (tag) { tag = tag.toLowerCase(); }
            
            var v;
            if ($(this.objs[key]).attr("type")) {
                //radio 更新数据
                if ($(this.objs[key]).attr("type").toLowerCase() == "radio") {
                    var selector = defaults.key == "id" ? "#" + key : "[" + defaults.key + "=" + key + "]:checked";
                    this.objs[key] = $(defaults.obj).find(selector);
                }
            }

            switch (tag) {
                case "select":
                    v = $(this.objs[key]).find("option:selected").val();
                    break;
                case "textarea":
                    v = $(this.objs[key]).html();
                    break;
                case "div":
                    v = $(this.objs[key]).html();
                    break;
                default:
                    v = $(this.objs[key]).val();
            }

            //更新数据
            this.data[key] = v;
        }
    }

    //添加键值对
    this.set = function (key, value, obj) {
        //如键不存在则身【键】数组添加键名
        if (this.data[key] == null) {
            this.keys.push(key);
        }
        this.data[key] = value;//给键赋值
        this.objs[key] = obj;
    };

    //获取键对应的值
    this.get = function (key) {
        return { data: this.data[key], objs: this.objs[key] };
    };

    //去除键值，(去除键数据中的键名及对应的值)
    this.remove = function (key) {
        this.keys.remove(key);
        this.data[key] = null;
        this.objs[key] = null;
    };

    //判断键值元素是否为空
    this.isEmpty = function () {
        return this.keys.length == 0;
    };

    //获取键值元素大小
    this.size = function () {
        return this.keys.length;
    };
}