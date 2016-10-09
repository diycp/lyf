<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Lyf;
use lyf\Config;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as BaseModel;
/**
 * Model
 */
class Model extends BaseModel
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    // 初始化
    public function init()
    {
        // Eloquent ORM
        $capsule = new Capsule;
        $capsule->addConnection(Config::get('datebase'));
        $capsule->setAsGlobal();  // Make this Capsule instance available globally via static methods... (optional)
        $capsule->bootEloquent();
    }
}
