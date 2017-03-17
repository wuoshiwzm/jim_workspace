/**
 * Created by Administrator on 14-12-01.
 * 模拟淘宝SKU添加组合
 * 页面注意事项：
 *      1、 .div_contentlist   这个类变化这里的js单击事件类名也要改
 *      2、 .Father_Title      这个类作用是取到所有标题的值，赋给表格，如有改变JS也应相应改动
 *      3、 .Father_Item       这个类作用是取类型组数，有多少类型就添加相应的类名：如: Father_Item1、Father_Item2、Father_Item3 ...
 */
$(function () {
    //SKU信息
    $(".plist .form-control-box label").bind("change", function () {
        step.Creat_Table();
    });
    var step = {
        //SKU信息组合
        Creat_Table: function () {
            var SKUObj = $(".Father_Title");
            var arrayTile = [];//标题组数
            var arrayName = [];//标题name
            var arrayInfor = [];//盛放每组选中的CheckBox值的对象
            var arrayColumn = [];//指定列，用来合并哪些列
            var bCheck = true;//是否全选
            var columnIndex = 0;
            $.each(SKUObj, function (i, item){
                arrayColumn.push(columnIndex);
                columnIndex++;
                arrayTile.push(SKUObj.eq(i).html().replace("：", ""));
                arrayName.push(SKUObj.eq(i).data('id'));
                var itemName = "Father_Item" + i;
                //选中的CHeckBox取值
                var order = [];
                var valueText = [];
                $("." + itemName + " input[type=checkbox]:checked").each(function (){
                    order.push( $(this).next('span').html());
                });
                arrayInfor.push(order);
                if (order.join() == ""){
                    bCheck = false;
                }
            });
            //开始创建Table表
            if (bCheck == true) {
                var RowsCount = 0;
                $("#createTable").html("");
                var table = $("<table class=\"table table-hover\" style=\"border-bottom:0!important\" id=\"process\"></table>");
                table.appendTo($("#createTable"));
                var thead = $("<thead></thead>");
                thead.appendTo(table);
                var trHead = $("<tr></tr>");
                trHead.appendTo(thead);
                //创建表头
                $.each(arrayTile, function (index, item) {
                    var td = $("<th class=\"w60\">" + item + "</th>");
                    td.appendTo(trHead);
                });
                var itemColumHead = $("<th class=\"w150\">价格</th>");
                itemColumHead.appendTo(trHead);
                var tbody = $("<tbody></tbody>");
                tbody.appendTo(table);
                ////生成组合
                var zuheDate = step.doExchange(arrayInfor);
                if (zuheDate.length > 0) {
                    //创建行
                    $.each(zuheDate, function (index, item) {
                        var td_array = item.split(",");
                        var tr = $("<tr></tr>");
                        tr.appendTo(tbody);
                        $.each(td_array, function (i, values) {
                            var newValue = values.match( /<img.*?src="(.*?)".*?>/ );
                            if( newValue != null )
                            {
                                var path = values.match(/<img.*?data-value="(.*?)".*?>/);
                                newValue = path[1];
                                var text = values.match(/<img.*?data-v="(.*?)".*?>/);
                                var newText = text[1];
                                var td = $("<td>" + values + "</td>"+"<input type=\"hidden\" name="+arrayName[i]+'[]'+" value="+newValue+'|'+newText+">");
                            }else
                            {
                                newValue = values;
                                var td = $("<td>" + values + "</td>"+"<input type=\"hidden\" name="+arrayName[i]+'[]'+" value="+newValue+">");
                            }
                              td.appendTo(tr);
                        });
                        //添加隐藏值
                        var td1 = $("<td ><input type=\"text\" name=\"p[]\" class=\"form-control w90\" maxlength='6'> / 件</td>");
                        td1.appendTo(tr);
                    });
                }
                //结束创建Table表
                arrayColumn.pop();//删除数组中最后一项
                //合并单元格
                $(table).mergeCell({
                    // 目前只有cols这么一个配置项, 用数组表示列的索引,从0开始
                    cols: arrayColumn
                });
            } else{
                //未全选中,清除表格
                document.getElementById('createTable').innerHTML="";
            }
        },
        //组合数组
        doExchange: function (doubleArrays) {
            var len = doubleArrays.length;
            if (len >= 2) {
                var arr1 = doubleArrays[0];
                var arr2 = doubleArrays[1];
                var len1 = doubleArrays[0].length;
                var len2 = doubleArrays[1].length;
                var newlen = len1 * len2;
                var temp = new Array(newlen);
                var index = 0;
                for (var i = 0; i < len1; i++) {
                    for (var j = 0; j < len2; j++) {
                        temp[index] = arr1[i] + "," + arr2[j];
                        index++;
                    }
                }
                var newArray = new Array(len - 1);
                newArray[0] = temp;
                if (len > 2) {
                    var _count = 1;
                    for (var i = 2; i < len; i++) {
                        newArray[_count] = doubleArrays[i];
                        _count++;
                    }
                }
                //console.log(newArray);
                return step.doExchange(newArray);
            }
            else {
                return doubleArrays[0];
            }
        }
    };
    return step;
});