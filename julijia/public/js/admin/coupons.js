/**
 * Created by Administrator on 2016/11/18 0018.
 */

function setType( index )
{
    var value = $(index).val();
    if( value == '2' )
    {
        var name = '百分比：';
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('datatype','percent');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('maxlength','3');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('tipsrmsg','请输入百分比');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('errormsg','百分比为1-100之间的正整数');
        $("#danwei").html('%');
    }else
    {
        var name = '折扣金额：';
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('datatype','full');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('maxlength','10');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('tipsrmsg','请输入1-10位正整数');
        $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').attr('errormsg','折扣金额为1-10位正整数');
        $("#danwei").html('元');
    }
    $( index ).parents('.simple-form-field').next('.simple-form-field').find('.ng-binding').text(name);
    $( index ).parents('.simple-form-field').next('.simple-form-field').find('input').val('');
}

/**
 *  删除分组
 * @param id
 */
function delCoupon( id )
{
    var token = $("input[name='_token']").val();
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消']
    }, function(){
        $.post('/admin/marketing/coupon/'+id,{_method:'DELETE',_token:token},function (msg) {
            if( msg.ststus == '0')
            {
                layer.msg(msg.msg, {icon: 1});
                location=location;
            }else
            {
                layer.msg(msg.msg, {icon: 2});
            }
        },'json')
    });
}

/**
 * 切换
 * @param index
 */
function condition( index )
{
    var type = $( index ).val();
    $.get("/admin/marketing/coupon/"+type,function ( data )
    {
        if( data )
        {
            $("#content").find('.form-group').remove();
            $("#content").append(data);
            //动态刷新js
            $.getScript("/js/admin/adminpublic.js");
        }
    });
}


/**
 * 选择分类
 * @param id
 * @param ietm
 */
function steCategory( index  )
{
    var id = $(index).val();
    if( id )
    {
        $.get('/admin/product/getcategory/'+id,function ( data ) {
            var str = '<option value="0">请选择</option>';
            for( var i=0; i< data.length; i++ )
            {
                str += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $(index).parents('.form-control-box').next('.form-control-box').find('option').remove();
            $(index).parents('.form-control-box').next('.form-control-box').find('.form-control').append( str );
        },'json')
    }
}


/**
 *  新增分类
 */

function addCategory( index ) {

    var name =  $('#category_id option:selected').text();
    var id = $('#category_id option:selected').val();
    var ids = true;
    $(".add_fen").find('input').each(function () {
        if( $(this).val() == id )
        {
            ids = false;
            layer.msg('次分类您已经选择了');
        }
    });
    if( id != false && ids != false )
    {
        var str = '<div>'+name+'（'+id+'）<a href="javascript:;" onclick="remCategory( this )">x</a><input type="hidden" name="category_id[]" value="'+id+'"></div>';
        $(".add_fen").append( str );
    }
}

/**
 * 移除选择的分类
 * @param index
 */
function  remCategory( index ) {

    $(index).parent('div').remove();
}
/**
 * 获取产品
 * @param index
 */
function getGoods( index ) {

    var type = 'goodslist';
    var id = $( index ).val();
    $.get("/admin/marketing/coupon/"+type+'?id='+id,function ( data )
    {
        $("#goodslist").find('div').remove();
        if( data )
        {
            $("#goodslist").append(data);
        }
    });
}

/**
 * 产品分页
 * @param page
 */
function getProducts( page )
{
    var type = 'goodslist';
    var id =  $('#category_id option:selected').val();
    $.get("/admin/marketing/coupon/"+type+'?id='+id+'&page='+page,function ( data )
    {
        $("#goodslist").find('div').remove();
        if( data )
        {
            $("#goodslist").append(data);
        }
    });
}

/**
 * 动态添加产品
 * @param index
 */
function addItem( index )
{
    var img = $( index ).parents('dl').find("img").attr('src');
    var name = $( index ).parents('dl').find(".dd_h a").text();
    var price = $( index ).parents('dl').find("font").text();
    var id =  $( index ).parents('dl').find("input").val();
    var str =  '<li><dl>'+
                '<dt><img src="'+img+'"></dt>'+
                    '<dd class="dd_h"><a href="javascript:;">'+name+'</a></dd>'+
                    '<dd class="dd_size"><font>'+price+'</font></dd>'+
                    '<dd class="dd_add"><a href="javascript:;" onclick="reItem( this )"><i></i><span>删除</span></a></dd>'+
                    '<input type="hidden" name="entity_id[]" value="'+id+'">'+
                '</dl></li>';

    $(".shop_ppp").find("ul").append(str);

}

/**
 * 移除产品
 * @param index
 */
function reItem( index ) {

    $(index).parents('li').remove();
}


/**
 * 修改编辑的产品分类
 * @param index
 */
function editRemCategory( index ) {

   var delID =  $(index).parent('div').find('input').val();
   var str = '<input type="hidden" name="oldId[]" value="'+delID+'">';
   $("#oldID").append( str );
   $(index).parent('div').remove();
}

/**
 * 修改产品
 * @param index
 */
function editReItem( index ) {

    var delID =  $(index).parents('dl').find('input').val();
    var str = '<input type="hidden" name="oldId[]" value="'+delID+'">';
    $("#oldID").append( str );
    $(index).parents('li').remove();
}



$.extend($.Datatype, {
    /**
     * 折扣金额
     * @param gets
     * @returns {boolean}
     */
    'full':function ( gets, obj, curform, regxp)
    {
        var reg = /^[1-9]\d{0,9}$/;
        if ( reg.test(gets) )
        {
            return true;

        }else
        {
            return false;
        }
    },
    /**
     * 验证发型数量和使用数量
     * @param gets
     * @param obj
     * @param curform
     * @param regxp
     * @returns {boolean}
     */
    'checknum':function ( gets, obj, curform, regxp)
    {
        var prevTime  = $(obj).parents('.simple-form-field').prev().find('.form-control').val();
        if( parseInt(prevTime) < gets )
        {
            obj.attr('errormsg', '使用次数不能大于发行数量');
            return false;
        }else
        {
            return true;
        }
    },
    'num':function ( gets, obj, curform, regxp)
    {
        var reg = /^[1-9]\d{0,5}$/;
        if ( reg.test(gets) )
        {
            return true;

        }else
        {
            if( obj.attr('name') == 'userd_num' )
            {
                obj.attr('errormsg', '使用次数为1-6位正整数');
                return false;
            }else
            {
                return false;
            }
        }
    }
});