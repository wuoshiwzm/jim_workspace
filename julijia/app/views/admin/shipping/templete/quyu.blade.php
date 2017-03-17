<?php
/**
 * Created by julijia_frontend.
 * User: 王顶峰
 * Email: dingfeng0509@vip.qq.com
 * Date: 2017/2/6
 * Time: 14:53
 */?>
 <!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>选择省市区</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <style>
        /* css */
        *{margin:0; padding:0; list-style:none; }
        a:focus{outline:none;}
        input:focus{outline:none;}
        .page{padding:20px 20px 20px 20px; }
        .page h1{ font-size:16px; height:26px; border-bottom:1px solid #eaeaea;  }
        .m-form_div{ padding:14px 4px; }
        .form_div .hd{ clear:both; padding:14px 4px 0px 4px; display:inline-block;float:left}
        .form_div .hd ul li{ float:left; width:80px; font-size:14px; color:#333; margin-bottom:10px;}
        .form_div .bd{ clear:both; background:#f6f6f6; height:auto; display: inline-block; width:100%;}
        .form_div .bd ul{ padding:12px 12px 16px 12px; }
        .form_div .bd li{ float:left; margin-right:10px; margin-bottom:12px;}
        .valid{ vertical-align:middle; float:left; margin-right:6px; background:#fff;}

        .shiqu{ font-size:12px;}
        .qu_div{ position:relative; background:#ddd; width:90px; display:inline-block; height:20px; background:#fff; padding-top:6px; padding-left:12px;border:1px solid #c6def0;  }

        .qu_div dl{ width:180px; padding:10px 0px 2px 12px;  background:#fff; border:1px solid #c6def0; position:absolute; top:26px; left:-1px; display:none; z-index:666; }
        .qu_div:hover dl{  display:inline-block;}

        .qu_div dl dd{ float:left; margin-right:10px; height:24px;  }
        .qu_div dl .control-label{ float:left; height:16px; width:80px; overflow:hidden; display:inline-block; }
        .qu_div .control-label02{  height:14px; width:80px; overflow:hidden; display:inline-block; }

        .button_btn input{ width:120px; padding:8px 0px; text-align:center; color:#fff; font-size:16px; background:#24A0D6; border:0; margin-top:10px; font-weight:bold; cursor: pointer;}
        .button_btn input:hover{  background:#1d90c2; }
    </style>

    <script type="text/javascript" src="/js/public/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/js/public/jquery/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="/js/public/layer/layer.js"></script>

</head>
<body>

<div class="page">

    <h1>选择地区</h1>
    <form class="m-form"  method="post"  novalidate>
        <div class="form_div">

            <div class="hd">
                <ul>
                    @foreach($plist as $val)
                        <li >
                            <label class="control-label">
                                <input type="checkbox" class="valid" value="{{$val->provinceID}}">{{$val->province}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bd">
                @foreach($plist as $pli)
                  <ul>
                       <?php  $cityid = Source_Area_City::where('parent',$pli->provinceID)->select('city','cityID')->get() ?>
                      @if(count($cityid))
                             @foreach($cityid as $lls)
                                   <li class="shiqu">
                                       <div class="qu_div">
                                           <label class="control-label control-label02">
                                               <input type="checkbox"  name="xuanzecity" class="valid" value="{{$lls->cityID}}" onclick="checkqueyu(this)">{{$lls->city}}
                                           </label>
                                           <?php  $alist =  Source_Area_Area::where('parent',$lls->cityID)->select('areaID','area')->get() ?>
                                            @if(count($alist)>0)
                                                <dl>
                                                    @foreach( $alist as $li)
                                                        <dd>
                                                            <label class="control-label">
                                                                <input type="checkbox" class="valid"  name="xuanze" value="{{$li->areaID}}" valuename="{{$li->area}}">{{$li->area}}
                                                            </label>
                                                        </dd>
                                                    @endforeach
                                                </dl>
                                            @endif
                                       </div>
                                   </li>
                               @endforeach
                       @endif
                  </ul>
                @endforeach
            </div>
            <div class="button_btn">
                <input type="button" id="btn_submit" value="保存提交" >
            </div>
        </div>
        <script type="text/javascript" >jQuery(".form_div").slide({trigger:"click"});</script>
        <script type="text/javascript">
            $("#btn_submit").click(function () {
                str ='';
                string='';
                $(".m-form").find('input[name=xuanze]').each(function () {
                    if($(this).attr('checked')){
                        str+=$(this).val()+',';
                        string+=$(this).attr('valuename')+',';
                    }
                });
                city ='';
                $(".m-form").find('input[name=xuanzecity]').each(function () {
                    if($(this).attr('checked')){
                        city+=$(this).val()+',';
                    }
                });
                parent.setEareQu(str, string,'{{$code}}',city);
            });

            function checkqueyu(index) {
                if($(index).attr('checked')){
                    $(index).parents('li').find('dd').each(function () {
                        $(this).find('input[type="checkbox"]').attr('checked','checked');
                    })
                }else{
                    $(index).parents('li').find('dd').each(function () {
                        $(this).find('input[type="checkbox"]').removeAttr('checked');
                    })
                }

            }
        </script>
    </form>


</div>



</body></html>