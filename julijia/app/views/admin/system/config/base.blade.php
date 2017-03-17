<?php
/**
 * Created by julijia_frontend.
 * User: 王顶峰
 * Email: dingfeng0509@vip.qq.com
 * Date: 2017/2/17
 * Time: 10:49
 */?>

<div class="simple-form-field" style=" border:1px silver;">
    <div>
        <label style="margin-left: 35px">基本设置</label>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">网站选择的模板：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box">
                <select class="form-control valid w180"  name="core[templete]">
                    <option value="">请选择</option>
                    <option value="green" >绿色</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">网站logo：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box addimg">
                <a href="javascript:;">
                    <img  onclick="getImgTemplet( this,'img' )"
                          src="{{!empty(getConfig('core','website_logo'))?getConfig('core','website_logo'):'/images/admin/addimg.png'}}"
                          width="100" height="100">
                </a>
                <input type="hidden" id="img"  name="core[website_logo][file]" value="{{getConfig('core','website_logo',true)}}"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">网站后台logo：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box addimg">
                <a href="javascript:;">
                    <img  onclick="getImgTemplet( this,'admin_logo' )"
                          src="{{!empty(getConfig('core','admin_website_logo'))?getConfig('core','admin_website_logo'):'/images/admin/addimg.png'}}"
                          width="100" height="100">
                </a>
                <input type="hidden" id="admin_logo"  name="core[admin_website_logo][file]" value="{{getConfig('core','admin_website_logo',true)}}"/>
            </div>
        </div>
    </div>
    <!-- seo -->
    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">首页Title：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box">
                <input type="text" class="form-control"  ignore="ignore"   datatype="*3-80"  name="core[title]" value="{{getConfig('core','title')}}" >
                <span class="Validform_checktip"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">首页Keywords：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box">
                <input type="text" class="form-control"  ignore="ignore"  datatype="*3-150"  name="core[keywords]" value="{{getConfig('core','keywords')}}" >
                <span class="Validform_checktip"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">首页Description：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box">
                <input type="text" class="form-control"  ignore="ignore"  datatype="*3-200"   name="core[description]" value="{{getConfig('core','description')}}" >
                <span class="Validform_checktip"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">
            <span class="ng-binding">网站底部Copyright：</span>
        </label>
        <div class="col-sm-8">
            <div class="form-control-box">
                <textarea name="core[copyright]" class="form-control"> {{getConfig('core','copyright')}}</textarea>
                <span class="Validform_checktip"></span>
            </div>
        </div>
    </div>
</div>
