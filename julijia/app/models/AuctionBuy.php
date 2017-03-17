<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30 0030
 * Time: 17:05
 */
class AuctionBuy
{


    /**
     * -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *
     *
     *    立即购买
     *
     *  -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

    /**
     * @param $data
     * @return string
     * 立即购买post转换get规格转换
     */
    static function purchase( $data )
    {
        $arr = array();
        if( isset($data['guige']) )
        {
            foreach ( $data['guige'] as $row )
            {
                if( $row )
                {
                    $str = explode('|',$row);
                    $arr[$str[0]] = isset($str[1]) ? $str[1] : '';
                }
            }
        }
        $guige = count($arr)?json_encode( $arr ):'';
        return $guige ? encode($guige) :'';
    }
    /**
     * @param $data
     * @return array
     * 生成立即购买数据
     */
    static function buyNow( $data, $res, $region=null )
    {

        $arr = array();
        //产品数据
        $g = $data['g'] ? decode( $data['g'] ) : '';
        $obj = new stdClass();
        $obj->product_id = $res->entity_id;
        $obj->product_name = $res->name;
        $obj->guige = $g;
        $obj->num = decode( $data['num'] );
        $obj->price = number_format(decode( $data['j'] ),2,'.','');
        //暂未确定的优惠信息
        $obj->discount = '';
        $obj->small_image = $res->small_image;
        $obj->shop_id = $res->shop;
        $obj->weight = $res->weight;
        $obj->sku = $res->sku;
        $result = $obj;

        //合计数据
        $sum = new stdClass();
        $sum->cost_item = number_format($obj->price*$obj->num,2,'.','');
        $sum->itemnum = $obj->num;
        //暂未确定的优惠信息
        $sum->cost_freight = number_format(0,2,'.','');
        //运费
        $type = $res->type > 2?1:0;
        $shipping_amount = Freight::DetailFreight( $res->freight, $res->weight, 0, $obj->num,$type, $region)->price;
        $sum->shipping_amount = number_format($shipping_amount,2,'.','');
        //总价
        $sum->total_amount = number_format(($sum->cost_item+$sum->shipping_amount),2,'.','');
        //支付价格
        $sum->pay_amount = number_format(($sum->total_amount - $sum->cost_freight),2,'.','');
        $sum->subject = $res->name;
        $totaled = $sum;
        $arr['goods'] = $result;
        $arr['totaled '] = $totaled;
        return $arr;
    }


    /**
     * @param $data
     * @return bool
     * 提交下单购买
     */
    static function orderSave( $goodsData,$data, $order_sn  )
    {
        $result = DB::transaction(function() use ( $goodsData, $data, $order_sn ) {

            $goods = $goodsData['goods'];
            //合计信息
            $totaled = $goodsData['totaled '];
            $address =  $data['address'];
            //地址
            $adr = Source_User_UserInfoAdd::where('id',$address)->first();
            //订单主表
            $orderInfo = new Source_Order_OrderInfo();
            $orderInfo->order_sn = $order_sn;
            $orderInfo->user_id = $adr->user_id;
            $orderInfo->source = 1;
            $orderInfo->status = 1;
            $orderInfo->pay_status = 1;
            $orderInfo->payment = $data['payment'];
            $orderInfo->itemnum = $totaled->itemnum;
            $orderInfo->ship_name = $adr->name;
            $province = isset($adr->provinceInfo->province)?$adr->provinceInfo->province:"";
            $city = isset($adr->cityInfo->city)?$adr->cityInfo->city:"";
            $district = isset($adr->areaInfo->area)?$adr->areaInfo->area:"";
            $orderInfo->ship_addr = $province.$city.$district.$adr->address;
            $orderInfo->ship_post = $adr->zipcode;
            $orderInfo->ship_phone = $adr->phone;
            $orderInfo->cost_item = number_format($totaled->cost_item,2,'.','');
            $orderInfo->cost_freight = number_format($totaled->cost_freight,2,'.','');
            $orderInfo->shipping_amount = number_format($totaled->shipping_amount,2,'.','');
            $orderInfo->total_amount = number_format($totaled->total_amount,2,'.','');
            $orderInfo->pay_amount = number_format($totaled->pay_amount,2,'.','');
            $orderInfo->save();
            //订单附表
            $orderItem = new Source_Order_OrderItem();
            $orderItem->order_id = $orderInfo->id;
            $orderItem->shop_id = $goods->shop_id;
            $orderItem->product_id = $goods->product_id;
            $orderItem->product_name = $goods->product_name;
            $orderItem->product_status = 1;
            $orderItem->sku = $goods->sku;
            $orderItem->price = number_format($goods->price,2,'.','');
            $orderItem->weight = $goods->weight;
            $orderItem->row_total = number_format(($goods->num*$goods->price),2,'.','');
            $orderItem->row_weigth = $goods->num*$goods->weight;
            $orderItem->num = $goods->num;
            $orderItem->guige = $goods->guige;
            $orderItem->shipping_status = 1;
            $orderItem->desc = $data['desc'];
            $orderItem->save();
            //订单动作表
            $orderAction = new Source_Order_OrderAction();
            $orderAction->order_id = $orderInfo->id;
            $orderAction->order_status = 1;
            $orderAction->shipping_status = 0;
            $orderAction->pay_status = 0;
            $orderAction->option_id = $adr->user_id;
            $orderAction->option_name = $adr->name;
            $orderAction->remark = '立即购买提交订单'.$order_sn;
            $orderAction->save();
        });
        if ( is_null($result) )
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     *  没登录用户下单
     */
    static function dontLogInOrderSave( $goodsData, $data, $order_sn )
    {
        $result = DB::transaction(function() use ( $goodsData, $data, $order_sn ) {

            $goods = $goodsData['goods'];
            //合计信息
            $totaled = $goodsData['totaled '];
            //注册用户信息
            $userInfo = new Source_User_UserInfo();
            $userInfo->name = $data['name'];
            $userInfo->real_name = $data['real_name'];
            $userInfo->group_id = Source_User_UserInfoGroup::orderBy('beg_points')->first()->id;
            $userInfo->password = Crypt::encrypt($data['password']);
            $userInfo->mobile_phone = $data['phone'];
            $userInfo->last_time = date("Y-m-d H:i:s");
            $userInfo->last_ip = Request::getClientIp();
            $userInfo->save();
            Session::put('member', $userInfo );
            //地址
            $adr = new Source_User_UserInfoAdd();
            $adr->user_id = $userInfo->id;
            $adr->name = $userInfo->name;
            $adr->phone = $userInfo->mobile_phone;
            $adr->province = $data['province'];
            $adr->city = $data['city'];
            $adr->district = $data['area'];
            $adr->address = $data['address'];
            $adr->status = 1;
            $adr->save();

            //订单主表
            $orderInfo = new Source_Order_OrderInfo();
            $orderInfo->order_sn = $order_sn;
            $orderInfo->user_id = $adr->user_id;
            $orderInfo->source = 1;
            $orderInfo->status = 1;
            $orderInfo->pay_status = 1;
            $orderInfo->payment = $data['payment'];
            $orderInfo->itemnum = $totaled->itemnum;
            $orderInfo->ship_name = $adr->name;

            //运费
            $province = isset($adr->provinceInfo->province)?$adr->provinceInfo->province:"";
            $city = isset($adr->cityInfo->city)?$adr->cityInfo->city:"";
            $district = isset($adr->areaInfo->area)?$adr->areaInfo->area:"";
            $orderInfo->ship_addr = $province.$city.$district.$adr->address;
            $orderInfo->ship_post = $adr->zipcode;
            $orderInfo->ship_phone = $adr->phone;
            $orderInfo->cost_item = number_format($totaled->cost_item,2,'.','');
            $orderInfo->cost_freight = number_format($totaled->cost_freight,2,'.','');
            $orderInfo->shipping_amount = number_format($totaled->shipping_amount,2,'.','');
            $orderInfo->total_amount = number_format($totaled->total_amount,2,'.','');
            $orderInfo->pay_amount = number_format($totaled->pay_amount,2,'.','');
            $orderInfo->save();
            //订单附表
            $orderItem = new Source_Order_OrderItem();
            $orderItem->order_id = $orderInfo->id;
            $orderItem->shop_id = $goods->shop_id;
            $orderItem->product_id = $goods->product_id;
            $orderItem->product_name = $goods->product_name;
            $orderItem->product_status = 1;
            $orderItem->sku = $goods->sku;
            $orderItem->price = number_format($goods->price,2,'.','');
            $orderItem->weight = $goods->weight;
            $orderItem->row_total = number_format(($goods->num*$goods->price),2,'.','');
            $orderItem->row_weigth = $goods->num*$goods->weight;
            $orderItem->num = $goods->num;
            $orderItem->guige = $goods->guige;
            $orderItem->shipping_status = 1;
            $orderItem->desc = $data['desc'];
            $orderItem->save();
            //订单动作表
            $orderAction = new Source_Order_OrderAction();
            $orderAction->order_id = $orderInfo->id;
            $orderAction->order_status = 1;
            $orderAction->shipping_status = 0;
            $orderAction->pay_status = 0;
            $orderAction->option_id = $adr->user_id;
            $orderAction->option_name = $adr->name;
            $orderAction->remark = '立即购买提交订单'.$order_sn;
            $orderAction->save();
        });
        if ( is_null($result) )
        {
            return true;
        }else
        {
            Session::put('member', false );
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     * 验证订单数据
     */
    static function validatorOrder( $data )
    {
        $rules =  [
            'pid' => 'required',
            'g' => 'required',
            'num' => 'required',
            'j' => 'required',
            'address' => 'required',
            'payment' => 'required',
        ];
        $message = [];
        $validator = Validator::make( $data, $rules, $message );
        if( $validator->passes() )
        {
            return true;

        }else
        {
            return $validator;
        }
    }


    /**
     * @param $data
     * @return bool
     * 不登录立即下单
     */
    static function validatorDontLogInOrder( $data )
    {
        $rules =  [
            'pid' => 'required',
            'g' => 'required',
            'num' => 'required',
            'j' => 'required',
            'name'=> 'required',
            'real_name'=> 'required',
            'password' => 'required',
            'phone' => 'required',
            'code' => 'required',
        ];
        $validator = Validator::make( $data, $rules );
        if( $validator->passes() )
        {
            if( $data['code'] == Session::get('sms')['smsCode'] && $data['phone'] == Session::get('sms')['phone'] )
            {
                return true;
            }
            else return false;

        }else
        {
            return $validator;
        }
    }

    /**
     * -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *
     *   订单客户数据
     *
     * -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    /**
     * @param $data
     * @param $user
     * @return bool
     * 添加地址
     */
    static  function  addAddress( $data, $user )
    {
        $data['user_id'] = $user->id;
        $data['district'] = isset($data['area'])?$data['area']:'';
        $data = array_except($data, ['_token','area']);
        $status = isset($data['status'])? true: false;
        if ( $status )
        {
            Source_User_UserInfoAdd::where('user_id',$user->id)->update(['status'=>0]);
        }else
        {
            $addCount = Source_User_UserInfoAdd::where('user_id',$user->id)->count();
            if( $addCount == false )
            {
                $data['status'] = 1;
            }
        }
        $res = Source_User_UserInfoAdd::firstOrCreate( $data );
        return $res? true : false;
    }


    /**
     * @param $data
     * @param $user
     * @return bool
     * 修改地址
     */
    static function editAddress( $data, $user )
    {
        $data['district'] = isset($data['area'])?$data['area']:'';
        $id = decode($data['aid']);
        $data = array_except($data, ['_token','area','aid']);
        $status = isset($data['status'])? true: false;
        if ( $status ){ Source_User_UserInfoAdd::where('user_id',$user->id)->update(['status'=>0]); }
        $res = Source_User_UserInfoAdd::where('id',$id)->update( $data );
        return $res? true : false;
    }


    /**
     * -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *
     *   购物车购买
     *
     * -++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

    /**
     * 产生购物车确认的数据
     */

    static function cartOrderData( $itemId, $user, $region )
    {
        $arr = explode(',',$itemId);
        $pid = array();
        foreach ( $arr as $row )
        {
            $pid[] = decode($row);
        }
        $arr = array();
        $result = array();
        $productInfo = Source_Cart_CartItem::whereIn('product_id',$pid)->where('user_id',$user->id)->get();
        if( count($productInfo) == false )
        {
            return false;
        }
        $price = $num = $cost_freight = $freightpriceAll = 0;
        $name = '';
        foreach ( $productInfo as $res )
        {
            //判断真实的库存
            $pNum = Source_Product_ProductFlat::where(['entity_id'=>$res->product_id])->pluck('kc_qty');
            if( $pNum < $res->num )
            {
                $numone = $pNum;
            }else
            {
                $numone = $res->num;
            }

            $obj = new stdClass();
            $obj->product_id = $res->product_id;
            $obj->product_name = $res->product_name;
            $obj->guige = $res->guige;
            $obj->num = $numone;
            $obj->price = number_format($res->price,2,'.','');
            //暂未确定的优惠信息
            $obj->discount = number_format($res->discount,2,'.','');
            $obj->small_image = $res->small_image;
            $obj->shop_id = $res->shop_id;
            $obj->weight = $res->weight;
            $obj->sku = $res->sku;
            $freight = Freight::DetailFreight( $res->freight, $res->weight, 0, $obj->num, $res->free_shipping,$region);
            $obj->freight = $freight;
            $obj->freightprice = $freight->price;

            $result[] = $obj;
            //合计价格
            $price += $obj->price*$obj->num;
            //合计数量
            $num += $obj->num;
            //合计优惠
            $cost_freight += $obj->discount;
            //商品名称
            $name .= $res->product_name.'  ';
            //运费合计
            $freightpriceAll += $obj->freightprice;
        }
        //合计数据
        $sum = new stdClass();
        $sum->cost_item = number_format($price,2,'.','');
        $sum->itemnum = $num;
        //暂未确定的优惠信息
        $sum->cost_freight = number_format($cost_freight,2,'.','');
        //暂未确定的运费
        $sum->shipping_amount = number_format($freightpriceAll,2,'.','');
        $sum->total_amount = number_format(($sum->cost_item+$sum->shipping_amount),2,'.','');
        $sum->pay_amount = number_format(($sum->total_amount - $sum->cost_freight),2,'.','');
        $sum->subject = $name;
        $totaled = $sum;
        //产品数据
        $arr['goods'] = $result;
        $arr['totaled '] = $totaled;
        return $arr;
    }


    /**
     * @param $goodsData
     * @param $data
     * @param $order_sn
     * @return bool
     * 购物车下订单
     */
    static function cartOrderSave( $goodsData, $data, $order_sn )
    {
        $result = DB::transaction(function() use ( $goodsData, $data, $order_sn ) {

            $goodsArr = $goodsData['goods'];
            //合计信息
            $totaled = $goodsData['totaled '];
            $address =  $data['address'];
            //地址
            $adr = Source_User_UserInfoAdd::where('id',$address)->first();
            //订单主表
            $orderInfo = new Source_Order_OrderInfo();
            $orderInfo->order_sn = $order_sn;
            $orderInfo->user_id = $adr->user_id;
            $orderInfo->source = 1;
            $orderInfo->status = 1;
            $orderInfo->pay_status = 1;
            $orderInfo->payment = $data['payment'];
            $orderInfo->itemnum = $totaled->itemnum;
            $orderInfo->ship_name = $adr->name;
            $province = isset($adr->provinceInfo->province)?$adr->provinceInfo->province:"";
            $city = isset($adr->cityInfo->city)?$adr->cityInfo->city:"";
            $district = isset($adr->areaInfo->area)?$adr->areaInfo->area:"";
            $orderInfo->ship_addr = $province.$city.$district.$adr->address;
            $orderInfo->ship_post = $adr->zipcode;
            $orderInfo->ship_phone = $adr->phone;
            $orderInfo->cost_item = number_format($totaled->cost_item,2,'.','');
            $orderInfo->cost_freight = number_format($totaled->cost_freight,2,'.','');
            $orderInfo->shipping_amount = number_format($totaled->shipping_amount,2,'.','');
            $orderInfo->total_amount = number_format($totaled->total_amount,2,'.','');
            $orderInfo->pay_amount = number_format($totaled->pay_amount,2,'.','');
            $orderInfo->save();
            //订单附表
            
            foreach ( $goodsArr as $k=>$goods )
            {
                $orderItem = new Source_Order_OrderItem();
                $orderItem->order_id = $orderInfo->id;
                $orderItem->shop_id = $goods->shop_id;
                $orderItem->product_id = $goods->product_id;
                $orderItem->product_name = $goods->product_name;
                $orderItem->product_status = 1;
                $orderItem->sku = $goods->sku;
                $orderItem->price = number_format($goods->price,2,'.','');
                $orderItem->weight = $goods->weight;
                $orderItem->row_total = number_format(($goods->num*$goods->price),2,'.','');
                $orderItem->row_weigth = $goods->num*$goods->weight;
                $orderItem->num = $goods->num;
                $orderItem->guige = $goods->guige;
                $orderItem->shipping_status = 1;
                $orderItem->desc = $data['desc'][$k];
                $orderItem->save();
                //删除购物车
                Source_Cart_CartItem::where('user_id',$adr->user_id)->where('product_id',$goods->product_id)->delete();
            }

            //订单动作表
            $orderAction = new Source_Order_OrderAction();
            $orderAction->order_id = $orderInfo->id;
            $orderAction->order_status = 1;
            $orderAction->shipping_status = 0;
            $orderAction->pay_status = 0;
            $orderAction->option_id = $adr->id;
            $orderAction->option_name = $adr->name;
            $orderAction->remark = '购物车提交订单'.$order_sn;
            $orderAction->save();
            //重新获取购物车数据
            Session::put('cartCount', 0);

        });
        if ( is_null($result) )
        {
            return true;
        }else
        {
            return false;
        }
    }
}