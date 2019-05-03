<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use app\admin\controller\Base;
use app\common\model\User as UserModel ;

class Account extends Base
{
    public function login()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = UserModel::login($data);
            if (gettype($res) !== "string") {
                if ($res['role'] == '1') {
                    session('user_info', ['id' => $res['id'], 'name'=>$res['username'],'img'=>$res['img'], 'role' => $res['role']]);
                    return ['status'=>1, 'msg'=>'登录成功!'];
                } else {
                    return ['status'=>0, 'msg'=>"您的账户无权登录后台管理系统！"];
                }
            } else {
                return ['status'=>0, 'msg'=>$res];
            }
        }
        
        $this->view->assign('title', '碎语闲言-后台登录');
        
        return $this->view->fetch('login');
    }
    public function loginOut()
    {
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
