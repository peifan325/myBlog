<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;
class Cate extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $table = 'cate';

    protected $autoWriteTimestamp = true;

    public function article()
    {
        return $this->hasMany('Article', 'cate_id', 'id');
    }  
}