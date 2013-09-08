<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games extends CI_Controller {
/**
 *
 * @var array currentGameData datele la executie sa fie
 * mai multe actiuni
 */
    public $currentGameData    = array();
    
    function __construct() {
        parent::__construct();
        $this->load->model('gamesModel');
        $this->load->model('usersModel');
    }     
    /**
     * @var array $data
     * @var array $start_list  toti utilizatori in array pentru afishrea pe toti dupa id 
     * @var int $limit - per_page
     * 
     */
    public function lists($start_list = 0) {
        $data = array();
        $this->load->model('gamesModel');
        
        $config['base_url']     = base_url().'/games/lists/';
        $config['total_rows']   = $this->gamesModel->count();
        $config['per_page']     = 5; 
        
        $data['games_list'] = $this->gamesModel->get($start_list,$config['per_page']);

        $this->pagination->initialize($config); 
        
        $data['page_links'] = $this->pagination->create_links();
        
        $this->display_lib->usersPage($data, 'pages/game_list');
    }
    

    /**
     * si se preia id-ul noului joc, dupa ce se face readresarea spre
     * vizualizarea jocului nou creat       games/show/<game-id>
     */
    public function newGame() {
        
        $reset_back = false;
        $allow_data = true;
        $loading_list   = false;
        $userList   = array();
        
        if(is_array(@$_POST['game_data']['player'])) {
            $loading_list   = true;
            $this->session->userdata['gameUserList_tmp']    = $_POST['game_data']['player'];
            $this->session->sess_write();
        };
        if(!isset($this->session->userdata['gameUserList_tmp'])) {
            $reset_back    = true;
        } else {
            $userList   = $this->session->userdata['gameUserList_tmp'];
            if(empty($userList) || !is_array($userList) )
                $reset_back    = true;
        };
        if($reset_back) {
            $allow_data = false;
        }
        
        if( $allow_data && !$loading_list ) {
            $data   = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
            if( isset($data['value']) && isset($data['player']) ) {
                    $this->load->library('BowllingGame','','bowllingGame_instance');
                    
                    $this->bowllingGame_instance->gamesModel   = $this->gamesModel;
                    $this->bowllingGame_instance->usersModel   = $this->usersModel;
                    
                    $this->bowllingGame_instance->setGameId(true);
                    $this->currentGameData['game']          = $this->bowllingGame_instance;

                    if($this->currentGameData['game']->pushData($data['value'],$data['player'],$userList) === true) {
                              $i = $this->currentGameData['game']->getGameId();
                              $this->session->userdata['gameUserList_'.$i]  = $userList;
                              $this->session->userdata['gameUserList_tmp']  = array();
                              $this->session->sess_write();
                              redirect('games/show/'.abs($i));
                    }
            } else {
                
            }
        }
        
        $this->currentGameData['all-users'] = $this->usersModel->GetAllUsers();
        $this->load->library('BowllingGame','','bowllingGame_instance');
        $this->bowllingGame_instance->gamesModel   = $this->gamesModel;
        $this->bowllingGame_instance->usersModel   = $this->usersModel;
        $this->bowllingGame_instance->setGameId(true);
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players']  = $userList;
        
        
        $this->display_lib->usersPage(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    /**
     * incarcam modlele tablelelor games si users
     * incarcam clasa bowwlingGame_lib in $this->bollingGame_instance
     * extragem statutul jocului din obiectul bowllingGame_instance
     * @param array $userList 
     */
    
    public function show($game_id,$request_partial = 0) {
        
        $return_back = false;
        $userList   = array();
        if(!isset($this->session->userdata['gameUserList_'.$game_id])) {
            $return_back    = true;
        } else {
            $userList   = $this->session->userdata['gameUserList_'.$game_id];
            if(empty($userList) || !is_array($userList) )
                $return_back    = true;
        };
        
        $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );

        $this->load->model('gamesModel');
        $this->load->model('usersModel');
        
        $this->currentGameData['all-users'] = $this->usersModel->GetAllUsers();

        $this->load->library('BowllingGame','','bowllingGame_instance');

        $this->bowllingGame_instance->gamesModel   = $this->gamesModel;
        $this->bowllingGame_instance->usersModel   = $this->usersModel;

        $this->bowllingGame_instance->setGameId($game_id);
     
        $this->currentGameData['game']          = $this->bowllingGame_instance;
       
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
       
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players']  = $userList;
        
        //controlam daca nu exita id cu asa joaca ne redirectioneaza la joc nou
        if( $return_back && empty($this->currentGameData['game-data']) ) {
            redirect('games/newgame');
        }
        
        // incarcam din nou jocul cu statultul 
        // si valorile jocului pentru a prelungi jocul
        if(isset($data['value']) && isset($data['player']))
            if($this->currentGameData['game']->pushData($data['value'],$data['player'],$userList) === true) {
                    $this->currentGameData['game-data']     = $this->currentGameData['game']->getData();
                    $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
            }

        // apelam view-urile cu datele necesare ,
        // redirectionarea la view potrevit 
        if(empty($request_partial)) {
            $this->display_lib->usersPage(array(
                'currentGameData'   => $this->currentGameData
            ), 'pages/game');
        } else {
            $this->display_lib->usersPage(array(
                'currentGameData'   => $this->currentGameData
            ), 'pages/game-json', true);
        }
    }
    /**
     * 
     * @param mixed $dataPosted == $d returneaza tabelul jocului dumpa urmatoarile indici
     * @param mixed $d show data live game
     */
   
    public function actionSuffix(&$dataPosted) {
           if( isset($dataPosted['currentGameData']['game-data'])
                &&
            is_array($dataPosted['currentGameData']['game-data'])
          ) {
            $d  = array(
                    'users' => array()
                       );
            foreach ( $dataPosted['currentGameData']['game-data'] as $r ) {
                if(!isset($d['users'][$r['user_id']]))
                    $d['users'][$r['user_id']]    = array(
                            'user_data' => $dataPosted['currentGameData']['all-users'][$r['user_id']],
                            'rounds'    => array(),
                            'total'     => 0
                        );
                $vTemp  = &$d['users'][$r['user_id']]['rounds'];
                if(!isset($vTemp[$r['round']]))
                    $vTemp[$r['round']]   = array();

                $vTemp[$r['round']][] = $r;
                $d['users'][$r['user_id']]['total']   += $r['value'];
            }
            $dataPosted['currentGameData']['game-data-grouped'] = $d;
        }
    }




}
?>
