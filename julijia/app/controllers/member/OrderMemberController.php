<?php

// use app\controllers\user\user\LeonEvent;
use Omnipay\Omnipay;

class OrderMemberController extends CommonController
{

    private $user_id;
    private $orders;
    protected $layout = 'layouts.member.index';


    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }

    }

    public function view($path, $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }


    function __construct()
    {
        if (!Session::has('member')) {
            return Redirect::to('member/login');
        }

        $userInfo = Session::get('member');
        View::share('userinfo',$userInfo);

        $this->user_id = $userInfo->id;
        //非已取消和无效订单
        $this->orders = Source_Order_OrderInfo::where('user_id', $this->user_id)
            ->whereNotIn('status',array(2,3))
            ->orderBy('created_at','desc');

        //计数信息
        $numOrders = 0;
        $numToPay = 0;
        $numToShip = 0;
        $numToReceive = 0;
        $numToReview = 0;


        foreach ($this->orders->get() as $order) {

            $numOrders++;
            if ($order->pay_status == 1) {
                $numToPay++;
            } elseif ($order->pay_status == 3) {
                //待发货计数
                foreach ($order->item as $item) {
                    if ($item->shipping_status == 1) {
                        $numToShip++;
                        break;
                    }
                }

                //待收货计数
                foreach ($order->item as $item) {
                    if ($item->shipping_status == 2) {
                        $numToReceive++;
                        break;
                    }
                }

                //待评价计数
                foreach ($order->item as $item) {
                    if ($item->shipping_status == 3 && $item->review->count() == 0) {
                        $numToReview++;
                        break;
                    }
                }
            }
        }

        View::share('numOrders', $numOrders);
        View::share('numToPay', $numToPay);
        View::share('numToShip', $numToShip);
        View::share('numToReceive', $numToReceive);
        View::share('numToReview', $numToReview);
        parent::__construct();

    }

    /**
     * 欢迎页 -- 全部订单信息
     */
    function welc()
    {

        //获取待收货订单
        $orders = Source_Order_OrderInfo::where('user_id',$this->user_id)->get();

        $items = [];

        //获取订单下的商品并插入订单表 $orders

        foreach ($orders as $order) {
            $res = Source_Order_OrderItem::where('order_id',$order->id)
                ->where('shipping_status',2)->get();

            if (!empty($res)) {
                foreach ($res as $r) {
                    $items[] = $r;
                }
            }
        }

        //物流信息
        foreach ($items as $item) {
            $Orderinfo['shiptype'] = $item->shipping_m_code;
            $Orderinfo['shipno'] = $item->shipping_id;
            $shipper = new ShippingApi();
            $res = json_decode($shipper->getOrderTracesByJson($Orderinfo));

            if (!$res->Success) {
                $item->shipping_station = '处理中';
                $item->shipping_time = date('Y-m-d H:m:s', time());
            } else {
                if(!empty($res->Traces)){
                    $item->shipping_station = end($res['Traces'])['AcceptStation'];
                    $item->shipping_time = end($res['Traces'])['AcceptTime'];
                }
            }
        }
        //获取我的足迹
        $goods = Session::get('member')->visitor->filter(function ($r) {
            return $r->type == 1;
        });
        $userinfo = (Cache::get('userheader'))!=null?Cache::get('userheader'):Session::get('member')->header;
        $userheader=Config::get('tools.imagePath').'/user/'.$this->user_id.'/'.$userinfo;
        return $this->view('member.welc', compact('items', 'goods','userheader'));
    }

    /**
     * 全部订单信息
     * 1待付款; 2已取消; 3无效; 4待发货 5待收货 6部分完成 7完成 8退款退货 9退款完成 10部分发货
     */
    function index()
    {
        $setPage = !is_null(Input::get('setpage'))?Input::get('setpage') :   Config::get('tools.memberPage');
        $set['setpage'] = $setPage;
        //获取订单下的商品并插入订单表 $orders
        $orders = $this->orders->whereIn('status',array(1,4,5,6,7,8,9,10))->paginate($setPage);

        return $this->view('member.order.all', compact('orders', 'set'));
    }


    /**
     * 等待付款
     */
    function toPay()
    {

        $setPage = Input::get('setpage') ? Input::get('setpage') : self::$memberPage;
        $set['setpage'] = $setPage;
        //获取订单
        $orders = $this->orders
            ->where('pay_status',1)
            ->paginate($setPage);

        return $this->view('member.order.to_pay', compact('orders', 'set'));
    }

    /**
     * 等待发货
     */
    function toShip()
    {
        $setPage = Input::get('setpage') ? Input::get('setpage') : self::$memberPage;
        $set['setpage'] = $setPage;
        //获取订单
        $orders = $this->orders->whereIn('status',array(4,10))->paginate($setPage);
        return $this->view('member.order.to_ship', compact('orders', 'set'));
    }

    /**
     * 等待收货
     * 1待付款; 2已取消; 3无效; 4待发货 5待收货 6部分完成 7完成 8退款退货 9退款完成 10部分发货
     */
    function toReceive()
    {
        $setPage = Input::get('setpage') ? Input::get('setpage') : self::$memberPage;
        $set['setpage'] = $setPage;
        //获取订单
        $orders = $this->orders->whereIn('status',array(5,6))->paginate($setPage);
        //分页
        return $this->view('member.order.to_receive', compact('orders', 'set'));
    }

    /**
     * 等待评价
     */
    function toComment()
    {

        $setPage = Input::get('setpage') ? Input::get('setpage') : self::$memberPage;
        $set['setpage'] = $setPage;




        //获取订单
        $sql = $this->orders;
        $sql->whereHas('item', function ($q)
        {
            $q->where('shipping_status','3');
            $q->whereNotIn('id',function($q){
                $q->select('item_id')->from('order_review');
            });
        });
        $orders= $sql->paginate($setPage);


        /*$action['orderid']='16';
        $action['user']=Session::get('member');
        $action['content']='ces';
        event::fire('option.order',array($action));*/
        //订单内无商品对应此页,则不显示该订单内容
        return $this->view('member.order.to_comment', compact('orders', 'data', 'set'));
    }

    /**
     * 收货
     */
    public function receive()
    {
        $input = trimValue(Input::all());

        $res = Source_Order_OrderItem::where('id', decode($input['itemId']))->update(['shipping_status' => 3]);
        $n= Source_Order_OrderItem::where('order_id',decode($input['OrderId']))->count();
        $b=  Source_Order_OrderItem::where('order_id',decode($input['OrderId']))->where('shipping_status',3)->count();
        if($n==$b){
            Source_Order_OrderInfo::where('id',decode($input['OrderId']))->update(array('status'=>7));
        }else{
            Source_Order_OrderInfo::where('id',decode($input['OrderId']))->update(array('status'=>6));
        }
        if ($res) {
            //订单操作日志
            $action['orderid']=decode($input['OrderId']);
            $action['user']=Session::get('member');
            $action['content']='订单'.decode($input['OrderId']).'已经收货';
            event::fire('option.order',array($action));
            $obj = new stdClass();
            $obj->status = 0;
            $obj->msg = '确认收货成功';
            return json_encode($obj);

        } else {
            $obj = new stdClass();
            $obj->status = 1;
            $obj->msg = '失败';
            return json_encode($obj);
        }
    }

    public function remove($rowId)
    {
        $rowId = decode($rowId);
        $res = DB::transaction(function () use($rowId){
            Source_Order_OrderInfo::where('id',$rowId)->update(array('status'=>2));
        });

        if(is_null($res)){
            //订单删除事件
            Event::fire('order.remove',$rowId);
            return 'true';
        }

    }

    public function  removeItem($rowId){
        $rowId = decode($rowId);
        $m =   Source_Order_OrderItem::find($rowId);
        $res = DB::transaction(function () use($rowId,$m){
            $c = Source_Order_OrderItem::where('order_id',$m->order_id)->count();
            if($c>1 ){
                $o =  Source_Order_OrderInfo::find($m->order_id);
                $o->cost_item =(float)$o->cost_item - $m->row_total;
                $o->total_amount = (float)$o->total_amount - $m->row_total ;
                $o->pay_amount = (float)($o->pay_amount - $m->row_total);
                $o->save();
                $m->delete();
            }
            return false;
        });

        if(is_null($res)){
            //订单删除事件
            return Redirect::to( '/member/order/detail/'.encode($m->order_id) );
        }
        return Redirect::to( '/member/order/detail/'.encode($m->order_id) )->with('msg','删除失败');
    }

    public function  PayOrder()
    {
        $orderid = decode(trim(Input::get('order_id'))) ;
        $orderinfo = Source_Order_OrderInfo::find($orderid);
        if($orderinfo){
            $items =  $orderinfo->item()->get();
            $name ='';
            foreach ($items as $item){
                $name.=$item->product_name.' ';
            }
            if($orderinfo->payment ==1){
                $return_url = Input::getUriForPath('/pay/return');
                $notify_url = Input::getUriForPath('/pay/notify');
                $gateway = Omnipay::create('Alipay_Express');
                $gateway->setPartner(Config::get('pay.id'));
                $gateway->setKey(Config::get('pay.key'));
                $gateway->setSellerEmail(Config::get('pay.email'));
                $gateway->setNotifyUrl($notify_url);
                $gateway->setReturnUrl($return_url);
                $order = array(
                    'out_trade_no' => $orderinfo->order_sn,
                    'subject' =>$name,
                    'total_fee' => $orderinfo->pay_amount,
                );
                $response = $gateway->purchase($order)->send();
                return Redirect::to($response->getRedirectUrl());
            }elseif($orderinfo->payment ==2)
            {
                $orderInfo = Source_Order_OrderInfo::where('order_sn',$orderinfo->order_sn)->first();
                $order_new_sn = date('YmdHis').rand(100000,999999);
                $orderInfo->order_sn = $order_new_sn;
                $orderInfo->updated_at =  $orderInfo->updated_at;
                $orderInfo->save();
                return Redirect::to( '/weixin/geturl?order_sn='.encode($order_new_sn) );
            }

        }
        return  false;

    }


}