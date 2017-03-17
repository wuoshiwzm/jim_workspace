$.extend($.Datatype, {
    /**
     *  电话
     */
    'tel': function (gets, obj, curform, regxp)
    {
        var reg = /(^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$)|(^((\(\d{3}\))|(\d{3}\-))?(1[3578]\d{9})$)|(^(400)-(\d{3})-(\d{4})(.)(\d{1,4})$)|(^(400)-(\d{3})-(\d{4}$))/;
        if ( gets == '' ){ obj.attr('errormsg', '请填写电话'); return false;}
        if ( reg.test(gets) ) return true;
        else {
            obj.attr('errormsg', '电话格式有误（带区号请用英文 - 隔开）');
            return false
        }
    },
    /**
     * 姓名
     */
    'un': /^[\u4E00-\u9FA5\uf900-\ufa2d]{2,6}$/,
    /**
     * 金额
     */
    "je": function (gets, obj, curform, regxp)
    {
        var reg = /^(0|[1-9][0-9]{0,7})(\.[0-9]{1,2})?$/;
        if ( reg.test(gets) )
        {
            return true;

        }else
        {
            return false;
        }
    },
    /**
     *  金额对比
     */
    "preferential_price": function (gets, obj, curform, regxp)
    {
        var price = parseInt($("input[name='4']").val());
        if( price )
        {
            if( price <  gets )
            {
                return false;
            }else
            {
                return true;
            }
        }else return true;
    },
    /**
     * 验证时间
     */
    'time':function ( gets )
    {
        var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
        var r = gets.match(reg);
        if( r == null )
        {
           return false;

        }else
        {
            return true;
        }
    },
    /**
     * 验证开始时间可结束时间
     * @param gets
     * @param obj
     * @returns {boolean}
     */
    'checktime':function ( gets, obj ) {
        var prevTime  = $(obj).parents('.simple-form-field').prev().find('.form-control').val();
        if( prevTime > gets )
        {
            obj.attr('errormsg', '开始时间不能大于结束时间');
            return false;
        }else
        {
            return true;
        }
    },
    /**
     * 重量验证
     * @param gets
     * @returns {boolean}
     */
    'weight':function ( gets )
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
     * 百分比
     * @param gets
     * @returns {boolean}
     */
    'percent':function ( gets )
    {
        var reg = /(^[1-9][0-9]$)|(^100$)|(^[1-9]$)$/;
        if ( reg.test(gets) )
        {
            return true;

        }else
        {
            return false;
        }
    },
    'varcherlength':function ( gets, obj, curform, regxp )
    {
        var reg = regxp["n"];
        if ( reg.test(gets) )
        {
            if( gets < 1 || gets > 255 )
            {
                return false;
            }else
            {
                return true;
            }
        }else
        {
            return false;
        }
    }


});
