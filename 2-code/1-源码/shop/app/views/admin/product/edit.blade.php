@section('title','编辑产品')
@section('admincss')
    <link type="text/css" rel="stylesheet" href="{{url('css/admin/styles.css').'?v='.Config::get('tools.adminJsTime')}}">
@stop
@section('content')
    <div class="page">
        <div class="fixed-bar">
            <div class="item-title item-title02">
                <div class="subject">
                    <h3>
                        <span class="action">产品编辑</span>
                    </h3>
                    <h5>
                    <span class="action-span">
                        <a href="{{url('admin/product/goods')}}" class="btn btn-warning click-loading">
                            <i class="iconfont">&#xe6d4;</i>
                            返回商品列表
                        </a>
                    </span>
                    </h5>
                    <ul class="tab-base shop-row">
                        <li><a class="current" href="{{url('admin/product/goods/'.encode($id).'/edit?setid='.encode($setID))}}"><span>编辑商品</span></a></li>
                        <li><a href="{{url('admin/product/goodsimg/'.$id.'?setid='.encode($setID))}}"><span>编辑图片</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="table-content m-t-15">
            <!--步骤-->
            <div class="content">
                <div class="goods-info-two">
                    <form class="form-horizontal form" accept-charset="UTF-8"  method="post" action="{{url('admin/product/goods/'.encode($id))}}">
                        {{ Form::token() }}
                        <input type="hidden" name="_method" value="PUT">
                        <h5 class="h5_bottom">商品基本信息</h5>
                        <!--商品类型 -->
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="ng-binding">商品类型：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <select class="form-control valid w200" name="type" >
                                            <option value="1" @if($flat->type == 1) selected="selected" @endif>简单产品</option>
                                            <option value="2" @if($flat->type == 2) selected="selected" @endif>可配置产品</option>
                                            <option value="3" @if($flat->type == 3) selected="selected" @endif>虚拟产品</option>
                                            <option value="4" @if($flat->type == 4) selected="selected" @endif>可下载产品</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 供应商 -->
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="ng-binding">供应商：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <select class="form-control valid w200" name="supplier_id" onchange="getSupplier( this )">
                                            @foreach( $supplier as $k=>$su )
                                                <option value="{{$su->id}}" @if($flat->supplier == $su->id) selected="selected" @endif>{{$su->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="supplier_name" value="{{$flat->productFlatToSupplier->supplier_name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 线下门店 -->
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="ng-binding">线下门店：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <select class="form-control valid w200" name="shop">
                                            @foreach( $shop as $sh )
                                                <option value="{{$sh->id}}" @if($flat->shop == $sh->id) selected="selected" @endif>{{$sh->m_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 品牌 -->
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="ng-binding">品牌：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <select class="form-control valid w200" name="brand_id">
                                            @foreach( $brand as $b )
                                                <option value="{{$b->id}}" @if($flat->brand == $b->id) selected="selected" @endif>{{$b->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="text-danger ng-binding">*</span>
                                    <span class="ng-binding">警戒库存：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <input type="text" class="form-control" name="jingjie" value="{{$flat->productFlatToStock->jingjie}}" datatype="stock"   onblur="checkjingjie()"  maxlength="5" errormsg="输入1-5位正整数" tipsrmsg="请输入1-5位正整数"  >
                                        <span class="Validform_checktip"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simple-form-field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <span class="text-danger ng-binding">*</span>
                                    <span class="ng-binding">库存：</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="form-control-box">
                                        <input type="text" class="form-control" name="stock" value="{{$flat->kc_qty}}" datatype="stock,checkstock"  maxlength="5"  errormsg="库存为1-5位正整数" tipsrmsg="请输入1-5位正整数" >
                                        <span class="Validform_checktip"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" value="{{$flat->category_id}}">
                        @include('admin.product.getEav.editattbute',array('data'=>$data,'flat'=>$flat))
                        @include('admin.product.freight',array('freight'=>$freight,'data'=>$flat))
                        <div class="goods-next">
                            <input type="submit" id="btn_submit" value="确认提交" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script charset="utf-8" src="/js/public/kindeditor/kindeditor.js"></script>
    <script charset="utf-8" src="/js/public/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="/js/public/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/js/admin/product.js?v={{Config::get('tools.adminJsTime')}}"></script>
    <script type="text/javascript" src="/js/admin/liandong.js?v={{Config::get('tools.adminJsTime')}}"></script>
@stop