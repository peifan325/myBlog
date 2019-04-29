<?php
namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;
class Comment extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $table = 'comment';

    protected $autoWriteTimestamp = true;

    public function user(){
        return $this->belongsTo('User', 'user_id', 'id');
    }
    public function article(){
        return $this->belongsTo('Article', 'article_id', 'id');
    }


}