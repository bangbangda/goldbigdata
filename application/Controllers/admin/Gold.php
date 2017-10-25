<?php

namespace App\Controllers\admin;

use App\Libraries\MyController;
use App\Models\GoldsModel;

class Gold extends MyController {

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
     * 检索
     */
    function post_check() {
        $this->ajax_check();
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
        foreach ($info['data'] as $key => $value) {
            $info['data'][$key]['operation'] = "修改";
        }
        // 查询数据总量
        $totals = $GoldsModel->where($where_array)
                                ->orderBy($sort[1], $sort[2])
                                ->get()
                                ->getResultArray();
        $info['totals'] = count($totals);
        echo json_encode($info);
    }

    /**
     * ajax 数据获取
     */
    function get_row() {
        $this->ajax_check();
        // 获取值 
        $post = $this->request->getPost();
        $GoldsModel = new GoldsModel();
        $info = $GoldsModel->getWhere(['id' => $post['id']])
                                   ->getRowArray();
        echo json_encode($info);
    }
    
    /**
     * 更新
     */
    function update_check() {
        $this->ajax_check();
        // 获取所有值
        $data = $this->request->getPost();
        // 加载验证类
        $validation =  \Config\Services::validation();
        // 初始化验证信息
        $rules = array();
        $rules['latestpri'] = 'required|numeric';
        $rules['openpri'] = 'required|numeric';
        $rules_err = [
            'latestpri' => [
                'required' => '最新价 必填',
                'numeric' => '最新价 请输入数字',
            ],
            'openpri' => [
                'required' => '开盘价 必填',
                'numeric' => '开盘价 请输入数字',
            ]
        ];
        $validation->setRules($rules,$rules_err);
        $validation->run($data);
        
        $result = array('error_flag' => 0);
        // 返回验证信息
        if (!$this->validate([])){
            $result['error_flag'] = 1;
            $result['error_msg'] = '';
            foreach ($validation->getErrors() as $key => $value) {
                $result['error_msg'] .= $value.'</br>';
            }
        } else {
            $GoldsModel = new GoldsModel();
            // 开始更新
            $data = array(
                'id' => $data['id'],
                'latestpri'  => $data['latestpri'],
                'openpri'  => $data['openpri'],
                'variety'  => $data['variety'],
                'time'  => $data['time']
            );
            $GoldsModel->replace($data);
        }
        echo json_encode($result);
    }
    
    /**
     * 删除一条数据
     * @param type $id id
     */
    function delete_data($id) {
        $this->ajax_check();
        $GoldsModel = new GoldsModel();
        $GoldsModel->delete(array('id' => $id));
    }

}
