<?php


class MemberController extends \BaseController
{

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


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 登录页
     * 用户手机 用户名都可以登录
     */
    function login($url = null)
    {

        //已登录
        if (isset(Session::get('member')->id) && (userLastIP(Session::get('member')->id)) == clientIP()) {
            return Redirect::to('member');
        }

        if (Input::get('redirectURL')) {
            $url = Input::get('redirectURL');
            return $this->view('frontend.login', compact('url'));
        }

        //$url 要跳转的页面
        $url = $url ? decode($url) : '';
        return $this->view('frontend.login', compact('url'));
    }


    public function loginVerify()
    {

        $username = Input::get('name');
        $password = Input::get('password');

        $url = Input::get('url');
        if (Input::get('_token') != csrf_token()) {
            return Redirect::back()->with('msg', '登录失败')->withInput();
        }
        $res = User::login($username, $password);
        if ($res) {
            //更新上次登录时间
            $user = User::getUserByName(Input::get('name'))
                ->orwhere('mobile_phone', Input::get('name'))
                ->first();

            $user->update(array('last_time' => date('Y-m-d H:m:s'), 'last_ip' => clientIP()));
            // 存入session
            Session::put('member', $user);
            Cache::put('userheader', $user->header, '5000');

            if (empty($url)) {
                return Redirect::to('member');
            }

            return Redirect::to($url);
        }
        return Redirect::back()->with('msg', '用户名或者密码错误')->withInput();
    }

    function index()
    {

    }

    /**
     * 注册
     */
    function register()
    {
        $this->view('frontend.register');
    }


    /**
     * @return mixed
     * 判断注册成功 存储信息
     */
    function store()
    {
        $input = Input::all();
        $smscode = Input::get('code');
        $sms = Session::get('sms');


        //确认手机号
        if($input['mobile_phone'] != $sms['phone']){
            return Redirect::back()->with('msg', '手机号码错误')->withInput();
        }

        //确认验证码
        if ($smscode != $sms['smsCode']) {
            return Redirect::back()->with('msg', '验证码不对')->withInput();
        }

        if ($input['_token'] = csrf_token() && isset($input['like']) && $input['like'] == 'on') {
            $err = [];
            $res = User::checkName($input['name']);
            if (!$res) {
                $err[] = '该用户名已被占用！';
            }

            if (Source_User_UserInfo::where('mobile_phone', $input['mobile_phone'])->count()) {
                $err[] = '该手机号码已经占用！';
            }

            $res = User::validatorUser($input);
            $res ?: $err = array_merge($res->all(), $err);
            if ($res === true && $err != []) {
                User::addUser($input);
                $user = User::getUserByName(Input::get('name'))->first();
                $user->update(array('last_time' => date('Y-m-d h:m:s'), 'last_ip' => clientIP()));
                // 存入session
                Session::put('member', $user);
                Cache::put('userheader', $user->header, 5000);
                return Redirect::to('member');
            } else {
                return Redirect::back()->with('msg', '注册失败')->withInput();
            }
        }
        return Redirect::back()->with('msg', '注册失败')->withInput();
    }


    /**
     * 退出登录
     */
    function quit()
    {
        Session::forget('member');
        Session::forget('cartCount');
        return Redirect::to('member');
    }


    /**
     * @return mixed
     * 发送短信
     */
    function sendSms()
    {

        $input = trimValue(Input::all());
        $phone = $input['phone'];

        $sql = Source_User_UserInfo::where('mobile_phone', trim(Input::get('phone')))->count();
        if ($sql >= 1) {
            return '手机号码已注册！';
        }

        if (empty($phone)) {
            return '请填入手机号码！';
        }

        //确认是否已经1分钟前发送过短信
        $content = "居利家温馨提示:您的注册验证码为：";
        $res = Sms::registerSms($phone, $content);
        return $res;
    }

    /**
     * 发送短信 重置密码
     */
    function sendReSms()
    {
        //确认此手机号码已经注册
        $input = trimValue(Input::all());
        $phone = $input['phone'];

        $user = Source_User_UserInfo::where('mobile_phone', $phone)->first();
        if (empty($phone)) {
            return '请填入手机号码！';
        }
        if (empty($user)) {
            return '此手机号并未注册！';
        }

        //确认是否已经1分钟前发送过短信
        $content = "居利家温馨提示:您的确认验证码为：";
        $res = Sms::registerSms($phone, $content);
        return $res;
    }

    /**
     * @return mixed
     * 验证短信验证码
     */
    function checkSms()
    {

        //判断session中是否有smsCode的信息
        if (!Session::has('sms')) {
            //验证失败
            $res = [
                'info' => '验证码错误',
                'status' => 'n'
            ];
            return $res;
        }
        $sms = Session::get('sms');
        if ($sms['smsCode'] == Input::get('param')) {
            $res = [
                'info' => '验证码正确',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '验证码错误',
                'status' => 'n'
            ];
        }

        return $res;
    }


    /**
     *重设密码
     */
    function resetPass()
    {
        if (!Input::all()) {
            return $this->view('frontend.reset_pass');
        }
        //接受更新数据
        $input = trimValue(Input::all());
        $res = Source_User_UserInfo::where('mobile_phone', $input['phone'])
            ->update(['password' => Crypt::encrypt($input['newPassword'])]);

        if ($res == true) {
            return Redirect::to('member');
        } else {
            return Redirect::back()->with('msg', '更改失败！');
        };
    }

    /**
     * 验证用户名是否被占用
     */
    public function checkName()
    {
        $sql = Source_User_UserInfo::where('name', Input::get('param'))->count();

        if ($sql < 1) {
            $res = [
                'info' => '该用户名可以使用',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '已经被注册',
                'status' => 'n'
            ];
        }
        return json_encode($res);
    }

    /**
     * 验证用户名是否被占用
     */
    public function checkLoginName()
    {
        $sql = Source_User_UserInfo::where('name', Input::get('param'))->count();

        if ($sql <= 1) {
            $res = [
                'info' => '该用户名可以使用',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '用户名不存在',
                'status' => 'n'
            ];
        }
        return json_encode($res);
    }

    /**
     * 验证手机是否被占用
     */
    public function checkMobile()
    {
        $sql = Source_User_UserInfo::where('mobile_phone', Input::get('param'))->count();

        if ($sql < 1) {
            $res = [
                'info' => '验证成功',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '该手机号码已经被注册',
                'status' => 'n'
            ];
        }
        return json_encode($res);
    }

    /**
     * 验证手机是否被占用
     */
    public function checkEmail()
    {
        $sql = Source_User_UserInfo::where('email', Input::get('param'))->count();

        if ($sql < 1) {
            $res = [
                'info' => '验证成功',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '该邮箱已经被注册',
                'status' => 'n'
            ];
        }
        return json_encode($res);
    }


    /**
     * 验证登录用户名是否存在
     */
    public function ajaxNameCheck()
    {

        $sql = Source_User_UserInfo::where('name', Input::get('param'))->orwhere('mobile_phone', Input::get('param'))->count();
        if ($sql > 0) {
            $res = [
                'info' => '验证成功',
                'status' => 'y'
            ];
        } else {
            $res = [
                'info' => '该用户名或手机号码不存在',
                'status' => 'n'
            ];
        }
        return json_encode($res);
    }


}
