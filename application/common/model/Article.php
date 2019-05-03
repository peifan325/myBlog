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
    public function comments()
    {
        return $this->hasMany('Comment', 'article_id', 'id');
    }



    /**
     * 获取文章列表
     * $data   {curr:1,'limit':5,'title':'xxx'} 有搜索 有分页,
     *         {curr:1,'limit':5,'cateId':'xxx'} 有分类 有分页,
     *         {curr:1,'limit':5,'title':''}
     *         {title:'xxx'} 只有搜索
     *          {cateId: 1}  只有分类
     *         {curr:1,'limit':5} 只有分页

     *         {}   //首次访问
     * return  []
     */
    
    public function getArtList($data)
    {
        $curr  = isset($data['curr'])?$data['curr']:1;   //当前页
        $limit = isset($data['limit'])?$data['limit']:2;  //每页显示数量

        $where = [
            ['status', '<>', 1]   //文章状态
        ];
        
        if (isset($data['cateId'])) {
            $where[] = ['cate_id', '=', $data['cateId']];
        }
        if (isset($data['title'])) {
            if (is_string($data['title']) && $data['title'] !== "") {
                $where[] = ['title','like', '%'.$data['title'].'%'];
            }
        }

        $res = [];
        $res['where'] = $where;
        $res['count'] = $this->where([$where])->count();    //数据总数
        $res['data'] = $this->where([$where])
                            ->limit(($curr-1)*$limit, $limit)
                            ->order('create_time', 'desc')
                            ->with(['user'=>function ($query) {
                                $query->field('id,username');
                            },'cate'=>function ($query) {
                                $query->field('id,name');
                            }])
                            ->select();
                         
        if ($res['data']) {
            return $res;
        } else {
            return [];
        }
    }


    public function getArt($id)
    {
        $art = $this->withCount('comments')->where('status', '0')->get($id);
        return $art;
    }

    //评论获取
    public function getComments($id)
    {
        $art = $this->getArt($id);
        if ($art) {
            return $art->comments()->select(function ($query) {
                $query->with('user')->where('status', 0)->order('create_time', 'desc');
            });      //返回文章所有评论
        }
        return null;
    }

    public static function saveArt($data)
    {
        $validate = new \app\common\validate\ArticleVali();
        if (!$validate->scene('save')->check($data)) {
            return $validate->getError();
        }

        $result = self::create($data, true);
        return 1;
    }
}
