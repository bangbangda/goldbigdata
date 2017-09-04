<?php namespace App\Controllers;

use CodeIgniter\Controller;
use GO\Scheduler;

class Schedule extends Controller
{
	private $script = ROOTPATH.'public/index.php';

	public function index()
	{
		log_message('debug', 'Crontab Schedule-index start');
		require COMPOSER_PATH;

		$scheduler = new Scheduler();
		// 定时获取黄金数据接口 Start
		$scheduler->php($this->script, '/usr/local/bin/php', ['finance' => 'gold'])
				  ->at('*/15 0-2,9-11,20-23 * * 1-5');
		$scheduler->php($this->script, '/usr/local/bin/php', ['finance' => 'gold'])
				  ->at('30,45 13 * * 1-5');
		$scheduler->php($this->script, '/usr/local/bin/php', ['finance' => 'gold'])
				  ->at('*/15 14 * * 1-5');
		$scheduler->php($this->script, '/usr/local/bin/php', ['finance' => 'gold'])
				  ->at('0,15,30 15 * * 1-5');
		// 定时获取黄金数据接口 End


        $scheduler->run();

	}


}
