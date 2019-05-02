<?php


namespace app\common\validate;

use think\Validate;

class UserVali extends Validate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'password_confirm|确认密码' => 'require|confirm:password',
        'email|邮箱' => 'require|email|unique:user',
        'status|状态' => 'require',
        'role|权限' => 'require',
        'verify|验证码' => 'require|captcha'
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password', 'verify']);
    }

    public function sceneRegister()
    {
        return $this->only(['username', 'password', 'password_confirm', 'email', 'verify'])
            ->append('username', 'unique:user');
    }
}
