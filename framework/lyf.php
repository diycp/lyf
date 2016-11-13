<?php
// +----------------------------------------------------------------------
// | lyf [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://lyf.lyunweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

/**
 * lyf公共入口文件
 */

// 设置编码为utf8
header("Content-type: text/html; charset=utf-8");

// PHP版本检查防止PHP版本太低
if (version_compare(PHP_VERSION, '5.6.4', '<')) {
    die('您的PHP版本太低，lyf 至少需要 PHP > 5.6.4 !');
}

// PHP开启报错
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

// lyf版本信息
const LYF_NAME        = 'lyf';
const LYF_TITLE       = '零云框架';
const LYF_VERSION     = '0.0.1';
const LYF_VERSION_EXT = 'beta1';

// 系统常量定义
define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__) . '/'); // 框架目录
defined('LYF_PATH') or define('LYF_PATH', __DIR__ . '/'); // 框架目录
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/application/'); // 应用目录，也就是你项目需要写代码的目录

// 框架初始化
require LYF_PATH . 'lyf/App.php';
lyf\App::init();
