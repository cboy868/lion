if (typeof LN == 'undefined') {LN = {}};
LN.insCanvas = function(id){
    var x,y,endX,endY;

    var history =new Array();
    var lIndex = 1;
    var cStep = -1;

    var customerX = 50;
    var customerY = 50;
    var defaultFontFamily = 'SimSun, sans-serif';
    var direction = 'v';

    var fontTip =$("<textarea rows='3' cols='20' style='background:transparent;position:absolute;display:none;'></textarea>");
    $("#container").append(fontTip);

    var flag = false;
    var ctx=$(id);

    drawTrash();
    var arr = [
        {
            word:'我们是中国人',
            x:20,
            y:30,
            fontSize:55,
            fontFamily:'STXinwei , sans-serif',
            direction:'v'
        },
        {
            word:'我们是中国人',
            x:80,
            y:30,
            fontSize:55,
            fontFamily:'Trebuchet MS, sans-serif',
            direction:'v'
        },
        {
            word:'哈哈我的国',
            x:120,
            y:30,
            fontSize:55,
            fontFamily:'Trebuchet MS, sans-serif',
            direction:'v'
        },
        {
            word:'轻轻的我走了，正如我轻轻的来',
            x:220,
            y:30,
            fontSize:55,
            fontFamily:'Trebuchet MS, sans-serif',
            direction:'v'
        }
    ];

    batchWords(arr);

    $('.words').click(function(e){
        var words = prompt("请输入文字");
        var size = $(this).data('size');
        if (!words) {return}
        lIndex++;
        writeWords(words, customerX, customerY, size, defaultFontFamily,direction, 'new'+lIndex);
    });

    $('.tools_trash').click(function(e){
        ctx.clearCanvas();
        ctx.removeLayers();
        drawTrash();
    });

    $('.tools_download').click(download);


    /**
     * 函数部分
     */
    //绘制垃圾桶
    function drawTrash(){
        ctx.drawImage({
            layer: true,
            source: '/static/libs/insCanvas/images/del.jpg',
            x: 560, y: 560,
            name:'del',
            width: 100,
            height: 100,
            fromCenter: false
        });
    }

    function removeTrash(){
        ctx.removeLayer('del').drawLayers();
    }

    function vAndH(word, direction) {
        if (direction == 'v') {
            return h2v(word);
        }
        if (direction == 'h') {
            return v2h(word);
        }
        if (word.indexOf('\n') >= 0) {
            return v2h(word);
        } else {
            return h2v(word);
        }

    }

    function v2h(word) {
        if (word.indexOf('\n') < 0)
            return word;
        return word.split('\n').join('');
    }

    function h2v(word) {
        if (word.indexOf('\n') >= 0)
            return word;
        return word.split('').join('\n');
    }

    function writeWords(words, x, y, fontSize, fontFamily,direction, lIndex) {
        var lineHeight = 1.1;
        var snapToAmount = 20;
        var height = direction == 'v' ? (parseInt(fontSize) * words.length * lineHeight)/2 : fontSize/2;

        var evtX = 0;
        var evtY = 0;

        ctx.drawText({
            name:'myText' + lIndex,
            fillStyle: '#555',
            strokeStyle: '#555',
            // strokeWidth: 2,
            x: x, y: y+height,
            fontSize: fontSize,
            fontFamily: fontFamily,
            text: vAndH(words, direction),
            draggable:true,
            respectAlign: true,
            align:'left',
            lineHeight: lineHeight,
            cursors: {
                mouseover: 'pointer',
                mousedown: 'pointer',
                mouseup: 'pointer'
            },
            mouseover:function(layer){
                $(this).animateLayer(layer, {
                    fillStyle: '#999'
                }, 100);
            },
            mouseout:function(layer){
                $(this).animateLayer(layer, {
                    fillStyle: '#555'
                }, 100);
            },
            mousedown:function(layer){
                evtX = layer.eventX;
                evtY = layer.eventY;

            },
            mouseup:function(layer){
                if (layer.eventX == evtX && layer.eventY == evtY) {
                    ctx.setLayer('myText'+lIndex, {
                        text: vAndH($('canvas').measureText('myText'+lIndex).text),
                    })
                        .drawLayers();
                }
            },
            dragstop:function(layer){
                if (layer.eventX > 560 && layer.eventY>560) {
                    ctx.removeLayer('myText'+lIndex);
                }
            },
            updateDragX: function (layer, x) {
                return nearest(x, snapToAmount);
            },
            updateDragY: function (layer, y) {
                return nearest(y, snapToAmount);
            }
        });
    }

    function nearest(value, n) {
        return Math.round(value / n) * n;
    }

    function batchWords(wordsArr)
    {
        for (i in wordsArr) {
            writeWords(wordsArr[i]['word'], wordsArr[i]['x'], wordsArr[i]['y'], wordsArr[i]['fontSize'], wordsArr[i]['fontFamily'],wordsArr[i]['direction'], i);
        }
    }

    function download()
    {
        removeTrash();
        exportCanvasAsPNG('ins');
        drawTrash();
    }

    function exportCanvasAsPNG(fileName) {
        var imgURL = ctx.getCanvasImage('png');
        var MIME_TYPE = "image/png";
        var dlLink = document.createElement('a');
        dlLink.download = fileName;
        dlLink.href = imgURL;
        dlLink.dataset.downloadurl = [MIME_TYPE, dlLink.download, dlLink.href].join(':');

        document.body.appendChild(dlLink);
        dlLink.click();
        document.body.removeChild(dlLink);
    }
}




$(function(){
    //LN.insCanvas('#myCanvas');
})
