<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Misc extends CI_Controller {

	private $view_data;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		//var_dump($view_data);die();
		$this->load->view('welcome_message', $view_data);
	}

	public function about()
	{
		$view_data['count'] = $this->mongo_db
		->count('movies');
		exec("pgrep python", $pids);
		if (empty($pids)) {
			$view_data['d_running'] = false;
		}
		else {
			$view_data['d_running'] = true;
		}

		$this->load->view('about', $view_data);
	}
}

/* End of file misc.php */
/* Location: ./application/controllers/misc.php */
