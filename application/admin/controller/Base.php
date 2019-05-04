<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    public function initialize()
    {
        if (!Session::has('user_info')) {
            $this->redirect('account/login');
        }
    }
}
