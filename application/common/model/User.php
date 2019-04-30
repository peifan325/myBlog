<?php
namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;
class User extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $table = 'user';

    protected $autoWriteTimestamp = true;

    public function article()
    {
        return $this->hasMany('Article', 'user_id', 'id');
    }
    public function message()
    {
        return $this->hasMany('Message', 'user_id', 'id');
    }   
    public function comment()
    {
        return $this->hasMany('Comment', 'user_id', 'id');
    }

}