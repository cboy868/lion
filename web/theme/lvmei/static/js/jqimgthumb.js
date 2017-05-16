(function ($) {
    $.fn.extend({
        resizeImg: function (opt, callback) {
            var defaults = {
                    w: 200,
                    h: 150
                },
                opts = $.extend(defaults, opt);
            //获取图片实际宽高，此方法摘自网络
            var getImgWh = function (url, callback) {
                var width, height, intervalId, check, div, img = new Image(),
                    body = document.body;
                img.src = url;
                //从缓存中读取
                if (img.complete) {
                    return callback(img.width, img.height);
                }
                ;
                //通过占位提前获取图片头部数据
                if (body) {
                    div = document.createElement('div');
                    div.style.cssText = 'visibility:hidden;position:absolute;left:0;top:0;width:1px;height:1px;overflow:hidden';
                    div.appendChild(img)
                    body.appendChild(div);
                    width = img.offsetWidth;
                    height = img.offsetHeight;
                    check = function () {
                        if (img.offsetWidth !== width || img.offsetHeight !== height) {
                            clearInterval(intervalId);
                            callback(img.offsetWidth, img.clientHeight);
                            img.onload = null;
                            div.innerHTML = '';
                            div.parentNode.removeChild(div);
                        }
                        ;
                    };
                    intervalId = setInterval(check, 150);
                }
                ;
                // 加载完毕后方式获取
                img.onload = function () {
                    callback(img.width, img.height);
                    img.onload = img.onerror = null;
                    clearInterval(intervalId);
                    body && img.parentNode.removeChild(img);
                };
            };
            this.each(function () {
                var _this = this;
                getImgWh(this.src, function (imgWidth, imgHeight) {
                    //计算图片最大宽度
                    if (imgWidth > opts["w"]) {
                        _this.width = opts["w"];
                        _this.height = imgHeight * (opts["w"] / imgWidth);
                        imgWidth = opts["w"];
                        imgHeight = _this.height;
                    }
                    //计算图片最大高度
                    if (imgHeight > opts["h"]) {
                        _this.height = opts["h"];
                        _this.width = imgWidth * (opts["h"] / imgHeight);
                        imgHeight = opts["h"];
                        imgWidth = _this.width;
                    }
                    //水平居中，垂直居中
                    $(_this).css({
                        "margin-top": (opts["h"] - imgHeight) / 2,
                        //"margin-left": (opts["w"] - imgWidth) / 2，
						"visibility":"visible"
                    });
                });
            });
        }
    });
})(jQuery); 