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
                            <?php if (empty($subs)){ ?>
                                目前还没有提交的局站
                            <?php } else{ ?>
                            <thead>
                            <tr>
                                <th>局站id</th>
                                <th>局站名</th>

                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($subs as $sub) { ?>
                                <tr>
                                    <td><?php echo $sub->substation_id ?></td>
                                    <td><?php echo $this->mp_extra->Get_substation_info($sub->substation_id)->name ?></td>

                                    <td><a href="/check/editApply/<?php echo $sub->substation_id ?>">重新提交审核结果</a></td>
                                </tr>
                            <?php } ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row-fluid">
            <div class="span12">
                <div class="content-widgets">
                    <div class="widget-head bondi-blue">
                        <h3>设备验收提交</h3>
                    </div>

                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <?php if (empty($rooms)){ ?>
                                目前还没有需要验收的局站
                            <?php } else{ ?>
                            <thead>
                            <tr>
                                <th>机房id</th>
                                <th>机房名</th>
                                <th>所属局站</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rooms as $room) { ?>
                                <tr>
                                    <td><?php echo $room->room_id ?></td>
                                    <td><?php echo $this->mp_extra->Get_room_name($room->room_id)->name ?></td>

                                    <td><?php echo $this->mp_extra
                                            ->Get_substation_info($this->mp_extra->getSubstationByRoom($room->room_id)
                                                ->substation_id)->name ?></td>

                                    <td><a href="/check/editDevice/<?php echo $room->room_id?>">提交审核结果</a></td>
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