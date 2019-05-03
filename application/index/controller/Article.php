<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\common\model\Article as ArtModel;
use app\common\model\Comment;

class Article extends Base
{
    public function create()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $res = ArtModel::saveArt($data);
            if ($res == 1) {
                return ['status'=>1, 'msg'=>'发布成功!'];
            } else {
                return ['status'=>0, 'msg'=>$res];
            }
        }

        $this->view->assign('title', '碎语闲言-发布文章');
        $this->view->assign('nav_item', '1');                                 //菜单 激活
        
        return $this->view->fetch('create');
    }

    //文章图片上传接口
    public function uploadImg()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('../public/static/uploads');
        if ($info) {
            // 成功上传后 获取上传信息
            return ['code'=>0, 'msg'=>'', 'data'=>['src'=>'/static/uploads/'.$info->getSaveName()]];
        } else {
            // 上传失败获取错误信息
            return ['code'=>0, 'msg'=>$file->getError()];
        }
    }
}
