<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games extends CI_Controller {

    public $currentGameData = array();

    function __construct() {
        parent::__construct();
        $this->load->model('gamesModel');
        $this->load->model('usersModel');
    }

    /**
     * @var array $data
     * @var array $start_list  all users in array to display ID 
     * @var int $limit - per_page
     * 
     */
    public function lists($start_list = 0) {
        $data = array();
        $this->load->model('gamesModel');

        $config['base_url'] = base_url() . '/games/lists/';
        $config['total_rows'] = $this->gamesModel->count();
        $config['per_page'] = 5;

        $data['games_list'] = $this->gamesModel->get($start_list, $config['per_page']);

        $this->pagination->initialize($config);

        $data['page_links'] = $this->pagination->create_links();
        
        $viewPage   = 'pages/game_list';
        $types_view = array(
            'quick-search'  => 'pages/game_search',
            'simple-search' => 'pages/game_search_simple'
        );
        if( isset($types_view[$start_list]) )
            $viewPage   = $types_view[$start_list];
        
        $this->display_lib->usersPage($data, $viewPage );
    }

    /**
     * id take the new game,Referrals to be made after view
     *  newly created game    games/show/<game-id>
     */
    public function newGame($mode = false) {

        $reset_back = false;
        $allow_data = true;
        $loading_list = false;
        $userList = array();
        $request_partial = false;
        if ($mode == 'select') {
            $this->session->userdata['gameUserList_tmp'] = array();
            $this->session->sess_write();
        } else {
            $request_partial = !empty($mode);
        }
        if (isset($_POST['game_data']['game-name'])) {
            $this->session->userdata['gameUserList_tmp_GameName'] = $_POST['game_data']['game-name'];
            $this->session->sess_write();
        }
        if (is_array(@$_POST['game_data']['player'])) {
            $loading_list = true;
            $this->session->userdata['gameUserList_tmp'] = $_POST['game_data']['player'];
            $this->session->sess_write();
        };
        if (!isset($this->session->userdata['gameUserList_tmp'])) {
            $reset_back = true;
        } else {
            $userList = $this->session->userdata['gameUserList_tmp'];
            if (empty($userList) || !is_array($userList))
                $reset_back = true;
        };
        if ($reset_back) {
            $allow_data = false;
        }

        if ($allow_data && !$loading_list) {
            $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );
            if (isset($data['value']) && isset($data['player'])) {
                $this->load->library('BowllingGame', '', 'bowllingGame_instance');

                $this->bowllingGame_instance->gamesModel = $this->gamesModel;
                $this->bowllingGame_instance->usersModel = $this->usersModel;

                $this->bowllingGame_instance->setGameId(true);
                $this->currentGameData['game'] = $this->bowllingGame_instance;

                if ($this->currentGameData['game']->pushData($data['value'], $data['player'], $userList) === true) {
                    $i = $this->currentGameData['game']->getGameId();
                    $this->session->userdata['gameUserList_' . $i] = $userList;
                    if (!empty($this->session->userdata['gameUserList_tmp_GameName']))
                        $this->gamesModel->updGameInfo($i, array(
                            'name' => $this->session->userdata['gameUserList_tmp_GameName']
                        ));
                    $this->session->userdata['gameUserList_tmp'] = array();
                    $this->session->userdata['gameUserList_tmp_GameName'] = "";
                    $this->session->sess_write();
                    redirect('games/show/' . abs($i) . "/1");
                }
            }
        }

        $this->currentGameData['all-users'] = $this->usersModel->GetAllUsers();
        $this->load->library('BowllingGame', '', 'bowllingGame_instance');
        $this->bowllingGame_instance->gamesModel = $this->gamesModel;
        $this->bowllingGame_instance->usersModel = $this->usersModel;
        $this->bowllingGame_instance->setGameId(true);
        $this->currentGameData['game'] = $this->bowllingGame_instance;
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
        $this->currentGameData['game-status'] = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players'] = $userList;

        if (empty($request_partial)) {
            $this->display_lib->usersPage(array(
                'currentGameData' => $this->currentGameData
                    ), 'pages/game');
        } else {
            $this->display_lib->usersPage(array(
                'currentGameData' => $this->currentGameData
                    ), 'pages/game-json', true);
        }
    }

    /**
     * games tables and users upload models
     * extract the game status from the object instance Bowling Game
     * @param array $userList 
     */
    public function show($game_id, $request_partial = 0) {

        $return_back = false;
        $userList = array();
        if (!isset($this->session->userdata['gameUserList_' . $game_id])) {
            $return_back = true;
        } else {
            $userList = $this->session->userdata['gameUserList_' . $game_id];
            if (empty($userList) || !is_array($userList))
                $return_back = true;
        };

        $data = ( isset($_POST['game_data']) ? $_POST['game_data'] : array() );

        $this->load->model('gamesModel');
        $this->load->model('usersModel');

        $this->currentGameData['all-users'] = $this->usersModel->GetAllUsers();

        $this->load->library('BowllingGame', '', 'bowllingGame_instance');

        $this->bowllingGame_instance->gamesModel = $this->gamesModel;
        $this->bowllingGame_instance->usersModel = $this->usersModel;

        $this->bowllingGame_instance->setGameId($game_id);

        $this->currentGameData['game'] = $this->bowllingGame_instance;
        $this->currentGameData['gameInfo'] = $this->gamesModel->selectInfoArr(array('game_id' => $game_id));
        if (count($this->currentGameData['gameInfo'])) {
            $this->currentGameData['gameInfo'] = $this->currentGameData['gameInfo'][0];
        } else {
            $this->currentGameData['gameInfo'] = array(
                'game_id' => $game_id,
                'users' => '',
                'name' => '...',
                'round' => '',
                'ctime' => '',
                'mtime' => ''
            );
        }
        $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();

        $this->currentGameData['game-status'] = $this->currentGameData['game']->pushData();
        $this->currentGameData['game-players'] = $userList;

        //controlam daca nu exita id cu asa joaca ne redirectioneaza la joc nou
        if ($return_back && empty($this->currentGameData['game-data'])) {
            redirect('games/newgame');
        }

        // try the new game status
        // and values ​​of the game to extend the game
        if (isset($data['value']) && isset($data['player']))
            if ($this->currentGameData['game']->pushData($data['value'], $data['player'], $userList) === true) {
                $this->currentGameData['game-data'] = $this->currentGameData['game']->getData();
                $this->currentGameData['game-status'] = $this->currentGameData['game']->pushData();
            }

        if (empty($request_partial)) {
            $this->display_lib->usersPage(array(
                'currentGameData' => $this->currentGameData
                    ), 'pages/game');
        } else {
            $this->display_lib->usersPage(array(
                'currentGameData' => $this->currentGameData
                    ), 'pages/game-json', true);
        }
    }

    /**
     * @param mixed $d show data live game
     */
    public function actionSuffix(&$dataPosted) {
        if (isset($dataPosted['currentGameData']['game-data']) &&
                is_array($dataPosted['currentGameData']['game-data'])
        ) {
            $d = array(
                'users' => array()
            );
            foreach ($dataPosted['currentGameData']['game-data'] as $r) {
                if (!isset($d['users'][$r['user_id']]))
                    $d['users'][$r['user_id']] = array(
                        'user_data' => $dataPosted['currentGameData']['all-users'][$r['user_id']],
                        'rounds' => array(),
                        'total' => 0
                    );
                $vTemp = &$d['users'][$r['user_id']]['rounds'];
                if (!isset($vTemp[$r['round']]))
                    $vTemp[$r['round']] = array();

                $vTemp[$r['round']][] = $r;
                $d['users'][$r['user_id']]['total'] += $r['value'];
            }
            $dataPosted['currentGameData']['countJoinedUsers'] = count($d['users']);
            if (isset($dataPosted['currentGameData']['game-players']) && is_array($dataPosted['currentGameData']['game-players']))
                foreach ($dataPosted['currentGameData']['game-players'] as $userId)
                    if (!isset($d['users'][$userId])) {
                        $d['users'][$userId] = array(
                            'user_data' => $dataPosted['currentGameData']['all-users'][$userId],
                            'rounds' => array(),
                            'total' => 0
                        );
                    }
            $dataPosted['currentGameData']['game-data-grouped'] = $d;
        } else {
            $d = array(
                'users' => array()
            );
            $dataPosted['currentGameData']['countJoinedUsers'] = 0;
            if (isset($dataPosted['currentGameData']['game-players']) && is_array($dataPosted['currentGameData']['game-players']))
                foreach ($dataPosted['currentGameData']['game-players'] as $userId) {
                    $d['users'][$userId] = array(
                        'user_data' => $dataPosted['currentGameData']['all-users'][$userId],
                        'rounds' => array(),
                        'total' => 0
                    );
                }

            $dataPosted['currentGameData']['game-data-grouped'] = $d;
        }
    }

    public function filteredData() {
        header("Content-type: text/plain; charset=utf-8", true);
        // var_dump($_POST);
        if (!isset($_POST["selectKey"]) || !isset($_POST["listFilter"]) || !isset($_POST["valCurr"])) {
            echo "false";
        } else {
            $list = $this->gamesModel->selectInfoArr(
                    $_POST["listFilter"]
            );
            $data = array();
            foreach ($list as $item)
                $data[] = $item[$_POST["selectKey"]];
            echo json_encode(
                    array(
                        "arr" => $data,
                        "list" => $list,
                        "filter" => $_POST["listFilter"],
                        "valCurr" => $_POST["valCurr"],
                        "selectKey" => $_POST["selectKey"]
                    )
            );
        }
        exit;
    }

    public function filteredDataSimple() {
        header("Content-type: text/plain; charset=utf-8", true);
        // var_dump($_POST);
        if (!isset($_POST["valCurr"])) {
            echo "false";
        } else {
            $list = $this->gamesModel->selectInfoArrBySearch(
                    $_POST["valCurr"]
            );
            $data = array();
            foreach ($list as $item)
                $data[] = $item['game-name'].', '.$item['user-name'].' '.$item['user-surname'];
            echo json_encode(
                    array(
                        "arr" => $data,
                        "list" => $list,
                        "valCurr" => $_POST["valCurr"]
                    )
            );
        }
        exit;
    }

}

?>
