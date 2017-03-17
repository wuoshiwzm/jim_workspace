@section('title','添加产品')
@section('admincss')
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/chosen.css').'?v='.Config::get('tools.adminJsTime')}}">
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/styles.css').'?v='.Config::get('tools.adminJsTime')}}">
@stop
@section('content')
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>
                    <span class="action">商品库管理 - 选择商品分类</span>
                </h3>
            </div>
        </div>
    </div>
    <div class="table-content m-t-15">
        <!--步骤-->
        <ul class="add-goods-step">
            <li id="step_1" class="current">
                <i class="fa iconfont step">&#xe728;</i>
                <h6>STEP.1</h6>
                <h2>选择商品分类</h2>
                <i class="fa fa-angle-right iconfont">&#xe657;</i>
            </li>
            <li id="step_2">
                <i class="fa fa-edit step iconfont" >&#xe68e;</i>
                <h6>STEP.2</h6>
                <h2>填写商品详情</h2>
                <i class="fa fa-angle-right iconfont">&#xe657;</i>
            </li>
            <li id="step_3">
                <i class="fa fa-image step iconfont">&#xe641;</i>
                <h6>STEP.3</h6>
                <h2>上传商品图片</h2>
                <i class="fa fa-angle-right iconfont">&#xe657;</i>
            </li>
            <li id="step_4">
                <i class="fa fa-check-square-o step iconfont">&#xe734;</i>
                <h6>STEP.4</h6>
                <h2>商品发布成功</h2>
            </li>
        </ul>
        <form id="SearchModel" action="{{url('admin/product/goods/add')}}" method="POST">
        <div class="search-term m-b-10">
              <div class="simple-form-field">
                    <div class="form-group">
                        <label class="control-label">
                            <span>选择属性集：</span>
                        </label>
                        <div class="form-control-wrap">
                            <select class="form-control chosen-select" name="setid" data-width="200" style="display: none;">
                                @foreach( $abs as $ab )
                                <option value="{{encode($ab->id)}}">{{$ab->attribute_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
              </div>
        </div>
        <!-- 搜索 -->
        <div class="content">
            <!-- 选择区域 -->
            <div class="goods-info-one">
                <div class="choose-category">
                    <div class="final-catgory">
                        <dl>
                            <dt>您当前选择的是：</dt>
                            <dd id="current-choose-category"></dd>
                        </dl>
                    </div>
                    <div class="choose-category-list">
                        <div class="grade-category-list">
                            <div class="category-list">
                                <div class="category-info-search">
                                    <i class="fa fa-search iconfont">&#xe6fc;</i>
                                    <input type="text" name="category_search" class="form-control level-1" placeholder="输入名称">
                                </div>
                                <ul class="category-list-name category-level-1">
                                    @foreach( $category as $ca )
                                    <li><a href="javascript:;" class="category-name" data-leavel="{{$ca->leavel}}" data-search="{{$ca->name}}" onclick="setItem({{$ca->id}},this,'category-level-2')">{{$ca->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="choose-category-list">
                        <div class="grade-category-list">
                            <div class="category-list category-list-two">
                                <div class="category-info-search">
                                    <i class="fa fa-search iconfont">&#xe6fc;</i>
                                    <input type="text" name="category_search" class="form-control level-2" placeholder="输入名称">
                                </div>
                                <ul class="category-list-name category-level-2"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="choose-category-list choose-category-list-last">
                        <div class="grade-category-list">
                            <div class="category-list category-list-two">
                                <div class="category-info-search">
                                    <i class="fa fa-search iconfont">&#xe6fc;</i>
                                    <input name="category_search" id="category" class="form-control level-3" type="text" placeholder="输入名称">
                                </div>
                                <ul class="category-list-name category-level-3"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="goods-next">
                <input type="hidden" id="categoryName" name="categoryName">
                <input type="hidden" id="categoryID" name="categoryID">
                <input type="button" onclick="addProduct();" class="btn btn-primary btn-top" disabled="true" value="下一步，填写商品信息">
            </div>
        </div>
        </form>
    </div>
</div>
@stop
@section('footer_js')
    <script type="text/javascript" src="/js/admin/common.js?v={{Config::get('tools.adminJsTime')}}"></script>
    <script type="text/javascript" src="/js/admin/jquery.chosen.js?v={{Config::get('tools.adminJsTime')}}"></script>
    <script type="text/javascript" src="/js/admin/product.js?v={{Config::get('tools.adminJsTime')}}"></script>
@stop
