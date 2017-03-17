@section('title','门店添加')
@section('content')
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>
                    <span class="action">线下门店-编辑</span>
                </h3>
                <h5>
                <span class="action-span">
                    <a href="{{url('admin/user/shop')}}" class="btn btn-warning click-loading">
                        <i class="iconfont">&#xe6d4;</i>
                        返回门店列表
                    </a>
                </span>
                </h5>
            </div>
        </div>
    </div>
    <form id="SystemConfigModel" class="form-horizontal form"  method="post"  action="{{url('admin/user/shop/'.encode($data->id))}}" >
        {{ Form::token() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="table-content m-t-30">
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="text-danger ng-binding">*</span>
                        <span class="ng-binding">门店名称：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid"  name="m_name" value="{{$data->m_name}}"  ajaxurl="/admin/getonlyinfo?type=shop&id={{$data->id}}" datatype="s3-20" tipsrmsg="请输入3-20个字符（不能包含特殊符号）" errormsg="请输入3-20个字符（不能包含特殊符号）" >
                            <span class="Validform_checktip "></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="text-danger ng-binding">*</span>
                        <span class="ng-binding">管理员：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid"  name="m_manager" value="{{$data->m_manager}}" datatype="un" tipsrmsg="请输入长度在2-6内的汉字" errormsg="长度在2-6内的汉字">
                            <span class="Validform_checktip "></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">门店logo：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box addimg">
                            <a href="javascript:;"><img onclick="getImgTemplet( this,'shop' )"  src="{{getImagesUrl('shop',$data->id,$data->ico)}}"width="100" height="100"></a>
                            <input type="hidden" id="shop" name="ico" value="{{$data->ico}}" />
                            <input type="hidden"  name="editico"  value="{{$data->ico}}"/>
                        </div>
                        <div class="help-block help-block-t"><div class="help-block help-block-t">请上传图片，做为品牌的LOGO，建议尺寸100*40像素</div></div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="text-danger ng-binding">*</span>
                        <span class="ng-binding">地址：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <select id="province" class="form-control m-r-5 valid w150" aria-invalid="false" name="province" onchange="getCityList(this)" >
                                <option value="0">请选择省份</option>
                                @foreach( $province as $row )
                                    <option value="{{$row->provinceID}}" @if($data->province==$row->provinceID) selected="selected" @endif >{{$row->province}}</option>
                                @endforeach
                            </select>
                            <select id="city" class="form-control m-r-5 m-l-5 w150"  datatype="*|select" name="city">
                                @foreach( $city as $c )
                                    <option value="{{$c->cityID}}" @if($data->city==$c->cityID) selected="selected" @endif >{{$c->city}}</option>
                                @endforeach
                            </select>
                            <br/><br/>
                            <textarea class="form-control valid" rows="5" aria-invalid="false" name="address" datatype="*1-50" tipsrmsg="请输入门店详细地址" errormsg="详细地址为1-50个字符" >{{$data->address}}</textarea>
                            <span class="Validform_checktip "></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">电话：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="phone" ignore="ignore" value="{{$data->phone}}" datatype="tel" tipsrmsg="请输入手机号码或者固定电话" errormsg="电话格式有误" >
                            <span class="Validform_checktip "></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field p-b-30">
                <div class="form-group">
                    <label for="text4" class="col-sm-4 control-label"></label>
                    <div class="col-xs-8">
                        <input type="button" id="btn_submit" value="确认提交" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop
@section('footer_js')
    <script type="text/javascript" src="/js/admin/shop.js?v={{Config::get('tools.adminJsTime')}}"></script>
@stop