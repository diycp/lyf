<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace lyf;
use lyf\Config;
/**
 * 路由
 */
class Route
{
    // URL解析
    public static function dispatch ()
    {
        // 解析url成数组
        $path_info = '';
        if ($_SERVER['PATH_INFO']) {   // pathinfo模式
            $path_info = rtrim($_SERVER['PATH_INFO'], Config::get('url_suffix'));
            $paths = explode('/', trim($path_info, '/'));
        } else {
            $paths = array();
            $paths[0] = Config::get('default_module');
            $paths[1] = Config::get('default_controller');
            $paths[2] = Config::get('default_action');
        }

        // 特殊路由
        if (count($paths) === 1) {  // pathinfo只有一个参数
            // 访问模块的默认方法
            $paths[1] = Config::get('default_controller');
            $paths[2] = Config::get('default_action');
        }
        if (count($paths) === 2) {  // pathinfo只有一个参数
            // 访问模块的默认方法
            $paths[2] = Config::get('default_action');
        }

        // 解析url中的模型/控制器/方法
        Config::set('route.current_model', strip_tags($paths[0]));
        Config::set('route.current_controoler', strip_tags(ucfirst($paths[1])));
        Config::set('route.current_action', strip_tags($paths[1]));

        // 执行方法
        self::exec(Config::get('route.current_model'), Config::get('route.current_controoler'), Config::get('route.current_action'));
    }

    /**
     * 执行应用程序
     * @access public
     * @return void
     */
    public static function exec($model, $controller, $action)
    {
        if (!preg_match('/^[A-Za-z](\/|\w)*$/', $controller)) {
            // 安全检测
            $controller = false;
        } else {
            //创建控制器实例
            $class = 'app\\' . $model . '\controller\\' . $controller;
            $controller = new $class ;
        }

        if (!$controller) {
            die('控制器不存在：' . $controller);
        }

        // 调用控制器的方法
        try {
            self::invokeAction($controller, $action);
        } catch (\ReflectionException $e) {
            // 方法调用发生异常后 引导到__call方法处理
            $method = new \ReflectionMethod($controller, '__call');
            $method->invokeArgs($controller, array($action, ''));
        }
        return;
    }

    public static function invokeAction($controller, $action)
    {
        if (!preg_match('/^[A-Za-z](\w)*$/', $action)) {
            // 非法操作
            throw new \ReflectionException();
        }
        //执行当前操作
        $method = new \ReflectionMethod($controller, $action);
        if ($method->isPublic() && !$method->isStatic()) {
            $class = new \ReflectionClass($controller);
            $method->invoke($controller);
        } else {
            // 操作方法不是Public 抛出异常
            throw new \ReflectionException();
        }
    }
}
