<?php

class BaseController extends Controller
{

	/**
	 * --------------------------------------------
	 *
	 *  前台缓存标签：1.广告（ads）
	 * 								---- 首页banner广告（ adsbanner ）
	 * 				2.分类（category）  ***
	 * 								---- 3级分类ID(categoryNameByID)
	 *
	 * 				3.产品（goods）  ****
	 * 								---- 限时抢购（goodsFlashSale） goods
	 * 								---- 精品推荐（goodsRecommendGoods） goods
	 * 								---- 首页楼层（goodsFloorGoods） goods
	 *                              ---- 详情页（goodsdetails）
	 *                              ---- 详情图片（goodsImg）
	 *  							---- 详情参 数（goodsConfigInfo）
	 *              4.列表页检索（goodsListScreenBrand）  配置检索screen
	 * 				5.产品列表（goodsList） **
	 * 				6.品牌缓存（brand） **
	 * 				7.属性缓存（attrbute）
	 *              8.友情链接（link）
	 *
	 *
	 *
	 *
	 * --------------------------------------------
	 */

	//定义主模板
	protected $layout = 'layouts.frontend';
	//当前时间
	protected static $time;
	protected static $cache;

	public function __construct()
	{
		self::$time = date('Y-m-d');
		self::$cache = Config::get('tools.homeCache');
		$publicCategory = Home::getCategory(  self::$cache );
		$user = Session::get('member');
		$cartCount = Session::get('cartCount');
		if(  $cartCount == false && $user )
		{
			$cartCount = Source_Cart_CartItem::where('user_id',$user->id)->count();
			Session::put('cartCount', $cartCount);
			
		}else if( $user == false )
		{
			Session::put('cartCount', 0);
		}
		View::share('publicCategory', $publicCategory);
	}
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * @param $path
	 * @param array $data
	 * 模板输出
	 */
	protected function view($path, $data = [])
	{
		$this->layout->content = View::make($path, $data);
	}

	

}
