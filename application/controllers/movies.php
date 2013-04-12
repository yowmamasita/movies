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

		if (count($view_data['movie']) == 0)
		{
			$this->load->helper('url');
			redirect(base_url());
		}		


		if ($reason = $this->input->get('notif'))
		{
			$view_data['notif'] = true;
		}

		//var_dump($view_data);die();
		$this->load->view('single_view', $view_data);
	}
	
	public function browse($mode = 'all', $params = 'atoz')
	{
		if ($mode == 'all')
		{
			if ($params == 'atoz')
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
			elseif ($params == 'rating')
			{
				$view_data['params'] = $params;
				$view_data['movies'] = $this->mongo_db
				->order_by(array(
					'imdbRating' => 'desc'
				))
				->get('movies');
				//var_dump($view_data);die();
				$this->load->view('list_view_general', $view_data);
			}
			elseif ($params == 'year')
			{
				$view_data['params'] = $params;
				$view_data['movies'] = $this->mongo_db
				->order_by(array(
					'movieYear' => 'desc'
				))
				->get('movies');
				//var_dump($view_data);die();
				$this->load->view('list_view_general', $view_data);
			}
		}
		elseif ($mode == 'genre')
		{
			if ($params == 'atoz')
			{
				$this->load->view('genre_list');
			}
			else
			{
				$valid_genre = array("Action", "Adventure", "Animation", "Biography", "Comedy", "Crime", "Documentary", "Drama", "Family", "Fantasy", "Film-Noir", "Game-Show", "History", "Horror", "Music", "Musical", "Mystery", "News", "Reality-TV", "Romance", "Sci-Fi", "Sport", "Talk-Show", "Thriller", "War", "Western");
				if (in_array($params, $valid_genre))
				{
					$view_data['params'] = $params;
					$view_data['movies'] = $this->mongo_db
					->where(array(
						'movieGenre' => array('$regex' => $params)
					))
					->order_by(array(
						'movieTitle' => 'asc'
					))
					->get('movies');
					//var_dump($view_data);die();
					$this->load->view('list_view', $view_data);
				}
				else
				{
					$this->load->helper('url');
					redirect(base_url("/movies/browse/all"));
				}
			}
		}
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
