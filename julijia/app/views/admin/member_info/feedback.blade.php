<?php
/**
 * Created by julijia_frontend.
 * User: 王顶峰
 * Email: dingfeng0509@vip.qq.com
 * Date: 2016/12/10
 * Time: 17:06
 */?>
@section('content')
<div class="page">
    <div class="fixed-bar">
        <div class="item-title item-title02">
            <div class="subject">
                <h3>
                    <span class="action">会员 - 详情</span>
                </h3>
                @include('admin.member_info.view.tab')
            </div>
        </div>
    </div>

    <div class="common-title">
        <div class="ftitle">
            <h3>订  单</h3>
            <h5>
                (&nbsp;共
                <span data-total-record="true">{{$feedback->getTotal()}}</span>
                条记录&nbsp;)
            </h5>
        </div>
        <div class="operate">
            <a class="reload" href="javascript:reload();" data-toggle="tooltip" data-placement="auto bottom" title="" data-original-title="刷新数据">
                <i class="iconfont">&#xe6fb;</i>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="table_list" class="table table-hover">
            <thead>
            <tr>
                <!--排序样式sort默认，asc升序，desc降序-->
                <th class="w200" style="cursor: pointer;">投诉编号</th>
                <th class="w200" style="cursor: pointer;">订单编号</th>
                <th class="w200"  style="cursor: pointer;">投诉方</th>
                <th class="w250" style="cursor: pointer;">投诉原因</th>
                <th class="w250" style="cursor: pointer;">投诉状态</th>
                <th class="w250" style="cursor: pointer;">申请时间</th>
                <th class="w200 handle" style="cursor: pointer;">操 作</th>
            </tr>
            </thead>
            <tbody>
            <!--以下为循环内容-->
            @if(count($list))
                @foreach($list as  $val)
                    <tr>
                        <td>
                            {{$val->feedback_sn}}
                        </td>
                        <td>
                            {{$val->order_id}}
                        </td>
                        <td>
                            {{$val->user->name}}
                            &nbsp;&nbsp;<font class="c-blue">{{isset($val->user->CustomerToGroup->name)?$val->user->CustomerToGroup->name:'没有群组'}}</font>
                        </td>
                        <td>{{isset($val->reason->value)?$val->reason->value:''}}</td>
                        <td>
                           @if($val->status ==1 ) 卖家已提交，等待平台方确认 @elseif($val->status==2) 平台已处理 @endif
                        </td>
                        <td>
                            {{$val->created_at  }}
                        </td>
                        <td class="handle">
                            <a href="##">查看</a>&nbsp;&nbsp;<a href="##">处理</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">
                        <p style="text-align: center">没有查询到数据</p>
                    </td>
                </tr>
            @endif
            </tbody>

        </table>
        @include('admin.public.page',array('data'=>$list,'set'=>$set))
    </div>

</div>
@stop