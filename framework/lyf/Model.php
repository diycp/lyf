<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Lyf;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
 * Model
 */
class Model extends Illuminate\Database\Eloquent\Model
{
    public function init()
    {
        // Eloquent ORM
        $capsule = new Capsule;
        $capsule->addConnection($_config['datebase']);
        $capsule->bootEloquent();
    }
}
