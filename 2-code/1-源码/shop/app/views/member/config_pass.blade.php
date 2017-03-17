@section('title')

    修改密码
@stop


@section('admincss')
@stop


@section('left')
    @include('member.public.left_config')
@stop

@section('content')

    <div class="ge_admin_nei_right">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>




        <div class="admin_form">
            <div class="h-title">
                密码设置<font>password</font>
            </div>

            @if(Session::has('msg'))
                <p class="alert">{{Session::get('msg')}}</p>
            @endif
            <form class="layui-form m-form form" action="{{url('member/config/pass')}}" method="post">
                {{Form::token()}}

                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="red">*</span>原始密码</label>
                    <div class="layui-input-block">

                        <input type="text" class="layui-input w40b f_left"
                               placeholder="请输入原始密码" autocomplete="off"
                               datatype="*" name="pass_origin"
                               ajaxurl="/member/config/pass/check"
                               errormsg="原始密码错误" tipsrmsg="请输入原始密码"/>
                        <span class="Validform_checktip"></span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="red">*</span>新密码</label>
                    <div class="layui-input-block">

                        <input type="password" class="layui-input w40b f_left"
                               placeholder="请输入新密码" autocomplete="off"
                               datatype="*" name="pass_new"
                               errormsg="请输入新密码" tipsrmsg="请输入新密码"/>
                        <span class="Validform_checktip"></span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="red">*</span>确认密码</label>
                    <div class="layui-input-block">

                        <input type="password" class="layui-input w40b f_left"
                               placeholder="请输入确认密码" autocomplete="off"
                               datatype="*"
                               recheck="pass_new" name="pass_new"
                               errormsg="确认密码必须与新密码一致" tipsrmsg="请输入确认密码"/>
                        <span class="Validform_checktip"></span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn">立即提交</button>
                    </div>
                </div>
            </form>


        </div>

    </div>

@stop