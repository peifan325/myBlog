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

    public static function login($data)
    {
        $validate = new \app\common\validate\UserVali();
        
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }

        $where = [
            ['username','=', $data['username']],
            ['password','=', md5($data['password'])],
        ];
        $result = self::where([ $where ])->find();
        if ($result) {
            if ($result['status'] != 0) {
                return '此账户被禁用！';
            }
            session('user_info', ['id' => $result['id'], 'name'=>$result['username'],'img'=>$result['img'], 'role' => $result['role']]);
            return 1;
        } else {
            return '用户名或者密码错误！';
        }
    }
    
    public static function register($data)
    {
        $validate = new \app\common\validate\UserVali();
        
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }

        $data['password'] = md5($data['password']);
        $data['role'] = 0;
        $data['status'] = 0;
        $data['img'] = '/static/static/images/info-img.png';  //默认头像

        $result = self::create($data, true);

        session('user_info', ['id' => $result['id'], 'name'=>$result['username'], 'role'=>$result['role'], 'img'=>$result['img']]);
        return 1;
    }
}
