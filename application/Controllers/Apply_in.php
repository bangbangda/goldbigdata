<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ApplyModel;

/**
 * 中德护士（护理）交流计划学员报名表
 *
 * @author Administrator
 */
class Apply_in extends Controller {
    function __construct(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \CodeIgniter\Log\Logger $logger = null) {
        parent::__construct($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    /**
     * 首页
     */
    public function index() {
        echo view('apply');
    }
    
    /**
     * 上传图片
     */
    public function upload_img() {
        $files = $this->request->getFile('file');
        $newName = $files->getRandomName();
        $files->move($_SERVER['DOCUMENT_ROOT'].'/apply/upload_img/temp', $newName);
        echo $newName;
    }
    
    /**
     * 插入数据
     */
    public function insert_data() {
        $data = $this->request->getPost();
        $result = copy($_SERVER['DOCUMENT_ROOT'].'/apply/upload_img/temp/' . $data['photo_name'], $_SERVER['DOCUMENT_ROOT'].'/apply/upload_img/'.$data['photo_name']);
        unlink($_SERVER['DOCUMENT_ROOT'].'/apply/upload_img/temp/' . $data['photo_name']);
        $ApplyModel = new ApplyModel();
        $ApplyModel->insert($data);
    }

}
