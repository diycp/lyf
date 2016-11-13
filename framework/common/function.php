<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

use lyf\Cache;
use lyf\Config;
use lyf\Request;

/**
 * 核心框架公共函数
 */

if (!function_exists('dump')) {
    // 调试数据
    function dump($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
}

if (!function_exists('model')) {
    // 实例化数据模型
    function model($name)
    {
        // 解析参数
        if (false === strpos($name, '/')) {
            // 不存在/
            $current_model = Config::get('route.current_model');
            $class         = $current_model . '\\model\\' . $name;

            // 优先寻找当前模块下的模型，没有则寻找公共模型
            $filename = APP_PATH . str_replace('\\', '/', $class) . '.php';
            if (!is_file($filename)) {
                $class = 'common\\model\\' . $name;
            }
        } else {
            $name  = explode('/', $name);
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
}

if (!function_exists('request')) {
    /**
     * 获取当前Request对象实例
     * @return Request
     */
    function request()
    {
        return Request::instance();
    }
}

if (!function_exists('cache')) {
    /**
     * 缓存管理
     * @param mixed     $name 缓存名称，如果为数组表示进行缓存设置
     * @param mixed     $value 缓存值
     * @param mixed     $options 缓存参数
     * @param string    $tag 缓存标签
     * @return mixed
     */
    function cache($name, $value = '', $options = null, $tag = null)
    {
        if (is_array($options)) {
            // 缓存操作的同时初始化
            Cache::connect($options);
        } elseif (is_array($name)) {
            // 缓存初始化
            return Cache::connect($name);
        }
        if (is_null($name)) {
            return Cache::clear($value);
        } elseif ('' === $value) {
            // 获取缓存
            return 0 === strpos($name, '?') ? Cache::has(substr($name, 1)) : Cache::get($name);
        } elseif (is_null($value)) {
            // 删除缓存
            return Cache::rm($name);
        } elseif (0 === strpos($name, '?') && '' !== $value) {
            $expire = is_numeric($options) ? $options : null;
            return Cache::remember(substr($name, 1), $value, $expire);
        } else {
            // 缓存数据
            if (is_array($options)) {
                $expire = isset($options['expire']) ? $options['expire'] : null; //修复查询缓存无法设置过期时间
            } else {
                $expire = is_numeric($options) ? $options : null; //默认快捷缓存设置过期时间
            }
            if (is_null($tag)) {
                return Cache::set($name, $value, $expire);
            } else {
                return Cache::tag($tag)->set($name, $value, $expire);
            }
        }
    }
}
