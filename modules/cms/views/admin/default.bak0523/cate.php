<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <a href="/admin/news/category/create.html" class="btn btn-default btn-sm modalAddButton" title="添加分类" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus fa-2x"></i> 添加分类</a>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div id="modalAdd" class="fade modal" role="dialog" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        添增
                    </div>
                    <div class="modal-body">
                        <div id="modalContent"></div>
                    </div>

                </div>
            </div>
        </div>

        <div id="modalEdit" class="fade modal" role="dialog" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        编辑
                    </div>
                    <div class="modal-body">
                        <div id="editContent"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover treetable" id="menu-table">
                    <thead>
                    <tr>
                        <th>分类</th>
                        <th width="120">创建时间</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr data-tt-id="1" data-tt-parent-id="0" class="leaf collapsed">
                        <td><span class="indenter" style="padding-left: 0px;"></span><img src="/upload/static/images/36x36@default.png" width="36" height="36">专题</td>
                        <td>2017/04/26</td>
                        <td>
                            <a class="btn btn-info btn-xs  modalEditButton" href="/admin/news/category/update.html?id=1" title="更新" data-loading-text="页面加载中, 请稍后..." onclick="return false">编辑</a>
                            <a class="btn btn-danger btn-xs delete" href="/admin/news/category/delete.html?id=1" data-confirm="确定要删除此菜单吗?" data-method="post">删除</a>                            </td>
                    </tr>
                    <tr data-tt-id="2" data-tt-parent-id="0" class="branch collapsed">
                        <td><span class="indenter" style="padding-left: 0px;"><a href="#" title="Expand">&nbsp;</a></span><img src="/upload/static/images/36x36@default.png" width="36" height="36">客户服务 </td>
                        <td>2017/04/26</td>
                        <td>
                            <a class="btn btn-info btn-xs  modalEditButton" href="/admin/news/category/update.html?id=2" title="更新" data-loading-text="页面加载中, 请稍后..." onclick="return false">编辑</a>
                            <a class="btn btn-danger btn-xs delete" href="/admin/news/category/delete.html?id=2" data-confirm="确定要删除此菜单吗?" data-method="post">删除</a>                            </td>
                    </tr>
                    <tr data-tt-id="5" data-tt-parent-id="2" class="leaf collapsed" style="display: none;">
                        <td><span class="indenter" style="padding-left: 19px;"></span><img src="/upload/static/images/36x36@default.png" width="36" height="36">测试</td>
                        <td>2017/05/17</td>
                        <td>
                            <a class="btn btn-info btn-xs  modalEditButton" href="/admin/news/category/update.html?id=5" title="更新" data-loading-text="页面加载中, 请稍后..." onclick="return false">编辑</a>
                            <a class="btn btn-danger btn-xs delete" href="/admin/news/category/delete.html?id=5" data-confirm="确定要删除此菜单吗?" data-method="post">删除</a>                            </td>
                    </tr>
                    <tr data-tt-id="3" data-tt-parent-id="0" class="leaf collapsed">
                        <td><span class="indenter" style="padding-left: 0px;"></span><img src="/upload/static/images/36x36@default.png" width="36" height="36">交流活动</td>
                        <td>2017/04/26</td>
                        <td>
                            <a class="btn btn-info btn-xs  modalEditButton" href="/admin/news/category/update.html?id=3" title="更新" data-loading-text="页面加载中, 请稍后..." onclick="return false">编辑</a>
                            <a class="btn btn-danger btn-xs delete" href="/admin/news/category/delete.html?id=3" data-confirm="确定要删除此菜单吗?" data-method="post">删除</a>                            </td>
                    </tr>
                    <tr data-tt-id="4" data-tt-parent-id="0" class="leaf collapsed">
                        <td><span class="indenter" style="padding-left: 0px;"></span><img src="/upload/static/images/36x36@default.png" width="36" height="36">媒体聚焦</td>
                        <td>2017/05/08</td>
                        <td>
                            <a class="btn btn-info btn-xs  modalEditButton" href="/admin/news/category/update.html?id=4" title="更新" data-loading-text="页面加载中, 请稍后..." onclick="return false">编辑</a>
                            <a class="btn btn-danger btn-xs delete" href="/admin/news/category/delete.html?id=4" data-confirm="确定要删除此菜单吗?" data-method="post">删除</a>                            </td>
                    </tr>
                    </tbody>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>