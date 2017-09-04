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
		$goldsModel = new GoldsModel();

		$au9999_data = $goldsModel->select('latestpri, DATE_FORMAT(time,"%H:%i") time')
								  ->findWhere([
										'create_date' => date('Y-m-d'),
										'variety' => 'AU99.99'
									]);
							
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
