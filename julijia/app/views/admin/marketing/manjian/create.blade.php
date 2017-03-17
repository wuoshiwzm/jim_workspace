@section('title','满减满送添加')
@section('content')
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>
                <span class="action">
                  满减满送 - 新增
                </span>
                </h3>
                <h5>
                <span class="action-span">
                    <a href="{{url('admin/marketing/fullcut')}}" class="btn btn-warning click-loading">
                        <i class="iconfont">&#xe6d4;</i>
                        返回满减满送列表
                    </a>
                </span>
                </h5>
            </div>
        </div>
    </div>
    <form class="form-horizontal form"  method="post" action="{{url('admin/marketing/fullcut')}}">
        {{ Form::token() }}
        <div class="table-content m-t-30 ">
            <h5 class="tab_h5"><font class="iconfont">&#xe64e;</font>基本信息</h5>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="text-danger ng-binding">*</span>
                        <span class="ng-binding">标 题：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="name" ajaxurl="/admin/getonlyinfo?type=rule" datatype="s2-15" maxlength="15" tipsrmsg="请输入标题（不包含特殊字符）" errormsg="标题2-15个字符（不包含特殊字符）">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">备注信息：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <textarea class="form-control valid" name="desc" rows="5" maxlength="300" style="height:60px"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">状 态：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <select class="form-control valid w100" name="status"  >
                                <option value="1" selected="selected">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">发行数量：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="lssue_num" datatype="num" maxlength="6" tipsrmsg="请输入发行数量" errormsg="发行数量为1-6位正整数" >
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">使用次数：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="userd_num" datatype="num,checknum" maxlength="6" tipsrmsg="请输入使用次数" errormsg="使用次数为1-6位正整数">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">每人/每天：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="per_num" datatype="/^[1-9]\d{0,1}$/" maxlength="2" tipsrmsg="请输入1-2位正整数" errormsg="使用数量为1-2位正整数">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">开始时间：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="from_date"  onfocus="WdatePicker({lang:'zh-cn',minDate:new Date(new Date().valueOf())})"  value="{{date("Y-m-d")}}" datatype="time" tipsrmsg="请输入开始时间" errormsg="时间格式有误">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">结束时间：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="to_date"  onfocus="WdatePicker({lang:'zh-cn',minDate:new Date(new Date().valueOf())})" value="{{date("Y-m-d")}}" datatype="time,checktime" maxlength="6" tipsrmsg="请输入结束时间" errormsg="时间格式有误">
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="tab_h5"><font class="iconfont">&#xe663;</font>触发条件</h5>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">满减金额：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid" name="conditions_use" datatype="full" maxlength="10" tipsrmsg="请输入1-10位正整数" errormsg="满减金额为1-10位正整数">
                            <span class="Validform_checktip"></span>
                        </div>
                        <div class="help-block help-block-t"><div class="help-block help-block-t">满*元触发规则</div></div>
                    </div>
                </div>
            </div>
            <h5 class="tab_h5"><font class="iconfont">&#xe66c;</font>使用操作</h5>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">触发条件：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <select class="form-control valid w100" name="action_type" onchange="setType( this )">
                                <option value="1">固定折扣</option>
                                <option value="2">百分比</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <span class="ng-binding">折扣金额：</span>
                    </label>
                    <div class="col-sm-8">
                        <div class="form-control-box">
                            <input type="text"  class="form-control valid w100" name="discount_amount" datatype="full,discount" maxlength="10" tipsrmsg="请输入1-10位正整数" errormsg="折扣金额为1-10位正整数">&nbsp;&nbsp;<span id="danwei">元</span>
                            <span class="Validform_checktip"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-form-field p-b-30">
                <div class="form-group">
                    <label for="text4" class="col-sm-4 control-label"></label>
                    <div class="col-xs-8">
                        <input type="submit" id="btn_submit" value="确认提交" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop
@section('footer_js')
    <script type="text/javascript" src="/js/public/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/js/admin/fullcut.js?v={{Config::get('tools.adminJsTime')}}"></script>
@stop
