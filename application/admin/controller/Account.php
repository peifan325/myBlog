<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\facade\Session;
use think\Controller;
use app\common\model\User as UserModel ;

class Account extends Controller
{
    public function login()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = UserModel::login($data);
            if (gettype($res) !== "string") {
                if ($res['role'] == '1') {//角色为管理员才能登录后台
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
    public function logOut()
    {
        Session.delete('user_info');
        return $this->redirect('account/login');
    }
    public function userList()
    {
        $userlist = UserModel::getUserList();
        $this->view->assign('userlist', $userlist);
        return $this->view->fetch('user_list');
    }
    public function changeStatus()
    {
        $id = $this->request->param('id');
        $status = $this->request->param('status');

        $res = UserModel::where('id', $id)->update(['status'=>$status]);
        if ($res) {
            return ['status'=>1];
        } else {
            return ['status'=>1,'msg'=>'更新失败'];
        }
    }
    public function edit()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = UserModel::update($data);
            return ['status'=>1];
        }
        $id = $this->request->param('id');
        if ($id) {
            $res = UserModel::get($id);
            $this->view->assign('user', $res->getData());
        }
        return $this->view->fetch('user_edit');
    }
    public function delete()
    {
        $id = $this->request->param('id');
        UserModel::destroy($id);
    }
    public function add()
    {
        
        return $this->view->fetch('user_add');
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
