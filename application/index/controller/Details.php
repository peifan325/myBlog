<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;
use app\common\model\Comment;

class Details extends Base
{
    //文章详情页
    public function details(Article $artModel)
    {
        $id = $this->request->param('id');
        $art = $artModel->getArt($id);
        if (!$art) {
            return $this->error('并没有这篇文章！', 'index/index');
        }

        $comments = $this->getComments();
        // \halt($comments);
        $this->view->assign('art', $art);                                   //文章
        $this->view->assign('comments', $comments);                         //评论

        $this->view->assign('count', $art->comments_count);               //评论总数
        $this->view->assign('nav_item', '1');                             //菜单 激活
        return $this->view->fetch('details');
    }




    //文章评论
    /**
     * 返回数据：
     * array(11) {
     *       [0] => array(5) {
     *          ["username"] => string(5) "admin"
     *          ["userimg"] => string(0) ""
     *          ["content"] => string(33) "这是一条测试评论 artid 37"
     *          ["create_time"] => string(19) "2038-01-19 11:14:07"
     *          ["like"] => int(100)
     *       }
     * }

     */
    public function getComments()
    {
        $id = $this->request->param('id');
        $art = new Article();
        $comments = $art->getComments($id);

        $res = [];
        $temp = [];

        foreach ($comments as $key => $value) {
            $temp['id'] = $value['id'];
            $temp['userid'] = $value['user']['id'];
            $temp['username'] = $value['user']['username'];
            $temp['userimg'] = $value['user']['img']?:'/static/static/images/info-img.png';
            $temp['content'] = $value['content'];
            $temp['create_time'] = $value['create_time'];
            $temp['like'] = $value['like'];
            $res[] = $temp;
        }
        return $res;
        // return
        // return $comments->append(['user.xx'])->toArray();
    }
}
