<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movies extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/movies
	 *	- or -  
	 * 		http://example.com/index.php/movies/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/movies/<method_name>
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
		->where_gte('imdbRating', 7.0)
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

		if ($reason = $this->input->get('notif'))
		{
			$view_data['notif'] = true;
		}

		//var_dump($view_data);die();
		$this->load->view('single_view', $view_data);
	}
	
	public function browse()
	{
		$view_data['movies'] = $this->mongo_db
		->order_by(array(
			'movieTitle' => 'asc'
		))
		->get('movies');
		//->command(array("distinct" => "movies", "key" => "movieTitle"));
		//var_dump($view_data);die();
		$this->load->view('list_view', $view_data);
	}

	public function report($youtubeId)
	{
		$view_data['movie'] = $this->mongo_db
		->where(array(
			'youtubeId' => $youtubeId
		))
		->get('movies');

		if ($reason = $this->input->post('reportReason'))
		{
			$this->load->helper('url');
			$valid_reasons = array('diff_movie', 'deadd', 'incomplete');
			if (in_array($reason, $valid_reasons))
			{
				$this->mongo_db->insert('reports', array('imdbId' => $view_data['movie'][0]['imdbID'], 'youtubeId' => $youtubeId, 'reason' => $reason));
				redirect(base_url("/movies/view/".$view_data['movie'][0]['imdbID']."?notif=true"));
			}
			else
			{
				$view_data['notif'] = true;
			}
		}

		//var_dump($view_data);die();
		$this->load->view('report', $view_data);
	}
}

/* End of file movies.php */
/* Location: ./application/controllers/movies.php */
