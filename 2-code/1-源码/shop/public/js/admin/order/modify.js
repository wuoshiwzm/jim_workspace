/**
 *Created by poseidon on 2016-12-11.
 *desc:修改订单商品价格
 */
$(function(){
    //确定
    $("#confirm").click(function(){
        if (! getPirce()){
            return false
        }else{
            var arr = [];
            $(".disprice").each(function(){
                var discount = $(this).val();
                var item_id = $(this).attr("data-item");
                arr.push({"item_id":item_id,"discount":discount});
            });
            //运费
            var freight = $(".freight").val();
            //保存数据
            $.ajax({
                url:"/admin/order/change",
                method:"post",
                data:{data:JSON.stringify(arr),freight:freight},
                async:false,
                success:function(result){
                    if (result.status == 1) {
                        //修改信息入库
                        layer.confirm('&nbsp;&nbsp;修改已成功,是否关闭？', {
                            title: ['提示'],
                            btn: ['确定','继续修改']
                        }, function(){
                            closeLayer()
                        }, function(){
                        });
                    }else if (result.status == 0) {
                        layer.msg("修改失败",{icon: 2,time:1000});
                    }
                },
                error:function(){
                    layer.msg("网络异常",{icon: 2,time:2000});
                }
            })
        }
    });

    //取消
    $("#cancel").click(function(){
        closeLayer()
    });


    //免运费
    $("#free").click(function(){
        $(".freight").val(0);
        var result = freeFreight();
        if (result)
            return false;
    });

    //关闭弹出层
    function closeLayer()
    {
        var index = parent.layer.getFrameIndex(window.name);
        parent.location.reload();
        parent.layer.close(index); //再执行关闭

    }

    //免除运费价格
    function freeFreight()
    {
        //原价
        var price = 0.00;
        $(".disprice").each(function(){
            //数量
            var num = parseInt($(this).attr("data-num"));
            //单价
            var original = parseFloat($(this).attr("data-price"));
            //重新计算原价
            price += original * num
        });
        //运费
        var freight = 0.00;
        //优惠价格
        var favorable = parseFloat($("#favorable").text());
        //实际价格
        var fact = (price * 100 - favorable * 100 + freight * 100)/ 100;
        /*赋值*/
        $("#original").text(price);
        $("#freight").text(freight);
        $("#payment").text(fact);
    }


    //重新计算更改后价格
    function getPirce()
    {
        var modify_price = 0;
        var isTrue = 1;
        $(".disprice").each(function(){
            //获取输入折扣
            if (!/^(\-|\+)?([\d]{1,6}\.[\d]{1,2}|[\d]{1,6})$/.test($(this).val())) {
                layer.msg("涨价或折扣格式输入有误，且精确到小数点后2位！",{
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                });
                $(this).focus();
                isTrue = 0;
                //中断循环
                return false;
            }
            //验证折扣数如果是小数点不能超过两位
            var discount  = parseFloat($(this).val());

            //if (/^(\-|\+)?[\d]{1,10}\.[\d]{1,10}$/.test($(this).val())){
            //    alert(discount.toString().split(".")[1].length);
            //    var len = discount.toString().split(".")[1].length;
            //    if (len > 2) {
            //        layer.msg("金额精确到小数点后两位",{
            //            icon: 1,
            //            time: 2000 //2秒关闭（如果不配置，默认是3秒）
            //        })
            //        $(this).focus();
            //        isTrue = 0;
            //        //中断循环
            //        return false;
            //    }
            //}

            //数量
            var num = parseInt($(this).attr("data-num"));
            //单价
            var original = parseFloat($(this).attr("data-price"));
            //计算差值
            var subtraction = original + discount;

            //价格相差为零
            if (subtraction <= 0) {
                layer.msg("折扣不能超过或等于商品价格",{
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                });
                //获取焦点
                $(this).focus();
                isTrue = 0;
                //中断循环
                return false;
            }
            //重新计算原价
            modify_price += subtraction * num
        });

        if (isTrue == 0)
            return false;
        //运费
        var freight = $(".freight").val();
        if (!/^(\-|\+)?([\d]{1,6}\.[\d]{1,2}|[\d]{1,6})$/.test(freight) ) {
            layer.msg("运费输入格式有误，精确到小数点后2位！",{
                icon: 1,
                time: 2000 //2秒关闭（如果不配置，默认是3秒）
            });
            $(".freight").focus();
            return false
        }

        //优惠价格
        var favorable = parseFloat($("#favorable").text());
        //实际价格
        var fact = (modify_price * 100 - favorable * 100 + parseFloat(freight) *　100)/100;
        //修改后订单不能大于订单金额的最大值
        if (fact > 999999.99) {
            layer.msg("订单总金额不能大于999999.99",{
                icon: 1,
                time: 2000 //2秒关闭（如果不配置，默认是3秒）
            });
            return false
        }
        return true;
        /*赋值*/
        $(".price").text(modify_price);

        $("#original").text(modify_price);
        $("#freight").text(freight);
        $("#payment").text(fact);
        return true;
    }

});
