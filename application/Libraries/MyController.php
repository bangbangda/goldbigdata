<?php

namespace App\Libraries;

/**
 * 扩展核心类
 *
 * @author Administrator
 */
class MyController extends \CodeIgniter\Controller {
    
    /**
     * 验证ajax请求
     */
    protected function ajax_check() {
        if (!$this->request->isAJAX()) {
            exit('No direct script access allowed');
        }
    }
}
