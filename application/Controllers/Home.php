<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\GoldsModel;

class Home extends Controller
{
	public function index()
	{


		return view('welcome_message');
	}


	public function get_data()
	{
		$db = \Config\Database::connect();
		$sql = 'SELECT max(`latestpri`) latestpri,
				       date_format(`time`,"%H:%i") `time`
				FROM `golds`
				WHERE `create_date` = "'.date('Y-m-d').'"
				  AND `variety` = "AU99.99"
				  AND date_format(`time`,"%Y-%m-%d") = "'.date('Y-m-d').'"
				GROUP BY `time`
				ORDER BY `time`';
		$au9999_data = $db->query($sql)->getResult('array');

		$latestpri = [];
		$time = [];
		foreach ($au9999_data as $key => $value) {
			$latestpri[] = (float)$value['latestpri'];
			$time[] = $value['time'];
		}
		$ajaxData['latestpri'] = $latestpri;
		$ajaxData['time'] = $time;
		echo json_encode($ajaxData);
	}

	//--------------------------------------------------------------------

}
