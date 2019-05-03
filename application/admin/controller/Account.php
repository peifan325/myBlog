<?php
namespace app\admin\controller;

use app\admin\controller\Base;

class Account extends Base
{
    public function login()
    {
        $this->view->assign('title', '碎语闲言-后台登录');
        
        return $this->view->fetch('login');
    }
    public function loginOut()
    {
    }
}
