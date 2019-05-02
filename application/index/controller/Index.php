<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article;
use app\common\model\Comment;
use app\common\model\Message;

class Index extends Base
{
    public function index(Article $artModel)
    {
        $data = $this->request->param();
        $res  = $artModel->getArtList($data);

        // halt($res);
        $this->view->assign('count', $res['count']);
        // $this->view->assign('artlist', $res['data']);
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

    /**
     * 保存点赞
     * data: {type:"xx", id:'1'}
     *
    */
    public function saveLike()
    {
        $data = $this->request->param();
        switch ($data['type']) {
            case 'art':
                Article::get($data['id'])->setInc('like');
                break;
             case 'com':
                Comment::get($data['id'])->setInc('like');
                break;
            case 'msg':
                Message::get($data['id'])->setInc('like');
                break;
            default:
                # code...
                break;
        }
    }
    /**
     * 保存评论，留言
     * let data = {
     *               type:'com'
     *              ,artid: article  id
     *              ,userid: 当前用户id
     *               ,username:  当前用户名称
     *               , avatar: '/static/static/images/info-img.png'  用户头像
     *               , praise: 0        点赞数量
     *               , content: content 内容
     *           };
     *
    */
    public function saveMsg()
    {
        $data = $this->request->param();

        switch ($data['type']) {
             case 'com':
                $com = Comment::create([
                    'user_id' => $data['userid']
                    ,'article_id' => $data['artid']
                    ,'like' => $data['praise']
                    ,'content' => $data['content']
                    ,'status'  => 0 //启用
                ]);
                return $com->id;
                break;
            case 'msg':
                $msg = Message::create([
                    'user_id' => $data['userid']
                    ,'like'   => $data['praise']
                    ,'content'=> $data['content']
                    ,'status' => 0
                ]);
                return $msg->id;
                break;
            default:
                # code...
                break;
        }
    }
}
