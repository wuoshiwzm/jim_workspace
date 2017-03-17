<?php

// use app\controllers\user\user\LeonEvent;

class CartMemberController extends \BaseController
{


    private $items;
    private $userId;

    protected $layout = 'layouts.frontend';


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

    /**
     * CartMemberController constructor.
     */
    function __construct()
    {
        $this->userId = Session::get('member')->id;
        $this->items = Cart::getContent()->get();

        parent::__construct();


    }

    /**
     *购物车首页
     */
    function index()
    {
        //测试
        //static function addItem($userId,$entityId, $quantity, $guige = null)
        //echo json_encode(array('颜色'=>'红色','尺寸'=>'xxl','包装'=>'小包')) ;
        //Cart::updateQty('sad4',1);
        //Cart::updateQty('sad3',1);

        /*测试添加商品*/
//        Cart::addItem('1479370490', 2, ["size" => "超大", "color" => "银灰"]);
//        Cart::addItem('1479372520', 2, ["size" => "超大", "color" => "银灰"]);
//        Cart::addItem('1479970726', 2, ["size" => "超大", "color" => "银灰"]);
//        Cart::addItem('1480497516', 2, ["size" => "超大", "color" => "银灰"]);


        //测试优惠券

//        $this->checkCoupon($money, $weight, $num, $productIds, $couponCode = '0040040041');
//        $res = $this->checkCoupon(11, 15, 2, 123123, '004004004');
//        dd($res['amount']);

        //测试商品集
//        $res = $this->checkItem();
//        dd($res);


        //测试满减
//        public function CheckDiscount($money, $weight)
//        $res = $this->CheckDiscount(1100, 1500);
//        dd($res);
//        dd($this->collect(5));

        //支付测试
        /*$pay = $this->pay();
        dd($pay);*/


        $items = $this->items;


        if($items->count() === 0){

            return  $this->view('member.cart.empty');
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->num;
        }


        return $this->view('member.cart.index', compact('items', 'total'));

    }


    /**
     * 添加商品
     */
    public function addItem()
    {
        $input = trimValue(Input::all());
        Cart::addItem($input['product_id'], $input['quantity'], $input['guige']);

    }


    /**
     * @param $quoteSn删除商品
     */
    public function delItem()
    {
        $input = trimValue(Input::all());

        $rowId = decode($input['rowId']);
        $res = Cart::remove($rowId);

        if ($res) {
            $count = Cart::getContent()->count();
            Session::put('cartCount',$count);
            $obj = new stdClass();
            $obj->status = 0;
            $obj->msg = '删除成功';
            return json_encode($obj);

        } else {
            $obj = new stdClass();
            $obj->status = 1;
            $obj->msg = '删除失败';
            return json_encode($obj);
        }
    }


    /**
     * @param $num
     * 改变购物车某项的数量
     */
    public function changeQuantity()
    {


        $input = trimValue(Input::all());

        if ($input['num'] <= 0) {
            $obj = new stdClass();
            $obj->status = 1;
            $obj->msg = '已经达到最小数量 ';
            return json_encode($obj);
        }
        $res = Cart::updateQty(decode($input['rowId']), $input['num']);

        if ($res == true) {
            $obj = new stdClass();
            $obj->status = 0;
            $obj->msg = '成功';
            return json_encode($obj);
        } else {
            $obj = new stdClass();
            $obj->status = 1;
            $obj->msg = '失败';
            return json_encode($obj);
        }

    }


    /**
     * 根据传入的购物车rowIds数组 返回对应的折扣信息
     */
    function checkItem()
    {
        //input: rowid数组： Input::get('rowIds') 优惠券： Input::get('coupon')
        //判断rowIds 和 coupon 是否为空数据
        //获取对应 quoteSn数组
        $input = trimValue(Input::all());
        if (isset($input['rowIds'])) {
            if (is_array($input['rowIds'])) {
                foreach ($input['rowIds'] as $rowid) {
                    $rowIds[] = decode($rowid);
                }
            }

        } else {
            return 'false';
        }

        $couponCode = $input['couponCode'];

        //对应总的重量
        $weight = 0;
        //对应总的价格
        $money = 0;
        //商品数量
        $num = 0;
        //商品列表
        $productIds = [];

        //对应对应总的折扣价格  减少的价格
        $discount = 0;

        foreach ($rowIds as $rowId) {
            $item = Source_Cart_CartItem::where('id', $rowId)->first();
            $money += $item->price * $item->num;
            $weight += $item->weight * $item->num;
            $num += $item->num;
            $productIds[] = $item->product_id;
        }

        //优惠券检测
        $couponRes = $this->checkCoupon($money, $weight, $num, $productIds, $couponCode);
        $couponRes['total'] = $money;
        //满减检测
        $discountRes = $this->CheckDiscount($money, $weight);
        $discountRes['total'] = $money;


//        dd($couponRes);

        //都不为空
        if (isset($couponRes['amount']) && isset($discountRes['amount'])) {
            if ($couponRes['amount'] >= $discountRes['amount']) {
                return $couponRes;
            }
            return $discountRes;
        }

        //都为空
        if (!isset($couponRes['amount']) && !isset($discountRes['amount'])) {
            $res['total'] = $money;
            return $res;
        }

        if (!isset($couponRes['amount'])) {
            return $discountRes;

        } else {
            return $couponRes;
        }
    }


    /**
     * @param int $weight
     * @param int $money
     * @param $couponCode
     * 总价和重量满减优惠的确认
     * 返回数组 ，如果有对应的折扣，第一个元素为生效的折扣规则，
     * 第二个元素为对应的折扣金额，如果没有生效的折扣规则则为空
     * @return array
     */
    public function CheckDiscount($money, $weight)
    {
        $result = array();
        $allrule = Source_Salerule_FavoutableRule::whereNotNull('conditions_use')
            ->where('conditions_type', 1)
            ->get();
        foreach ($allrule as $rule) {
            //from_date to_date 检测
            if (time() <= strtotime($rule->from_date) || time() >= strtotime($rule->to_date)) {
                continue;
            }

            //status 状态 1生效 0 禁止
            if ($rule->status === 0) {
                continue;
            }


            //lssue_num 发行数量


            //use_person 使用人数
            if ($rule->order->count() > 0) {
                if ($rule->order->groupBy('user_id')->count() >= $rule->userd_num) {
                    continue;
                }
            }

            //userd_num 使用次数
            if ($rule->order->count() >= $rule->userd_num) {
                continue;
            }

            //per_num 每人/每天使用
            //当天开始
            $dayStart = strtotime(date('Y-m-d', time()));
            //当天结束
            $dayEnd = date('Y-m-d H:m:s', $dayStart + 24 * 60 * 60);
            //当天开始 date-time
            $dayStart = date('Y-m-d H:m:s', $dayStart);

            if (Source_Order_OrtderFavoutable::where('pmt_id', $rule->id)
                    ->where('use_time', '>', $dayStart)
                    ->where('use_time', '<', $dayEnd)
                    ->count() >= 1
            ) {
                continue;
            }


            $rul = json_decode($rule->conditions_use);


            if ($rul->type == 'weight') {

                //重量优惠
                if ($this->compare($weight, "$rul->yunsuanfu", $rul->value)) {

                    switch ($rule->conditions_type) {
                        case 1:
                            $result[] = ['rule' => $rule, 'amount' => $rule->discount_amount];
                            break;

                        case 2:
                            $result[] = ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                            break;
                        case 3:
                            break;
                    }

                }
            } elseif ($rul->type == 'manjian') {

                if ($this->compare($money, $rul->yunsuanfu, $rul->value)) {

                    switch ($rule->conditions_type) {
                        case 1:
                            $result[] = ['rule' => $rule, 'amount' => $rule->discount_amount];
                            break;
                        case 2:
                            $result[] = ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                            break;
                        case 3:
                            break;
                    }
                }
            }


        }


        if (!empty($result)) {

            foreach ($result as $k => $v) {
                $amount[$k] = $v['amount'];
            }
            array_multisort($amount, SORT_NUMERIC, SORT_DESC, $result);
            return $result[0];
        }

    }


    /**
     *
     *
     */
    /**
     * @param $couponCode 折扣券码
     * @param $money 总金额
     * @param $weight 总重量
     * @param $num 总商品数量
     * 折扣卷的确认
     */
    public function checkCoupon($money, $weight, $num, $productIds, $couponCode)

    {

        $rule = Source_Salerule_FavoutableRule::whereNotNull('conditions_use')
            ->where('conditions_type', 2)
            ->where('status', 1)
            ->where('rule_code', $couponCode)
            ->first();


        if (!$rule) {
            return false;
        }


        /**规则：
         * 发行数量
         *使用次数
         *每人/每天
         *开始时间
         *结束时间
         */

        /*from_date to_date 检测*/
        if (time() <= strtotime($rule->from_date) || time() >= strtotime($rule->to_date)) {
            return false;
        }


        /*use_person 使用人数*/
        if ($rule->order->count() > 0) {
            if ($rule->order->groupBy('user_id')->count() >= $rule->userd_num) {
                return false;
            }
        }

        /*userd_num 使用次数*/
        if ($rule->order->count() >= $rule->userd_num) {
            return false;
        }
        /*当天开始*/
        $dayStart = strtotime(date('Y-m-d', time()));
        /*当天结束*/
        $dayEnd = date('Y-m-d H:m:s', $dayStart + 24 * 60 * 60);
        /*当天开始 date-time*/
        $dayStart = date('Y-m-d H:m:s', $dayStart);

        if (Source_Order_OrtderFavoutable::where('pmt_id', $rule->id)
                ->where('use_time', '>', $dayStart)
                ->where('use_time', '<', $dayEnd)
                ->count() >= 1
        ) {
            return false;
        }


        /**
         * 购物车规则:type
         *
         * 购物车小计 subtotal
         * 购物数量 number
         * 总重量 weight
         * 支付方式 payment
         * 选定产品 goods
         */

        /**
         * action_type
         *使用类型 1 固定金额 2 百分比
         */

        $rul = json_decode($rule->conditions_use);

        switch ($rul->type) {
            case 'subtotal':
                if ($this->compare($money, "$rul->yunsuanfu", $rul->value)) {


                    if ($rule->action_type == 1) {

                        return ['rule' => $rule, 'amount' => $rule->discount_amount];
                    } elseif ($rule->action_type == 2) {
                        return ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                    }
                }
                break;

            case 'number':

                if ($this->compare($num, "$rul->yunsuanfu", $rul->value)) {
                    if ($rule->action_type == 1) {
                        return ['rule' => $rule, 'amount' => $rule->discount_amount];
                    } elseif ($rule->action_type == 2) {
                        return ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                    }
                }
                break;

            case 'weight':

                if ($this->compare($weight, "$rul->yunsuanfu", $rul->value)) {
                    if ($rule->action_type == 1) {
                        return ['rule' => $rule, 'amount' => $rule->discount_amount];
                    } elseif ($rule->action_type == 2) {
                        return ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                    }
                }
                break;

            case 'payment':
                break;

            case 'goods':

                foreach ($productIds as $productId) {
                    if ($this->compare($productId, "$rul->yunsuanfu", $rul->value)) {
                        if ($rule->action_type == 1) {
                            return ['rule' => $rule, 'amount' => $rule->discount_amount];
                        } elseif ($rule->action_type == 2) {
                            return ['rule' => $rule, 'amount' => $money * $rule->discount_amount];
                        }
                    }
                }
                break;

        }


    }


    private function compare($a, $symbol, $b)
    {
        switch ($symbol) {
            case '<':
                return $a < $b;
                break;

            case '>':
                return $a > $b;
                break;

            case '<=':
                return $a <= $b;
                break;

            case '>=':
                return $a >= $b;
                break;

            case '!=':
                return $a != $b;
                break;

        }

    }

    /**
     * @param $id
     * 移到收藏夹
     */
    public function collect($id)
    {
        /**
         * user_id
         * entity_id
         * is_show
         * share_code
         * entity_name
         * price
         * sku
         * shop_id
         */
        $id = decode($id);

        $item = Source_Cart_CartItem::where('id', $id)->first();

        //收藏内已经有此商品
        if(Source_User_UserInfoCollect::where('entity_id',$item->product_id)->count()){
            Source_Cart_CartItem::where('id', $id)->delete();
            $count = Cart::getContent()->count();
            Session::put('cartCount',$count);
            return 'true';
        }

        //收藏内无此商品
        $colle['user_id'] = Session::get('member')->id;
        $colle['entity_id'] = $item->product_id;
        $colle['is_show'] = 1;
        $colle['share_code'] = 'collect' . getMicroTimestamp();
        $colle['entity_name'] = $item->product_name;
        $colle['shop_id'] = $item->shop_id;


        DB::transaction(function () use ($colle, $id) {
            Source_User_UserInfoCollect::create($colle);
            Source_Cart_CartItem::where('id', $id)->delete();
        });

        return 'true';
    }


    /**
     * @param $rowIds
     * 传递商品id数组 更新对应信息 生成支付订单数据
     * 支付
     */
    public function pay()
    {
        $input = trimValue(Input::all());

        /*test rowIds: 15 17 18*/
//        $input['rowIds'] = [
//            'Y29tcG9zZXJSZXF1aXJlZTg3ZmJmZDhiYjMzOGQ3MTIxY2E0YjI1YWJlNDkwMWMxNQ==',
//            'Y29tcG9zZXJSZXF1aXJlZTg3ZmJmZDhiYjMzOGQ3MTIxY2E0YjI1YWJlNDkwMWMxNw==',
//            'Y29tcG9zZXJSZXF1aXJlZTg3ZmJmZDhiYjMzOGQ3MTIxY2E0YjI1YWJlNDkwMWMxOA=='
//        ];


        if (empty($input['rowIds'])) {
            return 'false';
        }

        if (empty($input['couponCode'])) {
            $couponCode = '';
        } else {
            $couponCode = $input['couponCode'];
        }


        /*用户商品总价和件数*/
        $payment = 0;
        $itemnum = 0;
        $discount = 0;


        /*用户地址信息*/
        $user = Session::get('member');
        $address = Source_User_UserInfoAdd::where('status', 1)
            ->where('user_id', $user->id)->first();


        if (is_array($input['rowIds'])) {
            foreach ($input['rowIds'] as $rowId) {
                $rowIds[] = decode($rowId);
            }
        }

        /*更新商品总数 和 总价*/

        foreach ($rowIds as $rowId) {
            $item = Source_Cart_CartItem::where('id', $rowId)->first();
            $payment += $item->price * $item->num;
            $itemnum += $item->num;
        }

        $discount = $this->payCheck($rowIds, $couponCode);
        if ($discount == 'false') {
            $discount = 0;
        }


        $orderInfo['order_sn'] = 'order' . getMicroTimestamp();
        $orderInfo['user_id'] = $user->id;
        $orderInfo['shop_id'] = 1;
        $orderInfo['source'] = 1;
        $orderInfo['status'] = 1;
        $orderInfo['pay_status'] = 1;
        $orderInfo['payment_id'] = 'pay' . getMicroTimestamp();
//        $orderInfo['payment'] = $payment;
        $orderInfo['total_amount'] = $payment;
        $orderInfo['pay_amount'] = $payment - $discount;
        $orderInfo['itemnum'] = $itemnum;

        if (is_null($address)) {
            $orderInfo['ship_name'] = '';
            $orderInfo['ship_addr'] = '';
            $orderInfo['ship_post'] = '';
            $orderInfo['ship_phone'] = '';
            $orderItem['shipping_name'] = '';
        } else {
            $orderInfo['ship_name'] = $address->name;
            $orderInfo['ship_addr'] = $address->address;
            $orderInfo['ship_post'] = $address->zipcode;
            $orderInfo['ship_phone'] = $address->phone;
            $orderItem['shipping_name'] = $address->name;
        }


        /*生成订单 和 订单相应商品  order_info order_item*/

        /*order_item数据 */
        $orderItems = [];
        foreach ($rowIds as $rowId) {
            $item = Source_Cart_CartItem::where('id', $rowId)->first();
            $orderItem['product_id'] = $item->product_id;
            $orderItem['product_name'] = $item->product_name;
            $orderItem['product_status'] = $item->product_name;
            $orderItem['sku'] = $item->sku;
            $orderItem['price'] = $item->price;
            $orderItem['weight'] = $item->weight;
            $orderItem['row_total'] = $item->price * $item->num;
            $orderItem['row_weigth'] = $item->weight * $item->num;
            $orderItem['mendian_id'] = $item->shop_id;
            $orderItem['mendian_name'] = '';
            $orderItem['num'] = $item->num;
            $orderItem['guige'] = $item->guige;

            $orderItem['shipping_m_code'] = '';
            $orderItem['shipping_id'] = '';
            $orderItem['shipping_status'] = 1;
//        $orderItem['shipping_fei'] = '';
//        $orderItem['support_cod'] = $item->cod;
            $orderItems[] = $orderItem;
        }


        $res = DB::transaction(function () use ($orderItems, $orderInfo, $rowIds) {
            /*生成订单数据*/
            $orderNew = Source_Order_OrderInfo::create($orderInfo);

            /*生成订单商品数据*/
            foreach ($orderItems as $item) {
                $item['order_id'] = $orderNew->id;
                Source_Order_OrderItem::create($item);
            }
            /*删除购物车对应商品*/
            foreach ($rowIds as $rowId) {
                Cart::remove($rowId);
            }

        });


        //成功 返回加密的对应的订单id号
        if (is_null($res)) {
            return encode(Source_Order_OrderInfo::where('user_id', Session::get('member')->id)->max('id'));
        }
    }


    /**
     * @param $orderId 订单id
     * 转到支付页面
     */
    public function payOrder($orderId)
    {


        $orderId = decode($orderId);
        $order = Source_Order_OrderInfo::find($orderId);

        /*商品总价*/
        $total = 0;

        $address = Source_User_UserInfoAdd::where('user_id', $this->userId)->get();
        return $this->view('member.cart.pay_order', compact('order', 'address'));


    }


    /**
     * @param $rowIds
     * 根据传入的购物车rowIds数组 返回对应的折扣信息
     */
    private function payCheck($rowIds, $couponCode)
    {

        /*$rowIds
        $couponCode */

        if (empty($rowIds)) {
            return false;
        }

        //对应总的重量
        $weight = 0;
        //对应总的价格
        $money = 0;
        //商品数量
        $num = 0;
        //商品列表
        $productIds = [];

        //对应对应总的折扣价格  减少的价格
        $discount = 0;


        foreach ($rowIds as $rowId) {
            $item = Source_Cart_CartItem::where('id', $rowId)->first();
            $money += $item->price * $item->num;
            $weight += $item->weight * $item->num;
            $num += $item->num;
            $productIds[] = $item->product_id;
        }

        //优惠券检测
        $couponRes = $this->checkCoupon($money, $weight, $num, $productIds, $couponCode);
        //满减检测
        $discountRes = $this->CheckDiscount($money, $weight);


        //都不为空
        if ($couponRes && $discountRes) {
            if ($couponRes['amount'] >= $discountRes['amount']) {
                return $couponRes['amount'];
            }
            return $discountRes['amount'];
        }

        //都为空
        if (!$couponRes && !$discountRes) {
            return false;
        }
        if (!$couponRes) {
            return $discountRes['amount'];

        } else {
            return $couponRes['amount'];
        }
    }

}