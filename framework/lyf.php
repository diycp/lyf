<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

// lyf公共入口文件

// 设置编码为utf8
header("Content-type: text/html; charset=utf-8");

// PHP版本检查防止PHP版本太低
if (version_compare(PHP_VERSION,'5.3.0','<')) {
    die('您的PHP版本太低，lyf 至少需要 PHP > 5.3.0 !');
}

// lyf版本信息
const LYF_VERSION = '0.0.1';
const LYF_VERSION_EXT = 'beta1';

// 系统常量定义
defined('LYF_PATH') or define('LYF_PATH', __DIR__ . '/');  // 框架目录
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/application/'); // 应用目录，也就是你项目需要写代码的目录

// 加载composer提供的autoload文件
// 很多开发者写面向对象的应用程序时对每个类的定义建立一个 PHP 源文件。一个很大的烦恼是不得不在每个脚本开头写一个长长的include文件列表（每个类一个文件）。
// 在 PHP 5 中，不再需要这样了。可以定义一个 __autoload() 函数，它会在试图使用尚未被定义的类时自动调用。通过调用此函数，脚本引擎在 PHP 出错失败前有了最后一个机会加载所需的类。
require './vendor/autoload.php';

// 路由配置
require APP_PATH.'common/routes.php';
