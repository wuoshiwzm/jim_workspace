<?php
/**
 * Created by PhpStorm.
 * User: 王顶峰
 * Date: 2016/5/18 0018
 * Time: 11:36
 */


//定义事件
Event::listen('event_name', function ($log) {
});


/**
 * 处理收货
 * $itemId:订单商品id
 */
Event::listen('item.receive', function ($itemId) {
    //判断订单是否已经完成
    $item = Source_Order_OrderItem::find($itemId);
    $order = Source_Order_OrderInfo::find($item->order_id);

    Source_Order_OrderInfo::where('id', $item->order_id)->update([
        'status' => 6,
    ]);
    $action['order_id'] = $order->id;
    $action['order_status'] = 6;
    $action['pay_status'] = 2;
    $action['option_id'] = Session::get('member')->id;
    $action['option_name'] = Session::get('member')->name;
    $action['remark'] = '订单' . $order->order_sn . '下商品' . $item->product_name . '买家已收货物品';

    Source_Order_OrderAction::create($action);

    //判断 是否有未完成的商品， 没有的话 更改整个订单的状态
    $unfinished = Source_Order_OrderItem::where('order_id', $item->order_id)->where('shipping_status', '!=', 3)->count();

    if ($unfinished) {
        return;
    }

    //更新整个订单为完成
    Source_Order_OrderInfo::where('id', $item->order_id)->update([
        'status' => 7,
    ]);
    $action['order_id'] = $order->id;
    $action['order_status'] = 7;
    $action['pay_status'] = 2;
    $action['option_id'] = Session::get('member')->id;
    $action['option_name'] = Session::get('member')->name;
    $action['remark'] = '买家订单' . $order->order_sn . '下商品已全部收货完成';

    Source_Order_OrderAction::create($action);

});

/**
 * 退货
 */
Event::listen('item.refund', function ($backInfo) {
    //array(6) { ["order_back_id"]=> int(4) ["option_type"]=> int(1) ["option_id"]=> int(4)
    // ["option_name"]=> string(4) "test" ["status"]=> string(19) "提交退款/退货"
    // ["remark"]=> string(73) "用户test新提交退款/退货，退货单号：order_back1486303500569" }

    //添加退货事件
    Source_Order_OrderBackAction::create($backInfo);
    $orderId = Source_Order_OrderBack::where('id',$backInfo['order_back_id'])
        ->first()
        ->order_id;
    //更改对应订单状态为

    $order = Source_Order_OrderInfo::where('id',$orderId)->update(
        [
            'status'=>8,
        ]
    );


});

/**
 * 评论
 */
Event::listen('item.review', function ($itemId) {

});



/**
 * 投诉
 */
Event::listen('item.feedback', function ($itemId) {

    /*$feedback = Source_Feedback_FeedbackInfo::where('user_id',Session::get('member')->id)
        ->where('item_id', $itemId)->first();

    $feedbackInfo['feedback_id'] = $feedback->id;
    $feedbackInfo['user_id'] = Session::get('member')->id;
    $feedbackInfo['re_remark'] = $feedback->re_remark;*/

});



/**
 * 商品状态改变
 */
Event::listen('product.changeStatus', function ($entityId, $status) {

    //如果 商品下架，更新收藏表对应商品为失效
    if ($status == 0) {
        Source_User_UserInfoCollect::where('entity_id', $entityId)->update([
            'is_show' => 0
        ]);
    }
});


Event::listen('option.order', function ($input) {
    $orderinfo = Source_Order_OrderInfo::find($input['orderid']);
    $info = new  Source_Order_OrderAction();
    $info->order_id = $input['orderid'];
    $info->order_status = $orderinfo->status;
    $info->pay_status = $orderinfo->pay_status;
    $info->option_id = $input['user']->id;
    $info->option_name = $input['user']->name;
    $info->remark = $input['content'];
    $info->created_at = TimeTools::getFullTime();
    $info->save();

});

/**
 *  详情页日志
 */
Event::listen('product.log', function ( $pid ) {
    if( checkrobot() == false )
    {
        $user = Session::get('member');
        $data['user_id'] = $user?$user->id:'';
        $data['browser'] = getBroswer().'/'.get_os();
        $data['ip_address'] = Request::getClientIp();
        $data['type'] = 1;
        $data['vs_value'] = $pid;
        $data['created_at'] = $data['updated_at'] = date("Y-m-d H:i:s");
        Source_System_Log_VisitorsLog::insert( $data );
    }
});

Event::listen('admin.cache.home', 'AdminCacheHome');

/**
 * 后台更改数据的时候自动清理缓存
 */
Event::listen('admin.operational.data', function ( $type ) {

    switch ( (int)$type )
    {
        case 1://操作产品时
            Cache::tags('goods','screen','goodsListScreenBrand','goodsList')->flush();
            break;
        case 2://分类
            Cache::tags('category')->flush();
            break;
        case 3://品牌
            Cache::tags('goodsListScreenBrand','brand')->flush();
            break;
        case 4://属性
            Cache::tags('attrbute','screen')->flush();
            break;
        case 5://友情链接
            Cache::tags('link')->flush();
            break;
        case 6://广告
            Cache::tags('ads')->flush();
            break;
        case 7://配置信息
            Cache::tags('config')->flush();
            break;
        case 8://检索功能
            Cache::tags('goodsListScreenBrand','screen')->flush();
            break;
    }
});