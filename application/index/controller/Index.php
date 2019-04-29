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

        return ['status'=>$status, 'count'=>$res['count'], 'data'=>$res['data'], 'where'=>$res['where']];
    }

    //文章详情页
    public function details(Article $artModel)
    {
        if($this->request->isAjax()){
            $data = $this->request->param();
            $coms = $artModel->getComments($data);

            return $coms;
        }

        $id = $this->request->param('id');
        $art = $artModel->getArt($id);
        if (is_null($art)){return $this->error('并没有这篇文章哦！', 'index/index');}
        
        $this->view->assign('count', $art->comments_count);                //评论总数
        $this->view->assign('art', $art);                             
        $this->view->assign('nav_item', '1');                             //菜单 激活
        return $this->view->fetch('details');
    }
    //文章评论总数
    public function getComCount(Article $artModel)
    {
        $id = $this->request->param('id');
        $art = $artModel->getArt($id);
        return $art->comments_count;
    }


    public function message()
    {
        $this->view->assign('title', '碎语闲言-留言板');
        $this->view->assign('nav_item', '2');                             //菜单 激活
        
        return $this->view->fetch('message');
    }
    public function about()
    {
        $this->view->assign('title', '碎语闲言-关于');
        $this->view->assign('nav_item', '3');                                 //菜单 激活
        
        return $this->view->fetch('about');
    }
}
