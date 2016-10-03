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

        // 配置初始化
        Config::init();

        // URL调度
        Route::dispatch();
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
