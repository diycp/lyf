<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace app\home\controller;
use app\home\controller\Home;
use lyf\Config;
/**
 * 前台基础控制器，其他控制器一般都要继承此控制器便于统一要求登陆等
 */
class Index extends Home
{
    // 这是前台（Home）首页方法
    public function index()
    {
        $result = model('common/Index')::all()->toArray();
        $this->display();
    }
}
