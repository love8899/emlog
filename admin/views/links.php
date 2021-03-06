<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_taxis'])): ?><div class="alert alert-success">排序更新成功</div><?php endif; ?>
    <?php if (isset($_GET['active_del'])): ?><div class="alert alert-success">删除成功</div><?php endif; ?>
    <?php if (isset($_GET['active_edit'])): ?><div class="alert alert-success">修改成功</div><?php endif; ?>
    <?php if (isset($_GET['active_add'])): ?><div class="alert alert-success">添加成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger">站点名称和地址不能为空</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?><div class="alert alert-danger">没有可排序的链接</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">链接管理</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-edit"></i> 新建链接</a>
    </div>
    <p class="mb-4">友情链接管理，可以在侧边栏管理中将该处添加的链接展示在首页侧边栏。</p>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">已创建的链接</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>排序</th>
                        <th>链接</th>
                        <th>描述</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($links):
                        foreach ($links as $key => $value):
                            doAction('adm_link_display');
                            ?>
                            <tr>
                                <td><input class="form-control em-small" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4"/></td>
                                <td><a href="<?php echo $value['siteurl']; ?>" target="_blank"><?php echo $value['sitename']; ?></a></td>
                                <td><?php echo $value['description']; ?></td>
                                <td>
                                    <?php if ($value['hide'] == 'n'): ?>
                                        <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="点击隐藏链接">显示</a>
                                    <?php else: ?>
                                        <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="点击显示链接" style="color:red;">隐藏</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#editModal"
                                       data-linkid="<?php echo $value['id']; ?>"
                                       data-sitename="<?php echo $value['sitename']; ?>"
                                       data-siteurl="<?php echo $value['siteurl']; ?>"
                                       data-description="<?php echo $value['description']; ?>">编辑
                                    </a>
                                    <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; else:?>
                        <tr>
                            <td class="tdcenter" colspan="6">还没有添加链接</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="list_footer">
            <input type="submit" value="改变排序" class="btn btn-success"/>
        </div>
    </form>
    <!--添加链接弹窗-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新建链接</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="link.php?action=addlink" method="post" name="link" id="link">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="alias">名称</label>
                            <input class="form-control" id="sitename" name="sitename">
                        </div>
                        <div class="form-group">
                            <label for="template">地址</label>
                            <input class="form-control" id="siteurl" name="siteurl">
                        </div>
                        <div class="form-group">
                            <label for="alias">描述</label>
                            <textarea name="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-success">保存</button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--编辑链接弹窗-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">编辑链接</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="link.php?action=update_link" method="post" name="link" id="link">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="alias">名称</label>
                            <input class="form-control" id="sitename" name="sitename">
                        </div>
                        <div class="form-group">
                            <label for="template">地址</label>
                            <input class="form-control" id="siteurl" name="siteurl">
                        </div>
                        <div class="form-group">
                            <label for="alias">描述</label>
                            <textarea name="description" id="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" name="linkid" id="linkid" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-success">保存</button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    $("#menu_link").addClass('active');
    setTimeout(hideActived, 3600);
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var linkid = button.data('linkid')
        var sitename = button.data('sitename')
        var siteurl = button.data('siteurl')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #sitename').val(sitename)
        modal.find('.modal-body #siteurl').val(siteurl)
        modal.find('.modal-body #description').val(description)
        modal.find('.modal-footer #linkid').val(linkid)
    })
</script>
