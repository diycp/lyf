<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace lyf;

use Illuminate\Database\Capsule\Manager as Capsule;
use lyf\Config;

/**
 * Model
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    // 初始化
    public static function init()
    {
        $capsule = new Capsule;
        $capsule->addConnection(Config::get('datebase'));
        $capsule->setAsGlobal(); // Make this Capsule instance available globally via static methods... (optional)
        $capsule->bootEloquent();
    }
}
