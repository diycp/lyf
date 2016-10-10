<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
use lyf\Config;
/**
 * 核心框架公共函数
 */

// 调试数据
function dump($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

// 实例化数据模型
function model($name) {
    // 解析参数
    if (false === strpos($name, '/')) {  // 不存在/
        $current_model = Config::get('route.current_model');
        $class = $current_model . '\\model\\' .$name;

        // 优先寻找当前模块下的模型，没有则寻找公共模型
        $filename = APP_PATH . str_replace('\\', '/', $class) . '.php';
        if (!is_file($filename)) {
            $class = 'common\\model\\' .$name;
        }
    } else {
        $name = explode('/', $name);
        $class = $name[0] . '\\model\\' . $name[1];
    }

    // 判断数据模型是否存在
    $filename = APP_PATH . str_replace('\\', '/', $class) . '.php';
    if (!is_file($filename)) {
        dump('不存在' . $filename . '模型，请检查您的模型是否正确定义！');
    }

    // 实例化数据模型
    $class = '\app\\' . $class;
    return new $class();
}
