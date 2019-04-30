<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;
use app\common\model\Comment;

class Message extends Base
{
    public function message()
    {
        $this->view->assign('title', '碎语闲言-留言板');
        $this->view->assign('nav_item', '2');                             //菜单 激活
        
        return $this->view->fetch('message');
    }
}
