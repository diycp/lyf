<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace app\common\model;

use app\common\model\Model;

/**
 * 默认数据表模型
 */
class Index extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'admin_config';
}
