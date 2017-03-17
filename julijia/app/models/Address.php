<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/11
 * Time: 19:33
 */
class Address
{

    /**
     * @param $id
     * @return mixed
     * 通过id获取对应的地址信息
     */
    static function getAddress($id)
    {
        return Source_User_UserInfoAdd::find($id);
    }

    /**
     * @param $data
     * @return bool
     */
    static function validatorAddress($data)
    {
        $rules = [];
        $message = [];
        $validator = Validator::make($data, $rules, $message);
        if ($validator->passes()) {
            return true;

        } else {
            return $validator;
        }
    }

    /**
     * @param $id 分类id
     * @param $input 更新地址信息
     */
    static function update($id, $input)
    {

        $userId = Session::get('member')->id;

        if(isset($input['status']) && $input['status']==1){
            Source_User_UserInfoAdd::where('user_id',$userId)->update([
                'status'=>0
            ]);
        }


        $res = Source_User_UserInfoAdd::where('id', $id)->update($input);
        return $res;
    }

    /**
     * @param $input
     * 加入新地址
     */
    static function createAddr($input)
    {

        if(Source_User_UserInfoAdd::where('user_id', $input['user_id'])->count() == 0){
            $input['status'] == 1;
        }


        //如果status为1，则设为默认地址，改变其他地址对应的属性
        if (isset($input['status'])) {
            if ($input['status'] == 1) {
                Source_User_UserInfoAdd::where('user_id', $input['user_id'])
                    ->update(['status' => 0]);
                $res = Source_User_UserInfoAdd::create($input);
                return $res;
            }
            $res = Source_User_UserInfoAdd::create($input);
            return $res;
        }
        //如果status没有值 ，则插入数据即可
        $res = Source_User_UserInfoAdd::create($input);
        return $res;
    }

    /**
     * @param $id
     * 改为默认地址
     */
    static function setDefault($id,$user_id)
    {
        Source_User_UserInfoAdd::where('user_id', $user_id)
            ->update(['status' => 0]);
        $data = Source_User_UserInfoAdd::find($id);
        $data->status = 1;
        $res = $data->save();
        return $res?true:false;
    }


    /**
     * @param $addr_id
     * 删除对应的地址
     */
    static function deleteById($addr_id){
        $addr = Source_User_UserInfoAdd::find($addr_id);
        if($addr->status == 1){
            return false;
        }
        return $addr->delete();
    }


    /**
     * @param $userId
     */
    static function getDefaultByUser($userId){
        return Source_User_UserInfoAdd::where('user_id',$userId)
            ->where('status',1)
            ->first();
    }

}