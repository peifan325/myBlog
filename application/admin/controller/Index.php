<?php
namespace app\admin\controller;

use app\admin\controller\Base;

class Index extends Base
{
    public function index()
    {
        $this->view->assign('title', '碎语闲言-后台首页');
        
        return $this->view->fetch('index');
    }

    public function welcome()
    {
        return $this->view->fetch('welcome');
    }
}
