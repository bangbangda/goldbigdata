<?php

namespace App\Libraries;
/**
 * 自定义规则往这里放
 */
class MyRules {

    public function float_val(string $str, string &$error = null): bool {
        if (is_numeric($str)) {
            return true;
        }
        $error = lang(' 请输入数字');
        return false;
    }

}
