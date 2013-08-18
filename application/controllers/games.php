<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('games_model');
        $this->load->model('all_users');
         $this->load->model('pages_model');
    }

    function Games() {
        parent::CI_Controller();
    }

    public function index() {
        redirect(base_url());
    }
    
    /**
     * 
     */
    public function lists() {
       $data = array();
        //toti utilizatori intru masif care va afisha pe toti printru for
       $this->load->model('games_model');
        //afisheaza doar dupa un id 
       $data['games_list'] = $this->games_model->get(); //tot array-ul va fi doar pe o pagina
       $this->display_lib->users_page($data, 'pages/game_list');
    }
    
    /**
     * 
     */
    private $currentGameData    = array();
    
    public function newgame() {
        $data   = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
        if( isset($data['value']) && isset($data['player']) ) {
                $this->load->library('bowllingGame_lib','','bowllingGame_instance');
                $this->bowllingGame_instance->games_model   = $this->games_model;
                $this->bowllingGame_instance->users_model   = $this->all_users;
                $this->bowllingGame_instance->setGameId(true);
                $this->currentGameData['game']          = $this->bowllingGame_instance;
                if($this->currentGameData['game']->pushData($data['value'],$data['player']) === true) {
                        redirect('games/show/id/'.abs($this->currentGameData['game']->getGameId()));
                }
        }

        $this->currentGameData['all-users']	= $this->all_users->get_allusers();
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->all_users;
        $this->bowllingGame_instance->setGameId(true);
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        $this->currentGameData['game-data']	= $this->currentGameData['game']->getData();
        $this->currentGameData['game-status']	= $this->currentGameData['game']->pushData();
        
        $this->actionSuffix();
        
        $this->display_lib->users_page(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    /**
     * 
     */
    
    public function show($game_id) {
        $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
        $this->load->model('games_model');
        $this->load->model('all_users');
        $this->currentGameData['main_info'] = $this->games_model->get();
        $this->currentGameData['all-users'] = $this->all_users->get_allusers();
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->all_users;
        $this->bowllingGame_instance->setGameId($game_id);
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        $this->currentGameData['game-data']	= $this->currentGameData['game']->getData();
        $this->currentGameData['game-status']	= $this->currentGameData['game']->pushData();
        
        
        if(isset($data['value']) && isset($data['player']))
            if($this->currentGameData['game']->pushData($data['value'],$data['player']) === true) {
                    $this->currentGameData['game-data']     = $this->currentGameData['game']->getData();
                    $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
            }
            
        $this->actionSuffix();
        
        $this->display_lib->users_page(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    private function actionSuffix() {
        if( isset($this->currentGameData['game-data'])
                &&
            is_array($this->currentGameData['game-data'])
          ) {
		$d	= array(
				'users'	=> array()
			);
		foreach ( $this->currentGameData['game-data'] as $row ) {
			if(!isset($d['users'][$row['user_id']]))
				$d['users'][$row['user_id']]	= array(
						'user_data'	=> $this->currentGameData['all-users'][$row['user_id']],
						'rounds'	=> array(),
						'total'		=> 0
					);
			if(!isset($d['users'][$row['user_id']]['rounds'][$row['round']]))
				$d['users'][$row['user_id']]['rounds'][$row['round']]	= array();

			$d['users'][$row['user_id']]['rounds'][$row['round']][]	= $row;
			$d['users'][$row['user_id']]['total']	+= $row['value'];
		}
		$this->currentGameData['game-data-grouped']	= $d;
	}
    }




}
?>
