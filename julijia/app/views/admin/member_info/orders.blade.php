@section('content')

    <div class="page">
        <div class="fixed-bar">
            <div class="item-title item-title02">
                <div class="subject">
                    <h3>
                        <span class="action"> 会员 - 详情</span>
                    </h3>
                    @include('admin.member_info.view.tab')
                </div>
            </div>
        </div>

        <div class="common-title">
            <div class="ftitle">
                <h3> 订 单 </h3>
                <h5>
                    (&nbsp;共
                    <span data - total - record="true"> {{$data->getTotal()}}</span>
                    条记录 &nbsp;)
                </h5>

            </div>
            <div class="operate">
                <a class="reload" href="javascript:reload();" data - toggle="tooltip" data - placement="auto bottom"
                   title="" data - original - title="刷新数据">
                    <i class="iconfont">&#xe6fb;</i>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table_list" class="table table-hover">
                <thead>
                <tr>
                    <!--排序样式sort默认，asc升序，desc降序-->
                    <th class="w250" style="cursor: pointer;"> 订单编号</th>
                    <th class="w250" style="cursor: pointer;"> 下单时间</th>
                    <th class="w250" style="cursor: pointer;"> 支付时间</th>
                    <th class="w150" style="cursor: pointer;"> 订单来源</th>
                    <th class="w250" style="cursor: pointer;"> 订单状态</th>
                    <th class="w150" style="cursor: pointer;"> 金 额</th>
                    <th class="w150 handle " style="cursor: pointer;"> 操 作</th>
                </tr>
                </thead>
                <tbody>
                <!--以下为循环内容-->
                @foreach($data as $orders)
                    <tr>
                        <td>
                            {{$orders->order_sn}}
                        </td>
                        <td>
                            {{$orders->created_at}}
                        </td>
                        <td>
                            {{$orders->payment_time}}
                        </td>
                        <td> PC站</td>
                        <td>
                            <?php
                            switch ($orders->status) {
                                case(1):
                                    echo '1待付款';
                                    break;
                                case(2):
                                    echo '已取消';
                                    break;
                                case(3):
                                    echo '无效';
                                    break;
                                case(4):
                                    echo '待发货';
                                    break;
                                case(5):
                                    echo '待收货';
                                    break;
                                case(6):
                                    echo '部分完成';
                                    break;
                                case(7):
                                    echo '完成';
                                    break;
                                case(8):
                                    echo '退款退货';
                                    break;
                                case(9):
                                    echo '退款完成';
                                    break;
                            }
                            ?>


                        </td>
                        <td>
                            {{$orders->total_amount}}
                        </td>
                        <td class="handle">

                            <a href="{{url('admin/order/detail?order_id='.$orders->id)}}"> 查看详情</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


                @include('admin.public.page',array('data'=>$data,'set'=>$set))



        </div>

    </div>

@stop