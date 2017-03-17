@include('frontend.public.seo',array('seo'=>$seo))
@section('categoryCss','banner_nav')
@section('content')
   <!--banner-->
   @include('frontend.index.banner',array('banner'=>$banner))
   <!--限时抢购-->
   @if(count($flashSale))
   @include('frontend.index.flashsale',array('flashSale'=>$flashSale))
   @endif

   <!--精品推荐-->
   @if(count($recommend))
   @include('frontend.index.recommend',array('recommend'=>$recommend))
   @endif

   <!--楼层数据-->
   @include('frontend.index.floor',array('floor'=>$floor))
@stop
@section('friendshiplink')
   @if( isset($link))
      @foreach( $link as $k)
      <li><p><a href="{{$k->url}}" target="_blank" title="{{$k->title}}">{{$k->title}}</a></p></li>
      @endforeach
   @endif
@stop
@section('footer_js')
   <script type="text/javascript" src="{{url('js/frontend/index.js?v='.Config::get('tools.frontendJsTime'))}}"></script>
@stop