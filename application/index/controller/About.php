<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;
use app\common\model\Comment;

class About extends Base
{
    public function about()
    {
        $this->view->assign('title', '碎语闲言-关于');
        $this->view->assign('nav_item', '3');                                 //菜单 激活
        
        return $this->view->fetch('about');
    }
}
