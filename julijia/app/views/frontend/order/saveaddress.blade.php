<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <link rel="stylesheet" type="text/css" href="{{url('css/frontend/css_all.css?v='.Config::get('tools.frontendCssTime'))}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/frontend/order.css?v='.Config::get('tools.frontendCssTime'))}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/frontend/layui.css?v='.Config::get('tools.frontendCssTime'))}}">
</head>
<body>
<form class="layui-form m-form adress_form" @if(isset($data)) action="{{url('order/editaddress')}}" @else action="{{url('order/saveaddress')}}" @endif method="post">
    <div class="layui-form-item">
        <label class="layui-form-label"><span class="red">*</span>选择区域</label>
        <div class="layui-input-inline">
            <select name="province" id="address" lay-filter="province" datatype="*|select">
                <option value="">请选择省</option>
                @if(isset($data->provinceInfo->provinceID))
                <option value="{{$data->provinceInfo->provinceID}}" selected="selected">{{$data->provinceInfo->province}}</option>
                @endif
            </select>
            <span class="Validform_checktip"></span>
        </div>
        <div class="layui-input-inline">
            <select name="city" id="address1" lay-filter="city" datatype="*|select">
                <option value="">请选择市</option>
                @if(isset($data->cityInfo->cityID))
                    <option value="{{$data->cityInfo->cityID}}" selected="selected">{{$data->cityInfo->city}}</option>
                @endif
            </select>
            <span class="Validform_checktip"></span>
        </div>
        <div class="layui-input-inline">
            <select name="area" id="address2" lay-filter="area" datatype="*|select">
                <option value="">请选择县/区</option>
                @if(isset($data->areaInfo->areaID))
                    <option value="{{$data->areaInfo->areaID}}" selected="selected">{{$data->areaInfo->area}}</option>
                @endif
            </select>
            <span class="Validform_checktip"></span>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span class="red">*</span>详细地址</label>
        <div class="layui-input-block">
            <textarea name="address" class="layui-textarea w80b f_left" placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号等信息" autocomplete="off" datatype="*5-100"  errormsg="5-100个字符" tipsrmsg="请输入详细地址" >@if( isset($data->address) ){{$data->address}}@endif</textarea><span class="Validform_checktip"></span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">邮政编码</label>
        <div class="layui-input-block">
            <input type="text" name="zipcode" value="@if( isset($data->zipcode) ){{$data->zipcode}}@endif" maxlength="6" placeholder="如您不清楚邮递区号，请填写000000" autocomplete="off" class="layui-input w40b f_left"  datatype="p"  errormsg="邮政编码格式有误" tipsrmsg="请输入邮政编码" ><span class="Validform_checktip"></span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span class="red">*</span>收货人</label>
        <div class="layui-input-block">
            <input type="text" name="name"  value="@if( isset($data->name) ){{$data->name}}@endif" maxlength="6" placeholder="长度不超过6个汉字" autocomplete="off" class="layui-input w40b f_left"   datatype="/^[\u4E00-\u9FA5\uf900-\ufa2d]{2,6}$/"  errormsg="收货人姓名应为2-6个汉字" tipsrmsg="请输入收货人姓名" ><span class="Validform_checktip"></span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span class="red">*</span>手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="@if( isset($data->phone) ){{$data->phone}}@endif" placeholder="电话号码、手机号码必须填一项" autocomplete="off" class="layui-input w40b f_left"  datatype="m"  errormsg="手机号码格式有误" tipsrmsg="请输入手机号码" ><span class="Validform_checktip"></span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <input type="checkbox" name="status" value="1" title="设为默认地址" @if( isset($data->status) && $data->status)checked="checked"@endif >
            <div class="layui-unselect layui-form-checkbox layui-form-checked">
                <span>设为默认地址</span><i class="layui-icon"></i>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn fize_ml" id="btn_submit">保存</button>
        </div>
    </div>
    <input type="hidden" @if(isset($data->id)) name="aid" value="{{encode($data->id)}}" @endif/>
    {{Form::token()}}
</form>
</body>
<script type="text/javascript" src="{{url('js/public/jquery/jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/public/Validform/Validform_v5.3.2_min.js')}}"></script>
<script type="text/javascript" src="{{url('js/public/layui/layui.js')}}"></script>
<script>
    $(".m-form").Validform({
        btnSubmit: '#btn_submit',
        postonce: true,
        showAllError: true,
        tiptype: function (msg, o, cssctl) {
            if (!o.obj.is("form"))
            {
                var objtip = o.obj.parent('div').find(".Validform_checktip");
                objtip.removeClass('Validform_skate');
                cssctl(objtip, o.type);
                objtip.text(msg);
            }
        }
    });
    $(".m-form").find('input').each(function () {
        $(this).focus(function () {
            if ($(this).val() == '')
            {
                var msg = $(this).attr('tipsrmsg');
                $(this).parent('div').find(".Validform_checktip").addClass('Validform_skate');
                $(this).parent('div').find(".Validform_checktip").removeClass('Validform_wrong');
                $(this).parent('div').find(".Validform_checktip").text(msg);
            }else
            {
                $(this).parent('div').find(".Validform_checktip").removeClass('Validform_skate');
            }
        });
        $(this).blur(function ()
        {
            if ($(this).val() == '')
            {
                var msg = $(this).attr('nullmsg');
                $(this).parent('div').find(".Validform_checktip").removeClass('Validform_skate');
                $(this).parent('div').find(".Validform_checktip").addClass('Validform_wrong');
                $(this).parent('div').find(".Validform_checktip").text(msg);
            }
        });
    });

    // set options for #address1 which is for province when page loaded
    var token = $("input[name='_token']").val();
    var $form;
    var form;
    $(function () {
        loadProvince();
    });
    //使用layui处理弹框
    layui.use(['jquery', 'form'], function () {
        $ = layui.jquery;
        form = layui.form();
        $form = $('form');
        //载入省份
        form.on('select(province)', function (data) {
            var city = data.value;
            loadCity(city);
        });
        form.on('select(city)', function (data) {
            var eare = data.value;
            loadArea(eare);
        })

    });

    function loadProvince() {
        var phtml = '';
        // $form.find('select[name=province]').empty();
        $.post("/getProvince", {}, function (data) {
            var data = $.parseJSON(data);
            $.each(data, function (n, value) {
                phtml += "<option value=" + value["provinceID"] + " data-id="+value["provinceID"]+">" + value["province"] + "</option>";
            });
            $form.find('select[name=province]').append(phtml);
            form.render('select');
            form.on('select(province)', function (data) {
                var citydata = $("#address option:selected").attr('data-id');
                loadCity(citydata);
            })
        });
    }
    function loadCity(citydata) {
        var phtml = '<option value="0">请选择市区</option>';
        $form.find('select[name=city]').empty();
        loadArea(0);
        $.post("/getCity", {province: citydata}, function (data) {
            var data = $.parseJSON(data);
            $.each(data, function (n, value) {
                phtml += "<option value=" + value["cityID"] + " data-id="+value["cityID"]+">" + value["city"] + "</option>"
            });
            $form.find('select[name=city]').append(phtml);
            form.render('select');
            form.on('select(city)', function (data) {
                var areaata = $("#address1 option:selected").attr('data-id');
                loadArea(areaata);
            })
        });
    }

    function loadArea(areaata) {
        var phtml = '<option value="0">请选择区/县</option>';
        $form.find('select[name=area]').empty();
        if(areaata ==0){
            $form.find('select[name=area]').append(phtml);
        }
        $.post("/getArea", {city: areaata}, function (data) {
            var data = $.parseJSON(data);
            $.each(data, function (n, value) {
                //clear the select options then add the new info
                phtml += "<option value=" + value["areaID"] + ">" + value["area"] + "</option>"
            });
            $form.find('select[name=area]').append(phtml);
            form.render('select');
        });
    }
</script>
</html>