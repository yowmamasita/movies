<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require "application/libraries/Builder.php"; use \MongoQB\Builder;

class Movies extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/movies
     *    - or -  
     *         http://example.com/index.php/movies/index
     *    - or -
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
        // $qb = \MongoQB\Builder(array(
        //     'dsn'   =>  'mongodb://user:pass@localhost:27017/databaseName'
        // );
        // $results = $qb
        //     ->whereGt('age', 21)
        //     ->whereIn('likes', ['whisky'])
        //     ->where('country', 'UK')
        //     ->get('collectionName');
        // print_r($results);
        $view_data['movies'] = $this->mongo_db
        ->where_gte('imdbRating', 7.5)
        ->where_gte('imdbVotes', 1000)
        #->where_gte('movieYear', 2000)
        ->where_ne('moviePoster', 'N/A')
        ->where_ne('moviePlot', 'N/A')
        ->order_by(array(
            '_id' => 'desc'
        ))
        ->limit(6)
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

        $view_data['title'] = $view_data['movie'][0]['movieTitle'];


        if ($reason = $this->input->get('notif'))
        {
            $view_data['notif'] = true;
        }

        //var_dump($view_data);die();
        $this->load->view('single_view', $view_data);
    }

    public function browse($mode = 'all', $params = 'atoz', $sort = 'atoz')
    {
        $view_data['title'] = "List of ".$mode." movies";
        $view_data['movies'] = $this->mongo_db;
        $view_data['url'] = array($mode, $params, $sort);
        if($mode == 'all')
        {
            $view_data['type'] = $mode;
            $sort = $params;
        }
        elseif ($mode == 'genre')
        {
            $valid_genre = array("action", "adventure", "animation", "biography", "comedy", "crime", "documentary", "drama", "family", "fantasy", "film-noir", "game-show", "history", "horror", "music", "musical", "mystery", "news", "reality-tv", "romance", "sci-fi", "sport", "talk-show", "thriller", "war", "western");
            if (in_array($params, $valid_genre))
            {
                $view_data['type'] = $params;
                $view_data['movies'] = $view_data['movies']->where(array('movieGenre' => array('$regex' => ucfirst($params))));
            }
            elseif ($params == 'atoz')
            {
                $view_data['title'] = "List of all genres";
                $this->load->view('genre_list', $view_data);
            }
            else
            {
                //error
                var_dump('error');
            }
        }
        elseif ($mode == 'country')
        {
            $params = str_replace("_", " ", trim($params));
            $view_data['type'] = $params;
            $view_data['movies'] = $view_data['movies']->where(array('movieCountry' => array('$regex' => $params)));
        }
        elseif ($mode == 'actor')
        {
            $params = str_replace("_", " ", trim(urldecode($params)));
            $view_data['type'] = $params;
            $view_data['movies'] = $view_data['movies']->where(array('movieActors' => array('$regex' => $params)));
        }
        else
        {
            //error
            var_dump('error');
            //$this->load->helper('url');
            //redirect(base_url("/browse/all"));
        }
        switch ($sort) {
            case 'rating':
                $view_data['movies'] = $view_data['movies']->order_by(array('imdbRating' => 'desc', 'imdbVotes' => 'desc'))->where_gte('imdbVotes', 5000);
                $view_type = 'list_view_general';
                break;
            case 'year':
                $view_data['movies'] = $view_data['movies']->order_by(array('movieYear' => 'desc', 'movieTitle' => 'asc'));
                $view_type = 'list_view_general';
                break;
            case 'popularity':
                $view_data['movies'] = $view_data['movies']->order_by(array('imdbVotes' => 'desc', 'imdbRating' => 'desc', 'movieTitle' => 'asc'));
                $view_type = 'list_view_general';
                break;
            case 'unrated':
                $view_data['movies'] = $view_data['movies']->order_by(array('imdbRating' => 'desc', 'imdbVotes' => 'desc'))->where_lte('imdbVotes', 5000);
                $view_type = 'list_view_general';
                break;
            default:
                $view_type = 'list_view';
                $view_data['movies'] = $view_data['movies']->order_by(array('movieTitle' => 'asc', 'movieYear' => 'asc'));
        }
        if ($sort != 'atoz')
        {
            $view_data['params'] = $sort;
        }
        $view_data['movies'] = $view_data['movies']->get('movies');
        $this->load->view($view_type, $view_data);
    }

    public function report($youtubeId)
    {
        $this->load->helper('url');
        $view_data['movie'] = $this->mongo_db
        ->where(array(
            'youtubeId' => $youtubeId
        ))
        ->get('movies');

        if (count($view_data['movie']) == 0)
        {
            redirect(base_url());
        }
        $view_data['title'] = "Report a video";

        if ($reason = $this->input->post('reportReason'))
        {
            $valid_reasons = array('diff_movie', 'deadd', 'incomplete');
            if (in_array($reason, $valid_reasons))
            {
                $this->mongo_db->insert('reports', array('imdbId' => $view_data['movie'][0]['imdbID'], 'youtubeId' => $youtubeId, 'reason' => $reason));
                redirect(base_url("_".substr($view_data['movie'][0]['imdbID'], 2)."/".preg_replace('/[^A-Za-z0-9\- ]/', '', str_replace(' ','-',$view_data['movie'][0]['movieTitle']))."?notif=true"));
            }
            else
            {
                $view_data['notif'] = true;
            }
        }

        //var_dump($view_data);die();
        $this->load->view('report', $view_data);
    }

    public function search()
    {
        echo "fuck yu";
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

/* End of file movies.php */
/* Location: ./application/controllers/movies.php */
