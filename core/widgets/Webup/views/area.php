<div id="wrapper">
    <div id="container">
        <!--头部，相册选择和格式选择-->

        <div id="uploader">
            <input type="hidden" class="res_name" value="<?=$options['res_name']?>">
            <input type="hidden" class="album_id" value="<?=$options['album_id']?>">
            <input type="hidden" class="mod" value="<?=$options['mod']?>">
            <input type="hidden" class="reload" value="<?=$options['reload']?>">
            <input type="hidden" class="server" value="<?=$options['server']?>">
            <div class="queueList">
                <div id="dndArea" class="placeholder">
                    <div id="filePicker"></div>
                    <!-- <p>或将照片拖到这里，单次最多可选300张</p> -->
                </div>
            </div>
            <div class="statusBar" style="display:none;">
                <div class="progress">
                    <span class="text">0%</span>
                    <span class="percentage"></span>
                </div><div class="info"></div>
                <div class="btns">
                    <div id="filePicker2"></div>
                    <div class="uploadBtn">开始上传</div>
                </div>
            </div>
        </div>
    </div>
</div>

