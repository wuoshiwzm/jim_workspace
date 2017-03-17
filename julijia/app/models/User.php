<?php

/**
 *  Class User
 *  用户业务模型
 */

use Illuminate\Support\Facades\Crypt;
class User
{

    /**
     * @param $username
     * @param $password
     * 用户登录
     */
    static function login($username, $password)
    {

        $user = Source_User_UserInfo::where('name', $username)
            ->orwhere('mobile_phone', $username)
            ->first();
        /* dd($user->password);*/
        if ($user) {
            if ($password == Crypt::decrypt($user->password)) {
                return true;
            }
            return false;
        }
        return false;

    }


    /**
     * 返回用户列表
     * 上次交易时间
     * 交易笔数
     * orderinfo 为订单信息字段
     */
    static function userlist()
    {

        $data = Source_User_UserInfo::leftjoin('userinfo_group', 'userinfo.group_id', '=', 'userinfo_group.id')
            ->select('userinfo.name', 'userinfo.id', 'userinfo_group.name as group_name', 'userinfo.mobile_phone')
            ->get();

        foreach ($data as $v) {
            $orderinfos = $v->get();
//            $orderinfos = $v->hasOrders()->get();
            $v->orderinfo = $orderinfos ? $orderinfos : 'null';
            $v->orderCount = $orderinfos->count();
            $v->orderLasttime = $orderinfos->max('created_at');
        }
        return $data;
    }


    /**
     * @param $data
     * @return bool
     */
    static function validatorUser($data)
    {
        $rules = [
//            'name' => 'required|regex:/\w/|unique:userinfo,name',
//            'password' => 'required|min:6|same:repassword',
//            'repassword' => 'required|min:6',
//            'email' => 'required|email',
//            'office_phone' => 'min:7|max:20',
//            'mobile_phone' => 'min:7|max:20',
//            'home_phone' => 'min:|max:20',
//            'sex' => 'required',
//            'qq' => 'min:4|max:13',
//            'wechat' => 'regex:/\w/',

        ];
        $message = [

        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->passes()) {
            return true;

        } else {
            return false;
        }
    }


    //check if the name is occupied
    static function checkName($name)
    {
        $res = Source_User_UserInfo::where('name', $name)->count();
        return $res ? true : false;
    }

    /**
     * @param $email
     * @return bool
     * check if the email is occupied
     */
    static function checkEmail($email)
    {
        $res = Source_User_UserInfo::where('email', $email)->get()->toArray();
        return $res ? true : false;
    }


    //add user to database
    static function addUser($data)
    {

        $info['name'] = $data['name'];
        $info['password'] = Crypt::encrypt($data['password']);
        $info['mobile_phone'] = $data['mobile_phone'];
        $info['group_id'] = Source_User_UserInfoGroup::orderBy('beg_points')->first()->id;
        $info['user_points'] = 0;
        $info['pay_points'] = 0;

        return Source_User_UserInfo::create($info);
    }

    static function checkUser($data)
    {
        $name = $data['name'];
        $password = encode($data['password']);
        return Source_User_UserInfo::where('name', $name)->where('password', $password)->first() ? true : false;

    }

    static function getUserByName($username)
    {
        return Source_User_UserInfo::where('name', $username);
    }


    /**
     * @param $user_id 用户id
     * @return mixed
     *
     * 返回用户所有地址
     */
    static function getAllAddrByUser($user_id)
    {
        $addrInfo = Source_User_UserInfoAdd::where('user_id', $user_id);
        if (!$addrInfo) {
            return false;
        }
        return $addrInfo;

    }

    /**
     * @param $user_id
     * @return array
     * 获取当前有效的地址
     */
    static function getUsingAddrByUser($user_id)
    {
        $addrInfo = Source_User_UserInfoAdd::where('user_id', $user_id)->where('status', 1)->first();
        //无地址信息
        if (!$addrInfo) {
            return false;
        }
        return $addrInfo;
    }

    /**
     * @param $provId
     * @return mixed
     * 返回省份
     */
    static function getProv($provId)
    {
        return Source_Area_Province::find($provId);
    }

    /**
     * @param $cityId
     * @return mixed
     * 返回城市
     */
    static function getCity($cityId)
    {
        return Source_Area_City::find($cityId);
    }

    /**
     * @param $distId
     * @return mixed
     * 返回地区
     */
    static function getDist($distId)
    {
        return Source_Area_Area::find($distId);
    }

    /**
     * @param $user_id
     * @return mixed
     * 返回用户组
     */
    static function getGroup($user_id)
    {
        $userInfo = Source_User_UserInfo::find($user_id)->first();
        $group_id = $userInfo->group_id;
        return Source_User_UserInfoGroup::find($group_id);
    }


    static function calcPoint($userId)
    {

    }

    /**
     * @param $id
     * 返回当前登录的用户信息
     */
    static function userinfo($id)
    {
        return Source_User_UserInfo::find($id);
    }

    /**
     * @param $user_id
     * 返回用户信息
     */
    static function getUserinfoById($user_id)
    {
        return Source_User_UserInfo::find($user_id);
    }


    /**
     * @param $user_id
     * 返回用户所有订单信息
     */
    static function getOrdersByUser($user_id)
    {

        $data = Source_Order_OrderInfo::where('order_info.user_id', $user_id);

        return $data;
    }

    /**
     * @param $user_id
     * 返回用户所有购物车内商品信息
     */
    static function getCartByUser($user_id)
    {
        $data = Source_Cart_CartItem::where('user_id', $user_id);
        return $data;
    }


    /**
     * @param $user_id
     * 返回用户所有评论
     */
    static function getCommentByUser($user_id)
    {
        $data = Source_User_UserInfoComment::where('user_id', $user_id);
        return $data;
    }

    /**
     * @param $userId
     * @param bool $status 是否显示
     * @return mixed
     * 获取用户的收藏商品
     */
    static function getCollectByUser($userId, $status = true)
    {
        $sql = Source_User_UserInfoCollect::where('user_id', $userId);
        if (!$status) {
            $sql->where('is_show', '0');
        }
        return $sql;
    }


    /**
     * @param $user_id
     * @param $newPass
     * 更改密码
     */
    static function changePass($user_id, $newPass)
    {

        $user = Source_User_UserInfo::find($user_id);
        $user->password = $newPass;
        $res = $user->save();
        return $res;


    }


}