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
        // 获取所有值
        $data = $this->request->getPost();
        // 加载验证类
        $validation =  \Config\Services::validation();
        // 初始化验证信息
        $rules = array();
        if ($data['maxpri'] != '') {
            $rules['maxpri'] = 'numeric';
        }
        $rules_err = [
            'maxpri' => [
                'numeric' => '最高价 请输入数字',
            ]
        ];
        $validation->setRules($rules,$rules_err);
        $validation->run($data);
        // 返回验证信息
        if (!$this->validate([])){
            echo json_encode($validation->getErrors());
        } else {
            echo json_encode($validation->getErrors());
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
            $where_array['maxpri'] = (float)$post['maxpri'];
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
