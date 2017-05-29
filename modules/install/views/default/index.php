<?php 
use app\core\helpers\Url;
$this->title = "Lion 信息管理系统安装"
?>
<div class="row well" style="margin:auto 0;">
<div class="col-xs-3">
    <div class="progress" title="安装进度">
        <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
            20%
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            安装步骤
        </div>
        <ul class="list-group">
            <a href="javascript:;" class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-copyright-mark"></span> &nbsp; 许可协议</a>
            <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-eye-open"></span> &nbsp; 环境监测</a>
            <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-cog"></span> &nbsp; 参数配置</a>
            <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> &nbsp; 安装</a>
            <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> &nbsp; 成功</a>
        </ul>
    </div>
</div>
<div class="col-xs-9">
    <div class="panel panel-default">
        <div class="panel-heading">阅读许可协议</div>
        <div class="panel-body" style="overflow-y:scroll;max-height:400px;line-height:20px;">
            <h3>版权所有 (c)2017，卓迅网络。 </h3>
            <p>
                感谢您选择卓迅 - 专为公墓行业准备的网络办公、营销系统（本系统基于 PHP + MySQL的技术开发)。 <br>
                希望我们的努力能为您提供一个高效、有力的网络信息管理解决方案。
            </p>
            <p>
                <strong>
                    一、本授权协议适用本系统任何版本。
                </strong>
            </p>
            <p>
                <strong>二、协议许可和约束 </strong>
            </p>
            <ol>
                <li>非商业版本可以任意复制传播使用</li>
                <li>商业版本禁止以任何形式转卖或扩散。</li>
                <li>您拥有使用本软件构建的系统全部内容所有权，并独立承担与这些内容的相关法律义务。</li>
                <li>获得商业授权之后，在授权时间段内,您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，
                    在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。
                    商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
            </ol>
            <p></p>

            <p>
                <strong>三、有限担保和免责声明 </strong>
            </p><ol>
                <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
                <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、
                    使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
                <li>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装，
                    即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，
                    将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</li>

            </ol>
            <p></p>
            <p>
                <strong>四、其它 </strong>
            </p><ol>
                <li>本系统官方网站为 http://www.zhuo-xun.com。</li>
                <li>本程序模块化开发、安全稳定，后续扩展方便不会影响原有系统。。</li>
                <li>在开始前，我们需要您数据库的一些信息。请准备好如下信息。
                    <p>
                        数据库主机
                    </p>
                    <p>
                        数据库名
                    </p>
                    <p>
                        数据库用户名
                    </p>
                    <p>
                        数据库密码
                    </p>
                    好了 如果您同意此条款 请点同意按扭</li>
            </ol>
            <p></p>
        </div>
    </div>
    <ul class="pager">
        <li class="previous">
            <div class="panel-footer">
                <a href="<?=Url::toRoute(['env'])?>" class="btn btn-default">同 意<span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </li>
    </ul>
</div>
</div>

