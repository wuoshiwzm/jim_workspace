<?php
    $newUrl = $_SERVER["QUERY_STRING"];
    if( $newUrl )
    {
        $strUrl = $newUrl;
        if( strrpos($newUrl,'page=') )
        {
            if( substr( $newUrl,0,strrpos($newUrl,'page=')) == false )
            {
                $page = Input::get('page')?'&page='.Input::get('page'):'';
                $strUrl = $screen['url'].$page;
            }
        }
    }else
    {
        $page = Input::get('page')?'&page='.Input::get('page'):'';
        $strUrl = $screen['url'].$page;
    }

    $price = Input::get('sort_price');
    if( $price == 'desc' )
    {
        $pv = 'asc';
    }else
    {
        $pv = 'desc';
    }
?>
<div class="chanpin_left">
    <div class="chanpin_left_pai">
        <ul class="order-list">
            <li @if(Input::get('tuijian'))  class="active" @endif >
                <a @if( isset($screen['url']) ) href="{{ getScreenUrl( $strUrl, 'tuijian', Input::get('tuijian')?0:1 ) }}" @else href="{{ getScreenUrl( '', 'tuijian', Input::get('tuijian')?0:1 )}}" @endif>推荐</a>
            </li>
            <li @if(Input::get('created_at'))  class="active" @endif>
                <a @if( isset($screen['url']) ) href="{{ getScreenUrl( $strUrl, 'created_at', Input::get('created_at')?'asc':'desc') }}" @else href="{{ getScreenUrl( '', 'created_at', Input::get('created_at')?'asc':'desc')}}" @endif>新品</a>
            </li>
            <li>
                <a @if( isset($screen['url']) ) href="{{ getScreenUrl( $strUrl, 'sort_price', $pv ) }}" @else href="{{ getScreenUrl( '', 'sort_price', $pv )}}" @endif>价格
                    @if( $price == false )
                        <em class="bus11"></em>
                    @elseif( $price == 'desc' )
                        <em class="bus2"></em>
                    @elseif( $price == 'asc' )
                        <em class="bus22"></em>
                    @endif
                </a>
            </li>
        </ul>
    </div>
    <div class="chanpin_left_pin">
        <ul>
            @foreach( $data as $row )
                <li>
                    <dl>
                        <dt><a href="{{url($row->entity_id.'.html')}}"  target="_blank"  title="{{$row->name}}" ><img src="{{ getImgSize( 'goods', $row->entity_id, $row->small_image,210,210 ) }}"></a></dt>
                        <dd class="qiang_div_a"><a href="{{url($row->entity_id.'.html')}}"  target="_blank"  title="{{$row->name}}" >{{$row->name}}</a></dd>
                        <dd class="qiang_div_jia">
                            <font>¥</font>
                            @if( (int)$row->preferential_price )
                                {{$row->preferential_price}}
                                <em>¥{{$row->price}}</em>
                            @else
                                {{$row->price}}
                            @endif
                            <a href="{{url($row->entity_id.'.html')}}" class="shop_car">加入购物车</a></dd>
                        <dd class="qiang_div_add"><a href="javascript:;" data-id="{{encode($row->entity_id)}}" @if( Session::get('member') ) class="love keepYes" @else class="love keepNo" @endif>喜欢</a></dd>
                    </dl>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- 分页 -->
    @if( $data->getTotal()  )
        <div id="pagination">
            {{$data->appends(setUrlToArray(Request::getQueryString()))->links()}}
            <div class="pagination-info">
                共<font>{{$data->getTotal()}}</font>条
            </div>
        </div>
    @endif
    @if( count($data) == false )
        <div class="chanpin_left_pin">
            <dl class="no_b">
                <dt>抱歉，没有找到相关的商品</dt>
                <dd>建议您：</dd>
                <dd>1、适当减少筛选条件</dd>
                <dd>2、调整价格区间</dd>
                <dd>3、尝试其他关键字</dd>
                <dd><a href="javascript:history.back(-1);">返回上一步操作</a></dd>
            </dl>
        </div>
    @endif
</div>