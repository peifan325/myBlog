<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;

class Index extends Base
{
    public function index(Article $artModel)
    {
        $data = $this->request->param();
        $res  = $artModel->getArticles($data);

        
        $this->view->assign('count', $res['count']);
        $this->view->assign('artlist', $res['data']);
        $this->view->assign('title', '碎语闲言');
        $this->view->assign('nav_item', '1');
        return $this->view->fetch('index');
    }
    //ajax 请求获取文章数据
    public function getArtList(Article $artModel)
    {
        
        $data = $this->request->param();
        
        $res  = $artModel->getArticles($data);
        $status = empty($res)?0:1;//0失败  1成功

        return ['status'=>$status, 'count'=>$res['count'], 'data'=>$res['data']];
     }
    public function message()
    {
        $this->view->assign('title', '碎语闲言-留言板');
        $this->view->assign('nav_item', '2');
        
        return $this->view->fetch('message');
    }
    public function about()
    {
        $this->view->assign('title', '碎语闲言-关于');
        $this->view->assign('nav_item', '3');
        
        return $this->view->fetch('about');
    }
}
