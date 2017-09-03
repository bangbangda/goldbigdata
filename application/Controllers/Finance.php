<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\GoldsModel;

/**
 * 金融类接口
 */
class Finance extends Controller
{
    // 获取黄金数据接口地址
    private $gold_url = 'http://web.juhe.cn:8080/finance/gold/shgold?key=5e4d05e570ad5bf349d3fa9f1563bae6';

    /**
     * 黄金数据接口
     * @return [type] [description]
     */
	public function gold()
	{
        require COMPOSER_PATH;
		$goldsModel = new GoldsModel();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', $this->gold_url);

		$result_obj = json_decode($res->getBody());
		if ($result_obj->resultcode == 200 && $result_obj->reason == 'SUCCESSED!') {
			foreach ($result_obj->result[0] as $key => $value) {
				$value->create_date = date('Y/m/d');
				$goldsModel->insert($value);
			}
		}
	}


}
