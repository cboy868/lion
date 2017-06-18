<?php
$this->title="维护费";

?>
<div class="content">
    <div class="weui-cells">

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">墓位</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="select2">
                    <option value="1">墓位一</option>
                    <option value="2">墓位二</option>
                    <option value="3">墓位三</option>
                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">续费时长</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="select2">
                    <option value="1">1期(20年)</option>
                    <option value="2">2期(40年)</option>
                    <option value="3">3期(60年)</option>
                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">费用</label>
            </div>
            <div class="weui-cell__bd">
                <input type="text" disabled="disabled" class="weui-input" value="2000">
            </div>
        </div>

        <div class="weui-btn-area">
            <a href="javascript:;" class="weui-btn weui-btn_primary">确定付款</a>
        </div>

    </div>

</div>