<?php
//评价
class ReviewMemberController extends CommonController
{
    private $user_id;
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
    }

    /**
     * 我的评价
     *
     * @return Response
     */
    public function index()
    {
        //当前对应的用户评价信息

        $data = Source_Order_OrderReview::where('user_id',$this->user_id);

        //分页
        $setPage = Input::get('setpage') ? Input::get('setpage') : self::$memberPage;


        //搜索条件

        /* <option value="3">好评</option>
                            <option value="2" selected="">中评</option>
                            <option value="1">差评</option>
        */
        $set['xingji'] ='';
        if (!empty(Input::get('reviewClass'))) {
            $class = Input::get('reviewClass');
            switch($class){
                case 1:
                    $data = $data->where('leavel',1);
                    $set['xingji'] =1;
                    break;
                case 2:
                    $data = $data->where('leavel',2)
                    ->orwhere('leavel',3);
                    $set['xingji'] =2;
                    break;
                case 3:
                    $data = $data->where('leavel',4)
                        ->orwhere('leavel',5);
                    $set['xingji'] =3;
                    break;
            }
        }

        $data = $data->paginate($setPage);
        $set['setpage'] = $setPage;
        return $this->view('member.review', compact('data', 'set'));

    }


    /**
     * @param $orderId 订单id
     * @param $ItemId 订单商品id
     * 提交评价
     * url : 'get('/review/apply_review/{order_id}/{item_id}', 'ReviewMemberController@applyReview')'
     */
    public function applyReview($orderId, $itemId)
    {


        $orderId = decode(trim($orderId));
        $itemId = decode(trim($itemId));

        $orderInfo = Source_Order_OrderInfo::where('id',$orderId)->first();
        $orderItem = Source_Order_OrderItem::where('id',$itemId)->first();


        return $this->view('member.order.apply_review', compact('orderItem', 'orderInfo'));

    }



    /**
     * 存储评价信息  更新表 order_review
     */
    public function createReview()
    {

        //$user = Session::get('member');
        //dd(Input::all());

        if (!Input::all())
            return Redirect::back();

        $input = trimValue(Input::all());
        $input = array_except($input, ['_token', 'method']);

        $orderId = Input::get('orderId');
        $orderItemId = Input::get('itemId');
        $entity_id=Input::get('entity_id');
//        dd($input);

        //判断是否已经提交过了退款
        if (Review::CheckItem($orderId, $orderItemId)) {
            die('已经提交过此商品的评论');
        }



        $review['order_id'] = $orderId;
        $review['item_id'] = $orderItemId;
        $review['entity_id'] = $entity_id;
        $review['user_id'] = $this->user_id;
        $review['leavel'] = Input::get('leavel');
        $review['content'] = Input::get('content');
        $review['status'] = 0;

        $validator = Review::validatorReview($input);

        if ($validator === true) {
            $res = Review::createReview($review);

            if ($res) {
                //添加成功 提交评论事件
                Event::fire('item.review',$orderItemId);
                return Redirect::to('member/review')->with('msg', '添加成功');

            } else {
                //添加失败
                return back()->with('msg', '添加失败');
            }

        } else {
            return back()->withErrors($validator);
        }
    }


    /*评论详情页*/
    public function detail($id)
    {
        $id = decode($id);
        $data = Source_Order_OrderReview::find($id);
        $orderItem = $data->item;
        $this->view('member.order.detail_review',compact('data','orderItem'));
    }




}