<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Lyf;
/**
 * 路由
 */
class Route
{
    // URL解析
    public static function dispatch ()
    {
        // 解析url成数组
        $paths = '';
        if (!empty($_SERVER['PATH_INFO'])) {   // pathinfo模式
            $paths = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        } elseif ($_GET['s']) {
            $paths = explode('/', trim($_GET['s'], '/'));
        } else {
            exit('错误');
        }

        // 解析url中的模型/控制器/方法
        self::getModel($paths);
        self::getController($paths);
        self::getAction($paths);

        // 执行方法
        self::exec();
    }

    /**
     * 获取模型
     * @access public
     * @return void
     */
    public static function getModel($paths)
    {
        // 获取模块名称
        $module = strip_tags($paths[0]);
        define('MODULE_NAME', $module);
        // 检测模块是否存在
        if (MODULE_NAME && is_dir(APP_PATH . MODULE_NAME)) {
            define('MODULE_PATH', APP_PATH . MODULE_NAME . '/');
        } else {
            die('模块不存在：' . MODULE_NAME);
        }
        return;
    }

    /**
     * 获取控制器
     * @access public
     * @return void
     */
    public static function getController($paths)
    {
        // 获取控制器名称
        $controller = strip_tags(ucfirst($paths[1]));
        define('CONTROLLER_NAME', $controller);
        return;
    }

    /**
     * 获取方法
     * @access public
     * @return void
     */
    public static function getAction($paths)
    {
        // 获取aciton名称
        $action = strip_tags($paths[2]);
        define('ACTION_NAME', $action);
        return;
    }

    /**
     * 执行应用程序
     * @access public
     * @return void
     */
    public static function exec()
    {
        if (!preg_match('/^[A-Za-z](\/|\w)*$/', CONTROLLER_NAME)) {
            // 安全检测
            $controller = false;
        } else {
            //创建控制器实例
            $class = 'app\\' . MODULE_NAME . '\controller\\' . CONTROLLER_NAME;
            $controller = new $class ;
        }

        if (!$controller) {
            die('控制器不存在：' . CONTROLLER_NAME);
        }

        // 调用控制器的方法
        try {
            self::invokeAction($controller, ACTION_NAME);
        } catch (\ReflectionException $e) {
            // 方法调用发生异常后 引导到__call方法处理
            $method = new \ReflectionMethod($controller, '__call');
            $method->invokeArgs($controller, array(ACTION_NAME, ''));
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
