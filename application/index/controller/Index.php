<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;
use app\common\model\Comment;

class Index extends Base
{
    public function index(Article $artModel)
    {
        $data = $this->request->param();
        $res  = $artModel->getArtList($data);

        // halt($res);
        $this->view->assign('count', $res['count']);
        $this->view->assign('artlist', $res['data']);
        $this->view->assign('title', '碎语闲言');
        $this->view->assign('nav_item', '1');              //菜单 激活
        return $this->view->fetch('index');
    }
    //ajax 请求获取文章数据
    public function getArtList(Article $artModel)
    {
        $data = $this->request->param();
        $res  = $artModel->getArtList($data);

        $status = empty($res)?0:1;//0失败  1成功

        return ['status'=>$status, 'count'=>$res['count'], 'data'=>$res['data']];
    }
}
