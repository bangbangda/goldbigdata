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

    /**
     * ajax 数据获取
     */
    function post_data() {
        $GoldsModel = new GoldsModel();
        // 获取值 
        $post = $this->request->getPost();
        //var_dump($post);
        // 初始化检索条件
        $where_array = array();
        // 判断是否存在开盘价滑块
        if (isset($post['openpriMin'])) {
            $where_array['openpri >='] = $post['openpriMin'];
            $where_array['openpri <='] = $post['openpriMax'];
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
        $info['data'] = $GoldsModel->where($where_array)
                                ->orderBy($sort[1], $sort[2])
                                ->get($post['pSize'], $post['pSize'] * ($post['cPage'] - 1))
                                ->getResultArray();
        $totals = $GoldsModel->where($where_array)
                                ->orderBy($sort[1], $sort[2])
                                ->get()
                                ->getResultArray();
        $info['totals'] = count($totals);
        echo json_encode($info);
    }

}
