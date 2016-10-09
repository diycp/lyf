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
use Illuminate\Database\Capsule\Manager as Capsule;
/**
 * 前台基础控制器，其他控制器一般都要继承此控制器便于统一要求登陆等
 */
class Index extends Home
{
    // 这是前台（Home）首页方法
    public function index()
    {
        $capsule = new Capsule;
        //$capsule->addConnection(Config::get('datebase'));
        //$capsule->setAsGlobal();  // Make this Capsule instance available globally via static methods... (optional)
        //$capsule->bootEloquent();
        
        //$m = new \app\common\model\Index();
        var_dump($capsule);
        echo "<h1>这是" . LYF_NAME . "前台首页</h1>";
    }
}
