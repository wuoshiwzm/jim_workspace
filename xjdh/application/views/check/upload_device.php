<div class="main-wrapper">
    <div class="container-fluid">
        <div class="row-fluid ">
            <div class="span12">
                <div class="primary-head">
                    <h3 class="page-header">管理面板</h3>
                    <ul class="breadcrumb">
                        <li><a class="icon-home" href="/"></a> <span class="divider"><i
                                        class="icon-angle-right"></i></span></li>
                        <?php foreach ($bcList as $bcObj) { ?>
                            <?php if ($bcObj->isLast) { ?>
                                <li class="active"><?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?></li>
                            <?php } else { ?>
                                <li>
                                    <a href='<?php echo htmlentities($bcObj->url, ENT_COMPAT, "UTF-8"); ?>'><?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?></a>
                                    <span class="divider"><i class="icon-angle-right"></i></span></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="content-widgets">
                    <div class="widget-head bondi-blue">
                        <h3>工艺验收提交</h3>
                    </div>
                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <?php if (empty($questions)){ ?>
                                目前还没有需要验收的问题
                            <?php } else{ ?>
                            <thead>
                            <tr>
                                <th width="8%">问题id</th>
                                <th width="15%">设备类型</th>
                                <th>包含设备</th>
                                <th>实时数据页面（截图）</th>
                                <th width="9%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($questions as $question) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i;
                                        $i++; ?>
                                    </td>
                                    <td>
                                        <?php echo $question->name ?>
                                    </td>
                                    <td>
                                        <?php foreach ($question->devList as $dev) { ?>
                                            <span class="label label-success">
                                                <?php echo $this->mp_extra->get_device_name($dev->data_id); ?>
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <!--                                        跳转实时数据页面-->
                                        <a href="/portal/realtimedata/<?php echo $roomID . '/' . $question->type ?>"
                                           target="_blank">实时数据页面</a>
                                    </td>
                                    <td>
                                        <button class="uploadImg" onclick="newWindow('<?php echo $question->type ?>')">
                                            上传验收图片
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
    function newWindow($questionID) {

        layer.open({
            type: 2,
            title: '上传验收图片',
            shadeClose: true,
            shade: 0.8,
            area: ['55%', '65%'],
            content: '/check/upload_img/2/<?php echo $roomID?>/' + $questionID,
            btn: ['关闭'],
            btnclass: ['btn btn-primary', 'btn btn-danger'],
            yes: function () {
                window.parent.location.reload();
            }, cancel: function () {
                window.parent.location.reload();
            }
        });
    }
</script>