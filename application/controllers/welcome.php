<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	private $view_data;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$view_data['movies'] = $this->mongo_db
		->where_gte('imdbRating', 8.0)
		->order_by(array(
			'_id' => 'desc'
		))
		->limit(3)
		->get('movies');
		//var_dump($view_data);die();
		$this->load->view('welcome_message', $view_data);
	}
	
	public function view($id)
	{
		$view_data['movie'] = $this->mongo_db
		->where(array(
			'imdbID' => $id
		))
		->get('movies');
		//var_dump($view_data);die();
		$this->load->view('single_view', $view_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
