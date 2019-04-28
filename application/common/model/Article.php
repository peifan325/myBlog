<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $table = 'article';

    protected $autoWriteTimestamp = true;

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
    public function cate()
    {
        return $this->belongsTo('Cate', 'cate_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany('Comment', 'article_id', 'id');
    }


    /**
     * 获取文章列表
     * $data   {curr:1,'limit':5,'title':'xxx'} 有搜索 有分页,
     *         {curr:1,'limit':5,'title':''}
     *         {title:'xxx'} 只有搜索
     *         {curr:1,'limit':5} 只有分页
     *         {}   //首次访问
     * return  []
     */

    public function getArticles($data)
    {
        $res = [];
        $curr  = isset($data['curr'])?$data['curr']:1;   //当前页
        $limit = isset($data['limit'])?$data['limit']:2;  //每页显示数量
        $where = [
            ['status', '=', '0']
        ];
        
        if (isset($data['title'])) {
            if (is_string($data['title']) && $data['title'] !== "") {
                $where[] = ['title','like', '%'.$data['title'].'%'];
            }
        }

        $res['count'] = $this->where($where)->count();    //数据总数
        $res['data'] = $this->where($where)->limit(($curr-1)*$limit,$limit)->order('create_time','desc')->select();
        if($res){
            return $res;
        }else{
            return [];
        }
    }
}
