<?php

namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\GoldsModel;

class Gold extends Controller {

    function index() {
        //echo $_SERVER['SERVER_NAME'];exit;
        //echo base_url();exit;
        echo view('admin/header');
        echo view('admin/gold/list');
        echo view('admin/footer');
    }

    function post_data() {
        //var_dump(explode('sort_', 'sort_time'));exit;
        // 获取值 
        $post = $this->request->getPost();
        // 判断排序
        foreach ($post as $key => $value) {
            $sort = explode('sort_', $key);
            if (isset($sort[1])) {
                $sort[2] = $value;
                break;
            }
        }
        $GoldsModel = new GoldsModel();
        $builder = $GoldsModel->table('golds');
        $info['data'] = $builder->orderBy($sort[1], $sort[2])
                                ->get($post['pSize'], $post['pSize'] * ($post['cPage'] - 1))
                                ->getResultArray();
        $info['totals'] = $builder->countAll();;
        echo json_encode($info);
    }

}
