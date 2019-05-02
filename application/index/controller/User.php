<?php
namespace app\index\controller;

use app\common\model\User as UserModel;
use app\index\controller\Base;
use think\captcha\Captcha;
use think\facade\Session;

//账户管理
class User extends Base
{
    public function login()
    {
        // ajax 提交登录信息
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = UserModel::login($data);
            if ($res == 1) {
                return ['status'=>1, 'msg'=>'登录成功!'];
            } else {
                return ['status'=>0, 'msg'=>$res];
            }
        }
        return $this->view->fetch('login');
    }
    public function loginOut()
    {
        Session::delete('user_info');
        return $this->redirect('index/index');
    }

    public function register()
    {
        // ajax 提交注册信息
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = UserModel::register($data);
            if ($res == 1) {
                return ['status'=>1, 'msg'=>'注册成功!'];
            } else {
                return ['status'=>0, 'msg'=>$res];
            }
        }
        return $this->view->fetch('register');
    }

    public function verify()
    {
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码位数
            'length'      =>    3,
            // 关闭验证码杂点
            'useNoise'    =>    false,
            'codeSet'     =>   '0123456789',
            'useCurve'    =>   false,
            'reset'       =>   true,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}
