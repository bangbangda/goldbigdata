<?php

namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\GoldsModel;

class Gold extends Controller {

    /**
     * 黄金大数据主页
     */
    function index() {
        $GoldsModel = new GoldsModel();
        // 开盘价最大值
        $data['openpriMax'] = $GoldsModel->selectMax('openpri')->get()->getRowArray();
        // 开盘价最小值
        $data['openpriMin'] = $GoldsModel->selectMin('openpri')->get()->getRowArray();
        // 所有数据
        $data['variety'] = $GoldsModel->groupBy('variety')->get()->getResultArray();
        echo view('admin/header');
        echo view('admin/gold/list',$data);
        echo view('admin/footer');
    }
    
    function post_check() {
        $data = $this->request->getPost();
        $validation =  \Config\Services::validation();
   
        $validation->setRules(
            array('maxpri' => 'required|valid_email'),
            array('maxpri' => array(
                    'required' => 'You must choose a {field}.{param}'
                )
            )
        );
        $validation->run($data);
        if (!$this->validate([])){
            var_dump($validation->getErrors());
        } else {
            echo 'Success';
        }
    }

    /**
     * ajax 数据获取
     */
    function post_data() {
        $GoldsModel = new GoldsModel();
        // 获取值 
        $post = $this->request->getPost();
        // 初始化检索条件
        $where_array = array();
        // 判断是否存在开盘价滑块
        if (isset($post['openpriMin'])) {
            $where_array['openpri >='] = $post['openpriMin'];
            $where_array['openpri <='] = $post['openpriMax'];
        }
        // 判断是否存在最高价检索条件
        if (isset($post['maxpri']) && $post['maxpri'] != '') {
            $where_array['maxpri'] = $post['maxpri'];
        }
        foreach ($post as $key => $value) {
            // 判断是否存在排序
            $sort = explode('sort_', $key);
            if (isset($sort[1])) {
                $sort[2] = $value;
                break;
            }
            // 判断是否存在检索条件 类型
            if (isset($post['variety']) && $post['variety'] != '') {
                $where_array['variety'] = $post['variety'];
            }
        }
        // 查询当前请求的数据数量
        $info['data'] = $GoldsModel->where($where_array)
                                ->orderBy($sort[1], $sort[2])
                                ->get($post['pSize'], $post['pSize'] * ( ($post['cPage'] == 0 ? 1:$post['cPage']) - 1))  // $post['cPage'] 当数据量为0时，在返回时的页数为0，感觉是官方bug
                                ->getResultArray();
        // 查询数据总量
        $totals = $GoldsModel->where($where_array)
                                ->orderBy($sort[1], $sort[2])
                                ->get()
                                ->getResultArray();
        $info['totals'] = count($totals);
        echo json_encode($info);
    }

}
