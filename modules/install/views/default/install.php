<script type="text/javascript">
  function showmessage(message) {
      var notice = document.getElementById('notice');
      notice.innerHTML += message + '<br />';
      boxScroll(notice);
    }

  function boxScroll(o){
      o.scrollTop = o.scrollHeight;
  }



</script>

<div class="row well" style="margin:auto 0;">
    <div class="col-xs-3">
        <div class="progress" title="安装进度">
            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
                 aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                80%
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                安装步骤
            </div>
            <ul class="list-group">
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-copyright-mark"></span> &nbsp; 许可协议</a>
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-eye-open"></span> &nbsp; 环境监测</a>
                <a href="javascript:;" class="list-group-item list-group-item-success">
                    <span class="glyphicon glyphicon-cog"></span> &nbsp; 参数配置</a>
                <a href="javascript:;" class="list-group-item list-group-item-info">
                    <span class="glyphicon glyphicon-inbox"></span> &nbsp; 安装</a>
                <a href="javascript:;" class="list-group-item">
                    <span class="glyphicon glyphicon-ok"></span> &nbsp; 成功</a>
            </ul>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="panel panel-default">
            <div class="panel-heading">程序安装</div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="db-box" id="notice" style="height: 300px;overflow-y: auto;">
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer text-center">
                <div class="text-info">正在安装:<span id="msg" class="text-danger"></span></div>
            </div>
        </div>
    </div>
</div>


