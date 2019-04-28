<?php
namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;
class Message extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $table = 'message';

    protected $autoWriteTimestamp = true;

    public function user(){
        return $this->belongsTo('User', 'user_id', 'id');
    }
}