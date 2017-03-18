@section('title')去结算@stop
@section('categoryCss','banner_nav02')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('css/frontend/order.css?v='.Config::get('tools.frontendCssTime'))}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/frontend/layui.css?v='.Config::get('tools.frontendCssTime'))}}">
@stop
@section('content')
    <div class="shopping">
        <div class="shopping_nei">
            <div class="shopping_nei_order">
                @if(count($goods))
                    @include('frontend.order.orderstyle')
                    <form class="layui-form" action="{{url('confirmorder/save')}}" method="post">
                        <!--收货人-->
                        @include('frontend.order.orderaddress',array('address'=>$address))
                        <!--支付方式-->
                        @include('frontend.order.paytype')
                        <!--送货清单-->
                        @include('frontend.order.confirmgoods',array('address'=>$address,'goods'=>$goods,'totaled'=>$totaled,'order'=>$order))
                    </form>
                 @else
                    <div class="table_div" style="height: 400px">
                        <div class="order-step02">
                            <dl class="current" style="align-content: center;width: 550px !important;">
                               <p>对不起没有订单数据</p>
                            </dl>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script type="text/javascript" src="{{url('js/public/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{url('js/public/layui/layui.js')}}"></script>
    @if(count($goods))
     <script type="text/javascript" src="{{url('js/frontend/order.js?v='.Config::get('tools.frontendJsTime'))}}"></script>
    @endif
@stop