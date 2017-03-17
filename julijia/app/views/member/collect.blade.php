@section('title')
    全部收藏
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/member/layui.css')}}">
@stop

@section('left')
    @include('member.public.left_center')
@stop

@section(('content'))
    <div class="ge_admin_nei_right">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>

        <div class="table_div_h">
            <h2>我的收藏</h2>
        </div>
        <!--订单切换-->
        <div class="table_div">
            @include('member.public.collect_nav')
            <div class="table_div_hd table_div_hd_table">

                <div class="soucang">
                    @foreach($collects as $collect)
                        @if($collect->is_show)
                            <dl>
                                <dt><a href="/{{$collect->entity_id}}.html">
                                        <img src="{{ getImgSize( 'goods', $collect->entity_id, $collect->product->small_image ) }}"/>
                                    </a>
                                </dt>
                                <dd class="c_dd">
                                    <a href="##">{{$collect->product->name}}</a></dd>
                                @if(!$collect->is_show)
                                    <dd class="c_can">
                                        <font class="font01 ">
                                            <span class="iconfont">&#xe602;</span>
                                            已失效</font>
                                    </dd>
                                @else
                                    @if(time()<strtotime($collect->product->price_end) && time()>strtotime($collect->product->price_start))
                                        <span>
                                                <font class="font01">￥{{$collect->product->preferential_price}}</font><br>
                                                <font class="font02">￥{{$collect->product->price}}</font></span>
                                    @else
                                        {{--不在优惠期内， 使用 price 普通 价格--}}
                                        <span><font class="font02">￥{{$collect->product->price}}</font></span>
                                    @endif

                                @endif
                            </dl>
                        @else
                            <dl>
                                <dt><a onclick="unShow()">
                                        <img src="{{ getImgSize( 'goods', $collect->entity_id, $collect->product->small_image ) }}"/>
                                    </a>
                                </dt>
                                <dd class="c_dd">
                                    <a href="##">{{$collect->entity_name}}</a></dd>
                            </dl>
                        @endif
                    @endforeach
                </div>
                <div id="paging">
                    @include('member.public.page',array('data'=>$collects,'set'=>$set))
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        function unShow() {
            layer.alert('此商品已经下架！');
        }
    </script>
@stop