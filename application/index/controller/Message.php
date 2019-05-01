<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Message as MsgModel;

class Message extends Base
{
    public function message()
    {


        $msgs = MsgModel::all(function($query){
            $query->where('status', '0')->order('create_time', 'desc');
        });
        foreach ($msgs as $key => $msg) {
            $msg['username'] = $msg['user']['username'];
            $msg['userimg'] = $msg['user']['img']?:'/static/static/images/info-img.png';
        }

        // halt($msgs);
        $this->view->assign('title', '碎语闲言-留言板');
        $this->view->assign('msgs', $msgs);  
        $this->view->assign('count', $msgs->count());                      
        $this->view->assign('nav_item', '2');                             //菜单 激活
        
        return $this->view->fetch('message');
    }
}
