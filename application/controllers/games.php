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
    

    // in aceasta variabila se salveaza datele in timpul executie
    // pentru a fi usor accesibile mai multor actiuni concomitent
    private $currentGameData    = array();
    
    public function newgame() {
        // informatia primita din formulat de la prima postare de date..
        $data   = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
        // daca informatia a fost postata se efectueaza adaugarea in bazei de date
        // si se preia id-ul noului joc, dupa ce se face readresarea spre
        // vizualizarea jocului nou creat       games/show/<game-id>
        if( isset($data['value']) && isset($data['player']) ) {
                // incarcam clasa bowwlingGame_lib in $this->bollingGame_instance
                $this->load->library('bowllingGame_lib','','bowllingGame_instance');
                // oferim acces obiectului bowllingGame_instance ( ce e instanta a 
                // clasei bowllingGame_lib ) la modelele bazelor de date
                $this->bowllingGame_instance->games_model   = $this->games_model;
                $this->bowllingGame_instance->users_model   = $this->all_users;
                // preluam id-ul nou pentru joc
                $this->bowllingGame_instance->setGameId(true);
                $this->currentGameData['game']          = $this->bowllingGame_instance;
                // daca au fost oferite valori noi prin postare, atunci
                // incarcam datele in baza de date
                if($this->currentGameData['game']->pushData($data['value'],$data['player']) === true) {
                        // facem redirect spre vizualizarea jocului nou creat
                        redirect('games/show/'.abs($this->currentGameData['game']->getGameId()));
                }
        }

        $this->currentGameData['all-users'] = $this->all_users->get_allusers();
        // incarcam clasa bowwlingGame_lib in $this->bollingGame_instance
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        // oferim acces obiectului bowllingGame_instance ( ce e instanta a 
        // clasei bowllingGame_lib ) la modelele bazelor de date
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->all_users;
        $this->bowllingGame_instance->setGameId(true);
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        
        $this->actionSuffix();
        
        $this->display_lib->users_page(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    /**
     * 
     */
    
    public function show($game_id) {
        // informatia primita din formulat de la prima postare de date..
        $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
        // incarcam modlele tablelelor games si users
        $this->load->model('games_model');
        $this->load->model('all_users');
        // rin in plus // a fost commentat
        // $this->currentGameData['main_info'] = $this->games_model->get();
        $this->currentGameData['all-users'] = $this->all_users->get_allusers();
        // incarcam clasa bowwlingGame_lib in $this->bollingGame_instance
        $this->load->library('bowllingGame_lib','','bowllingGame_instance');
        // oferim acces obiectului bowllingGame_instance ( ce e instanta a 
        // clasei bowllingGame_lib ) la modelele bazelor de date
        $this->bowllingGame_instance->games_model   = $this->games_model;
        $this->bowllingGame_instance->users_model   = $this->all_users;
        // indicam in obiectul bowllingGame_instance id jocului current
        $this->bowllingGame_instance->setGameId($game_id);
        // accesam obiectul bowllingGame_instance la o variabila ce va fi trimisa spre view
        $this->currentGameData['game']          = $this->bowllingGame_instance;
        // extragem din obiectul bowllingGame_instance datele jocului current
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        // extragem statutul jocului din obiectul bowllingGame_instance
        $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
        
        // daca au fost oferite valori noi prin postare, atunci
        // e posibil ca statutul jocului sa se schimbe.
        // deci, incarcam datele in baza de date si preluam din nou
        // statutul di valorile jocului ce au putut sa se schimbe in caz
        // ca datele incarcate au fost acceptate.
        if(isset($data['value']) && isset($data['player']))
            if($this->currentGameData['game']->pushData($data['value'],$data['player']) === true) {
                    $this->currentGameData['game-data']     = $this->currentGameData['game']->getData();
                    $this->currentGameData['game-status']   = $this->currentGameData['game']->pushData();
            }
        // apelam o procedura interna .. vezi lamurirea la aceasta procedura
        $this->actionSuffix();
        // apelam view-ul si ii oferim datele necesare pentru afisare
        $this->display_lib->users_page(array(
            'currentGameData'   => $this->currentGameData
        ), 'pages/game');
    }
    
    private function actionSuffix() {
        // actiunea data are ca scop restructurarea datelor pentru a fi mai
        // usor de afisat
        // datele se structureaza in modul urmator
        // users is array_of [
        //  user_id : [
        //      user_data   : [
        //          user_id : <int>,
        //          nick    : <string>,
        //          name    : <string>,
        //          surname : <string>
        //      ]
        //      rounds      : [             lista roundurilor
        //          nr_roud : array_of [
        //              { try_n : <int>, value: <int>, user_id : <int>, game_id: <int> }
        //              ...
        //          ]
        //      ]
        //      total       : <int>         punctele acumulate de utilizator
        //  ]
        // ]
        if( isset($this->currentGameData['game-data'])
                &&
            is_array($this->currentGameData['game-data'])
          ) {
        $d  = array(
                'users' => array()
            );
        foreach ( $this->currentGameData['game-data'] as $row ) {
            if(!isset($d['users'][$row['user_id']]))
                $d['users'][$row['user_id']]    = array(
                        'user_data' => $this->currentGameData['all-users'][$row['user_id']],
                        'rounds'    => array(),
                        'total'     => 0
                    );
            if(!isset($d['users'][$row['user_id']]['rounds'][$row['round']]))
                $d['users'][$row['user_id']]['rounds'][$row['round']]   = array();

            $d['users'][$row['user_id']]['rounds'][$row['round']][] = $row;
            $d['users'][$row['user_id']]['total']   += $row['value'];
        }
        $this->currentGameData['game-data-grouped'] = $d;
    }
    }




}
?>
