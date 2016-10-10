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
 * 控制器
 */
class Controller
{
    /**
     * 视图实例对象
     * @var view
     * @access protected
     */
    protected $view = null;

    // 输出模版或者返回数据
    protected function display($template = '') {
        if (Config::get('request.is_ajax')) {
            return json_encode($this->data);  // 如果是ajax请求直接返回数据
        } else {
            // 构造模板路径
            if ($template === '') {
                $template = strtolower(Config::get('route.current_controoler')) . '/' . Config::get('route.current_action');
            } elseif (false === strpos($template, '/')) {  // 不存在/
                $template = strtolower(Config::get('route.current_controoler')) . '/' . $template;
            }

            // 验证模板文件是否存在
            $template = APP_PATH . Config::get('route.current_model') . '/view/' . $template . Config::get('view.suffix');
            if (is_file($template)) {
                $this->view->display($template);
            } else {
                dump('模板文件不存在：' . $template);
            }
        }
    }
}
