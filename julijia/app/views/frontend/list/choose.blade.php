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
?>
<div class="banner_list">
    <!-- 菜单分类 -->
    <div class="area_shu">
        <p><a href="{{url('/')}}">首页</a><span>&gt;</span><a href="{{url($url).'.html'}}">{{$categoryName}}</a></p>
    </div>
    <div class="house-list01">
        <div class="m-area">
            <div id="topsearch">
                @if( count($brand) )
                <div class="detail-option">
                    <div class="option_b">品牌：</div>
                    <ul class="nav_all">
                        @foreach( $brand as $b )
                            @if( isset($b->screenCategoryToBrand->name))
                            <li class="brand"><a title="{{$b->screenCategoryToBrand->name}}" @if( isset($screen['url']) ) href="{{ getScreenUrl( $strUrl, 'p', $b->brand_id ) }}" @else href="{{ getScreenUrl( '', 'p', $b->brand_id )}}" @endif>{{$b->screenCategoryToBrand->name}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="option_mroe"><a href="Javascript:void(0)">更多<font>&gt;</font></a></div>
                </div>
                @endif
                @foreach( $screen['data'] as  $sc )
                <div class="detail-option">
                    <div class="option_b">{{$sc->name}}：</div>
                    <ul class="nav_all">
                        @foreach( $sc->value as $v )
                        <li class="{{$v->tilte}}"><a title="{{$v->value}}" href="{{ getScreenUrl( $strUrl, $v->tilte, $v->value ) }}">{{$v->value}}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            @if( count($selected) )
            <div id="restoirn">
                <div class="detail_xz">
                    <div class="option_ddd">已筛选</div>
                    <ul class="nav_all">
                        @foreach( $selected as $check )
                        <li>{{urldecode($check->title)}}<a href="{{$check->url}}" title="{{urldecode($check->title)}}"></a></li>
                        @endforeach
                    </ul>
                    <div class="option_xx"><a href="{{getScreenUrl( $screen['url'], false, false )}}">清空筛选</a></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>