<?php


namespace app\common\validate;

use think\Validate;

class ArticleVali extends Validate
{
    protected $rule = [
        'title|标题' => 'require',
        'content|内容' => 'require',
    ];
    public function sceneSave()
    {
        return $this->only(['title', 'content']);
    }
}
