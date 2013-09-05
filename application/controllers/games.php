<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games extends CI_Controller {
/**
 *
 * @var type currentGameData in aceasta variabila se salveaza datele in timpul executie
 * pentru a fi usor accesibile mai multor actiuni concomitent
 */
    public $currentGameData    = array();
    
    function __construct() {
        parent::__construct();
        $this->load->model('games_model');
        $this->load->model('users_model');
    }
    /**
     *  de la index te redirectioneaza pe pagina principala
     */
     public function index() {
        redirect(base_url());
    }
    
    /**
     * toti utilizatori intru masif care va afisha pe toti printru for
     * afisheaza doar dupa un id 
     */
    public function lists() {
       $data = array();
        
       $this->load->model('games_model');
       $data['games_list'] = $this->games_model->get(); //tot array-ul va fi doar pe o pagina
       $this->display_lib->users_page($data, 'pages/game_list');
    }
    

    /**
     * informatia primita din formulat de la prima postare de date..
     * si se preia id-ul noului joc, dupa ce se face readresarea spre
     * vizualizarea jocului nou creat       games/show/<game-id>
     * care la finele functiei se apeleaza un sufix
     */
    public function newGame() {
     // 
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
                    $this->load->library('bowllingGame_lib','','bowllingGame_instance');
                    // oferim acces obiectului bowllingGame_instance ( ce e instanta a 
                    // clasei bowllingGame_lib ) la modelele bazelor de date
                    $this->bowllingGame_instance->games_model   = $this->games_model;
                    $this->bowllingGame_instance->users_model   = $this->users_model;
                    // preluam id-ul nou pentru joc
                    $this->bowllingGame_instance->setGameId(true);
                    $this->currentGameData['game']          = $this->bowllingGame_instance;
//                    var_dump($userList,$data);
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
        
        $this->currentGameData['all-users'] = $this->users_model->get_allusers();
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->users_model;
        $this->bowllingGame_instance->setGameId(true);
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players']  = $userList;
        
        
        $this->display_lib->users_page(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    /**
     * informatia primita din formulat de la prima postare de date..
     * incarcam modlele tablelelor games si users
     * extragem statutul jocului din obiectul bowllingGame_instance
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
        
        // informatia primita din formulat de la prima postare de date..
        $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
        // incarcam modlele tablelelor games si users
        $this->load->model('games_model');
        $this->load->model('users_model');
        // rin in plus // a fost commentat
        // $this->currentGameData['main_info'] = $this->games_model->get();
        $this->currentGameData['all-users'] = $this->users_model->get_allusers();
        // incarcam clasa bowwlingGame_lib in $this->bollingGame_instance
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        // oferim acces obiectului bowllingGame_instance ( ce e instanta a 
        // clasei bowllingGame_lib ) la modelele bazelor de date
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->users_model;
        // indicam in obiectul bowllingGame_instance id jocului current
        $this->bowllingGame_instance->setGameId($game_id);
        // accesam obiectul bowllingGame_instance la o variabila ce va fi trimisa spre view
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        // extragem din obiectul bowllingGame_instance datele jocului current
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        // extragem statutul jocului din obiectul bowllingGame_instance
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players']  = $userList;
        
        if( $return_back && empty($this->currentGameData['game-data']) ) {
            redirect('games/newgame');
        }
        
        // incarcam datele in baza de date si preluam din nou
        // statutul di valorile jocului ce au putut sa se schimbe in caz
        // ca datele incarcate au fost acceptate.
        if(isset($data['value']) && isset($data['player']))
            if($this->currentGameData['game']->pushData($data['value'],$data['player'],$userList) === true) {
                    $this->currentGameData['game-data']     = $this->currentGameData['game']->getData();
                    $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
            }
//        $this->currentGameData['ajax-request']  = !empty($request_partial);
        // apelam view-ul si ii oferim datele necesare pentru afisare
        if(empty($request_partial)) {
            $this->display_lib->users_page(array(
                'currentGameData'   => $this->currentGameData
            ), 'pages/game');
        } else {
            $this->display_lib->users_page(array(
                'currentGameData'   => $this->currentGameData
            ), 'pages/game-json', true);
        }
    }
    /**
     * actiunea data are ca scop restructurarea datelor pentru a fi mai
     * usor de afisat
     *   datele se structureaza in modul urmator
     *   users is array_of [
     *    user_id : [
     *        user_data   : [
     *            user_id : <int>,
     *            nick    : <string>,
     *            name    : <string>,
     *            surname : <string>
     *        ]
     *        rounds      : [             lista roundurilor
     *            nr_roud : array_of [
     *                { try_n : <int>, value: <int>, user_id : <int>, game_id: <int> }
     *                ...
     *            ]
     *        ]
     *        total       : <int>         punctele acumulate de utilizator
     */
    public function actionSuffix(&$dataPosted) {
        if( isset($dataPosted['currentGameData']['game-data'])
                &&
            is_array($dataPosted['currentGameData']['game-data'])
          ) {
            $d  = array(
                    'users' => array()
                );
            foreach ( $dataPosted['currentGameData']['game-data'] as $row ) {
                if(!isset($d['users'][$row['user_id']]))
                    $d['users'][$row['user_id']]    = array(
                            'user_data' => $dataPosted['currentGameData']['all-users'][$row['user_id']],
                            'rounds'    => array(),
                            'total'     => 0
                        );
                if(!isset($d['users'][$row['user_id']]['rounds'][$row['round']]))
                    $d['users'][$row['user_id']]['rounds'][$row['round']]   = array();

                $d['users'][$row['user_id']]['rounds'][$row['round']][] = $row;
                $d['users'][$row['user_id']]['total']   += $row['value'];
            }
            $dataPosted['currentGameData']['game-data-grouped'] = $d;
        }
    }




}
?>
