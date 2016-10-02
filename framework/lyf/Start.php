<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace lyf;
/**
 * 初始化
 */
class Start
{
    // 框架初始化
    public static function run ()
    {
        // autoload
        require './vendor/autoload.php';  // 加载composer提供的autoload文件
        spl_autoload_register('\lyf\Start::autoload');  // 注册AUTOLOAD方法

        // 加载配置文件
        $_config = Start::getConfig();

        // 定义当前请求的系统常量
        define('REQUEST_TIME', $_SERVER['REQUEST_TIME']);
        define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
        define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
        define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
        define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
        define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
        define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);

        // URL调度
        Route::dispatch();
    }

    // 获取配置
    public static function getConfig ()
    {
        $_config = include LYF_PATH.'config/default.php';
        $common_config = include APP_PATH.'common/config/config.php';
        $common_config['datebase'] = include APP_PATH.'common/config/datebase.php';  // 数据库配置
        $common_config['route'] = include APP_PATH.'common/config/routes.php';       // 路由配置

        return array_merge(
            $_config,        // 框架默认配置
            $common_config   // 应用应用公共路由配置
        );
    }

    /**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class)
    {
        if (false !== strpos($class, '\\')) {
            $name = strstr($class, '\\', true);
            if (in_array($name, array('lyf'))) {
                // 框架核心类库的命名空间自动定位
                $filename = LYF_PATH . str_replace('\\', '/', $class) . '.php';
            } else if ($name === 'app') {
                // 应用为命名空间
                $filename = APP_PATH . substr(str_replace('\\', '/', $class), 3) . '.php';  
            } else {
                die('命名空间错误');
            }
            if (is_file($filename)) {  
                // Win环境下面严格区分大小写
                if (IS_WIN && false === strpos(str_replace('/', '\\', realpath($filename)), $class . '.php')) {
                    return;
                }
                include $filename;
            }
        }
    }
}
