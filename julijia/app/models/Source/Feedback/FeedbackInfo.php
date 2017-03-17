<?php

/**
 * Author:Tonychang
 * Date: 2016-11-30
 * Time: 20:29
 * DES: 反馈投诉模型
 */
class Source_Feedback_FeedbackInfo extends \Eloquent
{
    protected $primaryKey = 'id';
    protected $table='feedback_info';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo("Source_Order_OrderInfo","order_id");
    }
    public function item()
    {
        return $this->belongsTo("Source_Order_OrderItem","item_id");
    }
    public function user()
    {
        return $this->belongsTo("Source_User_UserInfo","user_id");
    }
    public function reason()
    {
        return $this->belongsTo("Source_Feedback_FeedbackReason","reason_id");
    }
    public function log()
    {
        return $this->hasMany("Source_Feedback_FeedbackAction","feedback_id","id");
    }

}