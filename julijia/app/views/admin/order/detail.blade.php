@section("title")
    订单详情
@stop

@section("admincss")
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/jquery.mCustomScrollbar.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/loaders.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/styles.css')}}">
@stop

@section("content")
    <div class="page">
        <div class="fixed-bar">
            <div class="item-title">
                <div class="subject">
                    <h3>
                        <span class="action">商品订单 - 订单详情</span>
                    </h3>

                    <h5>
				<span class="action-span">
					<a href="{{url("/admin/order/index")}}" class="btn btn-warning click-loading">
                        返回订单列表
                    </a>
				</span>
                    </h5>

                </div>
            </div>
        </div>

        <!--步骤-->
        <div class="order-step">
            <!--完成步骤为dl添加current样式，完成操作内容后会显示完成时间-->
            <dl class="current step-first">
                <dt>拍下商品</dt>
                <dd class="bg"></dd>
                <dd class="date" title="下单时间">{{$order->created_at}}</dd>
            </dl>
            <dl class="
                @if($order->pay_status == 3)
                    current
                @endif
             ">
                <dt>买家付款</dt>
                <dd class="bg"></dd>
                <dd class="date" title="买家付款时间">
                    @if($order->pay_status == 3)
                        {{$order->pay->payment_time}}
                    @endif
                </dd>
            </dl>
            <dl class="
                @if($order->status == 5  || $order->status == 7)
                    current
                @endif
            ">
                <dt >平台发货</dt>
                <dd class="bg"></dd>
                <dd class="date" title="平台发货时间" ></dd>
            </dl>

            <dl class="
                @if ($order->status == 7)
                    current
                @endif
            ">
                <dt>确认收货</dt>
                <dd class="bg"></dd>
                <dd class="date" title="确认收货时间"></dd>
            </dl>
        </div>

        <!--订单详情信息-->
        <div class="order-info m-b-10">
            <!--操作部分-->
            <div class="order-handle">
                <div class="order-operate">
                    <ul>
                        <li class="operate-steps">
                            <i class="iconfont"></i>
                            <span>
                                @if ($order->status == 1)
                                    当前订单状态：订单已确认，等待买家付款
                                @elseif($order->status == 2)
                                    订单已取消
                                @elseif($order->status == 3)
                                    无效订单
                                @elseif($order->status == 4)
                                    等待发货
                                @elseif($order->status == 5)
                                    已发货
                                @elseif($order->status == 6)
                                    部分已完成
                                @elseif($order->status == 7)
                                    已完成
                                @elseif($order->status == 3)
                                    订单关闭
                                @elseif($order->status == 8)
                                    退款申请中
                                @elseif($order->status == 10)
                                    退款中
                                @elseif($order->status == 9)
                                    退款完成
                                @endif
                            </span>
                        </li>
                        <!-- 待付款 -->
                        @if($order->status == 1)
                            <li class="operate-prompt">
                                <p>
                                    买家还有<span id="time"></span>来付款，超时订单自动关闭
                                </p>
                                <p>
                                    如果商品被恶意拍下了，您可以关闭订单
                                </p>
                                <br>
                                <input value="修改价格" class="btn btn-primary modify" type="button">
                                <input value="订单关闭（删除）" class="btn btn-primary dele_dd" type="button">
                            </li>
                        @endif

                    </ul>
                    <input type="hidden" id="order_id" value="{{$order->id}}">
                </div>
            </div>
            <!--下单时间等-->

            <div class="order-infor">
                <h3>订单来源 :
                    @if($order->source == 1)
                        pc
                    @elseif($order->source == 2)
                        wap
                    @endif
                    端</h3>
                <div class="order-infor-center">
                    <dl>
                        <dt>
                            <span>订单编号：</span>
                        </dt>
                        <dd>
                            <span>{{$order->order_sn}}</span>
                        </dd>
                    </dl>

                    <dl>
                        <dt>
                            <span>下单时间：</span>
                        </dt>
                        <dd>
                            <span>{{$order->created_at}}</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>
                            <span>买家付款：</span>
                        </dt>
                        <dd>
                            <span>
                            @if($order->pay_status == 3)
                                    {{$order->pay->payment_time}}
                            @endif
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
            <!--订单信息-->
            <div class="order-details">
                <div class="title">订单信息</div>
                <div class="content">
                    <dl>
                        <dt>&nbsp;收&nbsp;货&nbsp;人：</dt>
                        <dd>{{$order->ship_name}}，{{$order->ship_phone}}，{{$order->ship_addr}}</dd>
                    </dl>
                    <dl>
                        <dt>支付方式：</dt>
                        <dd>@if($order->payment == 1)
                                支付宝
                            @elseif($order->payment == 2)
                                微信
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <!--商品信息-->
        <div class="table-responsive deliver">
            <table class="table">
                <colgroup>
                    <!--商品信息-->
                    <col class="w200">

                    <!--属性-->
                    <col class="w100">

                    <!--单价（元）-->
                    <col class="w50">

                    <!--产品店铺-->
                    <col class="w100">

                    <!--数量-->
                    <col class="w50">

                    <!--商品总价-->
                    <col class="w60">

                    <!--库存-->
                    <col class="w70">

                    <!--状态-->
                    <col class="w70">

                    <!--优惠-->
                    <col class="w50">
                    <col class="w150">

                </colgroup>
                <thead>
                <tr>
                    <th>商品</th>
                    <th>属性</th>
                    <th>单价（元）</th>
                    <th>产品店铺</th>
                    <th>数量</th>
                    <th>商品总价</th>
                    <th>库存</th>
                    <th>状态</th>
                    <th>优惠</th>
                    <th>留言</th>
                </tr>
                </thead>
                <tbody>
                <!--订单内容-->
                @foreach($order->item()->get() as $row)
                    <tr class="order-item">
                        <td class="item">
                            <div class="pic-info">
                                <a href="/{{$row->product_id}}.html" class="goods-thumb" title="{{$row->product_name}}" target="_blank">
                                    <img src="{{ getImgSize( 'goods', $row->product_id, isset($row->product->small_image)?$row->product->small_image:'' ) }}" alt="{{$row->product_name}}">
                                </a>
                            </div>
                            <div class="txt-info">
                                <div class="desc">
                                    <a class="goods-name" href="/{{$row->product_id}}.html" target="_blank" title="{{$row->product_name}}">
                                        {{$row->product_name}}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="order-type">
                            <?php $guise = $row->guige;?>
                            @if($guise &&!empty($guise))
                                    <div class="ng-binding order-type-info" >
                                        @foreach(json_decode($guise) as $key =>$value)
                                            <span>{{$key}}：{{$value}}</span>
                                        @endforeach
                                    </div>
                             @else
                                {{$guise}}
                            @endif
                        </td>
                        <td class="price">￥{{$row->price}}</td>
                        <td class="service">{{isset($row->Supplier->supplier_name)?$row->Supplier->supplier_name:''}}</td>
                        <td class="num">{{$row->num}}</td>
                        <td class="price">￥{{$row->row_total}}</td>
                        <td class="stock">{{isset($row->productstock->stock)?$row->productstock->stock:0}}</td>
                        <td class="state">
                            @if($row->shipping_status ==1 && $row->refund->count())
                                <a href="/admin/refund/index">已退款</a><br>
                            @endif
                            @if($row->shipping_status ==3 && $row->refund->count())
                                <a href="/admin/refund/index">已退货</a><br>
                            @endif
                            @if($row->shipping_status ==1 )
                                未发货
                            @elseif($row->shipping_status ==2 )
                                运输中  <br>
                                <a href="{{url("/admin/order/ems?".http_build_query(["l_id" =>$row->shipping_id,'item_id'=>$row->id]))}}". class="yundan"><font>运单</font>{{$row->shipping_id}}</a>
                                <br>
                            @elseif($row->shipping_status ==3 )
                                已收货
                            @endif
                        </td>
                        <td class="order-discount">
                            ￥{{isset($row->favoutable->amount)?$row->favoutable->amount:0}}
                        </td>
                        <td class="order-discount">
                            {{isset($row->desc)?$row->desc:0}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="messageBox tfoot-info  m-b-10">
            <div class="address-info text-r">
                <p class="m-b-5">
                    <span>商品总金额：￥{{$order->cost_item}}</span>
                    <em class="operator">-</em>
                    <span>优惠：￥{{$order->cost_freight}}</span>
                    <em class="operator">+</em>
                    <span>配送费用：￥{{$order->shipping_amount}}</span>
                    <em class="operator">=</em>
				<span>
					<strong>订单总金额：￥{{$order->pay_amount}}</strong>
				</span>
                </p>
            </div>
        </div>
        <div class="order-info m-b-10">
            <!--操作日志-->
            <div class="order-details">
                <div class="title">操作日志</div>
                <div class="content">
                    @foreach( $order->OrderAction()->orderBy('id','desc')->get() as $val)
                        <dl>
                            <dt>{{$val->option_name}}:</dt>
                            <dd><span>{{TimeTools::getYMd($val->created_at)}}</span> {{$val->remark}}</dd>
                        </dl>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop

@section("footer_js")
    {{--<script type="text/javascript" src="{{url('js/admin/d_tan.js')}}"></script>--}}
    <script type="text/javascript" src="{{url('js/public/layer/layer.js')}}"></script>
    @if($order->status == 1)
        <script type="text/javascript" src="{{url('js/admin/order/detail.js')}}"></script>
        <script>
             var time = {{$order->diffTime}}
             setInterval(function(){
                 getFormatTime(parseInt(time));
                 time--;
             },1000);

             //把时间戳转成x天x小时x分x秒
             /**
              * @param  string time 时间戳
              */
            function getFormatTime(time){
                 var day = 0;
                 var hour = 0;
                 var minute = 0;
                 var f_time = time;

                 if (f_time >= 86400){
                     day = Math.floor(f_time/86400);
                     f_time = f_time%86400;
                 }
                 if (f_time >= 3600) {
                     hour = Math.floor(f_time/3600);
                     f_time = f_time%3600;
                 }
                 if (f_time >= 60) {
                     minute =  Math.floor(f_time/60);
                     f_time = f_time%60;
                 }
                 var second =  f_time;
                 var time_format = "";
                 if (day != 0 ){
                     time_format += + day +"天";
                 }
                 if (hour != 0) {
                    time_format += + hour +"小时";
                 }
                 if (minute != 0) {
                     time_format += + minute +"分钟";
                 }
                 time_format += + second +"秒";
                 $("#time").text(time_format);
            }
        </script>
    @endif
@stop