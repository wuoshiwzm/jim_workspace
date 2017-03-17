<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3 0003
 * Time: 17:32
 */
use Omnipay\Omnipay;
class AlipayController extends \BaseController
{

    /**
     * 支付宝返回同步通知信息
     */
    public function pay_return()
    {
        $gateway = Omnipay::create('Alipay_Express');
        $gateway->setPartner(Config::get('pay.id'));
        $gateway->setKey(Config::get('pay.key'));
        $gateway->setSellerEmail(Config::get('pay.email'));
        $options['request_params'] = Input::all();
        $options['ca_cert_path'] = storage_path() . '/cert/cacert.pem';
        $options['sign_type'] = 'MD5';
        $request = $gateway->completePurchase($options)->send();
        if ( $request->isSuccessful() )
        {
            $trade_status = Input::get('trade_status');
            $data = Input::all();
            $this->payStatus( $data );
            if ( $trade_status == 'TRADE_SUCCESS' )
            {
                $data = Input::all();
                $this->payStatus( $data );
                return Redirect::to('/member/order/toship');

            }else
            {
                return Redirect::to('/member/order/topay');
            }

        }else
        {
            return Redirect::to('/member/order/topay');
        }

    }


    /**
     * 支付宝返回异步通知信息
     */
    public function pay_notify()
    {

        $gateway = Omnipay::create('Alipay_Express');
        $gateway->setPartner(Config::get('pay.id'));
        $gateway->setKey(Config::get('pay.key'));
        $gateway->setSellerEmail(Config::get('pay.email'));
        $options['request_params'] = Input::all();
        $options['ca_cert_path'] = storage_path() . '/cert/cacert.pem';
        $options['sign_type'] = 'MD5';
        $request = $gateway->completePurchase($options)->send();
        if ( $request->isSuccessful() )
        {
            $trade_status = Input::get('trade_status');
            if (  $trade_status == 'TRADE_SUCCESS' )
            {
                $data = Input::all();
                return  $this->payStatus( $data );
            }
        }else
        {
            die('fail');
        }
    }


    /**
     * @param $data
     * @return string
     * 修改订单状态
     */
    private function payStatus( $data )
    {
        //修改订单状态
        $orderInfo = Source_Order_OrderInfo::where('order_sn',$data['out_trade_no'])->first();
        if( $orderInfo->pay_status == 3 )
        {
            return 'success';
        }
        $result = DB::transaction(function() use( $orderInfo,$data )
        {
            //订单主表
            $orderInfo->payment_id = $data['trade_no'];
            $orderInfo->pay_status = 3;
            $orderInfo->status = 4;
            $orderInfo->save();
            //写支付宝记录
            $orderPay = new Source_Order_OrderPayment();
            $orderPay->order_id = $orderInfo->id;
            $orderPay->payment_account = $data['buyer_email'];
            $orderPay->payment_method = 1;
            $orderPay->payment_time = $data['notify_time'];
            $orderPay->cc_id = $data['buyer_id'];
            $orderPay->cc_total_fee = $data['total_fee'];
            $orderPay->cc_trade_no = $data['trade_no'];
            $orderPay->cc_status = $data['trade_status'];
            $orderPay->cc_time = $data['notify_time'];
            $orderPay->save();
            //支付宝信息
            $orderPayLog = new Source_Order_OrderPaymentLog();
            $orderPayLog->order_id = $orderInfo->id;
            $orderPayLog->payment_recive = json_encode($data);
            $orderPayLog->save();
            //写订单操作表
            $orderAction = new Source_Order_OrderAction();
            $orderAction->order_id = $orderInfo->id;
            $orderAction->order_status = 4;
            $orderAction->shipping_status = 0;
            $orderAction->pay_status = 2;
            $orderAction->option_id = $orderInfo->user_id;
            $orderAction->option_name = $orderInfo->ship_name;
            $orderAction->remark = '订单支付完成'.$data['out_trade_no'];
            $orderAction->save();
            //修改产品库存
            $Item = Source_Order_OrderItem::where('order_id',$orderInfo->id)->select('id','product_id','num','order_id')->get();
            foreach ( $Item as $i )
            {
                $ProductFlat = Source_Product_ProductFlat::where('entity_id',$i->product_id)->select('id','kc_qty','entity_id')->first();
                $ProductFlat->kc_qty = (int)($ProductFlat->kc_qty-$i->num);
                $ProductFlat->save();

                $Stock = Source_Product_ProductEntityStock::where('entity_id',$i->product_id)->select('id','stock','entity_id')->first();
                $Stock->stock = (int)($Stock->stock-$i->num);
                $Stock->save();
            }

            //添加用户积分
            $integral = getConfig('core','shop_jifen');
            $user_points = 0;
            if( $integral )
            {
                $integralArr =  explode(':',$integral);
                if( count($integralArr) > 1 )
                {
                    $user_points = floor($orderPay->cc_total_fee/$integralArr[0]*$integralArr[1]);
                }
            }
            $userInfo = Source_User_UserInfo::where( 'id',$orderInfo->user_id )->first();
            $userInfo->user_points = $userInfo->user_points+$user_points;
            $userInfo->save();
            //添加用户积分日志表
            $integralLog['user_id'] = $orderInfo->user_id;
            $integralLog['remarks'] = '用户购买商品赠送积分';
            $integralLog['integral'] =  '+'.$user_points;
            DB::table('integral_log')->insert($integralLog);
            
            //清理缓存
            Event::fire('admin.operational.data',array(1));
        });

        if ( is_null($result) )
        {
            return 'success';
        }else
        {
            return 'fail';
        }
    }
}