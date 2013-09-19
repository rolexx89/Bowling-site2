<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BowllingGame {

    /**
     * Table [BowllingGame]
     * game_id     round   user_id try_n   value 
     */
    private $game_id = false;
    public $gamesModel = false;
    public $usersModel = false;

    public function setGameId($game_id) {
        if ($game_id === true) {
            $this->game_id = $this->gamesModel->getNewGameId();
        } else {
            $this->game_id = @abs($game_id);
        }
    }

    /**
     * @return id current game
     */
    public function getGameId() {
        return $this->game_id;
    }

    /**
     * 
     * @return boolean he check game id was specified then it dates from bd
     */
    public function getData() {

        if (!$this->game_id)
            return false;
        $data = $this->gamesModel->getData($this->game_id);
        return $data;
    }

    /**
     * 
     * @param array $data data user
     * @param type $currentRound grup date users 
     * @param array $players selec list users in game
     * @param  $usersInGame data users in game
     * @return type check if current round is completed
     */
    function completedCheck($data, $currentRound, &$players, $usersInGame) {
        $players_all = array();
        foreach ($data as $row)
            $players_all[$row['user_id']] = true;

        foreach ($usersInGame as $i)
            $players_all[$i] = true;
        
        $players = array();
        $roundHaveData = false;

        // controlerul games / actions actionSufix
        foreach ($data as $row)
            if ($row['round'] == $currentRound) {
                $roundHaveData = true;
                if (!isset($players[$row['user_id']]))
                    $players[$row['user_id']] = array(
                        'sum' => 0,
                        'try' => 0
                    );
                $players[$row['user_id']]['sum'] += $row['value'];
                $players[$row['user_id']]['try'] += 1;
            }
        // check if playes completed the round try =3 || sum>=10 ||strech
        // $completed = false;
        $completed = true;
        foreach ($players as $user_id => $score)
            if (
                    ( ( $score['try'] < 2 && $currentRound < 10 ) || ( $score['try'] < 3 && $currentRound == 10 ) ) &&
                    ( ( $score['sum'] < 10 && $currentRound < 10 ) || ( $score['sum'] < 24 && $currentRound == 10 ) )
            ) {

                $completed = false;
            }
        return $completed && $roundHaveData && count($players) == count($players_all);
    }

    /*
     * detect if player already used
     */

    public function checkF($data, $key, $value) {
        $match_n = 0;
        foreach ($data as $row)
            if ($row[$key] == $value) {
                $match_n++;
            }
        return $match_n;
    }

    /**
     *  check if the user can push data in current round
     */
    public function dataCheck($data, $player, $currentRound) {
        $r = array(
            'sum' => 0,
            'try' => 0
        );
        foreach ($data as $row)
            if ($row['round'] == $currentRound && $row['user_id'] == $player) {
                $r['sum'] += $row['value'];
                $r['try'] += 1;
            }
        return $r;
    }

    /**
     * 
     * @param int $val
     * @param boolean $player
     * @param array $usersInGame get data about game score
     * @return boolean
     */
    public function pushData($val = false, $player = false, $usersInGame = false) {

        $data = $this->getData();
        if (!is_array($usersInGame))
            $usersInGame = array();
        if (!is_array($data))
            $data = array();
        // detect round
        $currentRound = 1;
        if (count($data))
            $currentRound = $data[count($data) - 1]['round'];

        $players_array = array();
        $round_justCompleted = false;
        if ($this->completedCheck($data, $currentRound, $players_array, $usersInGame))
            if ($currentRound < 10) {
                $currentRound += 1;
                $round_justCompleted = true;
            } else {
                return array(
                    'status' => 'completed',
                    'players' => $players_array,
                    'allowed-new' => false
                );
            }
        // add new user
        $allowed_newUser = ($currentRound == 1 || ( $currentRound == 2 && $round_justCompleted));

        // to take only the status of the game without the insert data
        if ($val === false && $player === false) {
            return array(
                'status' => 'not-completed',
                'round' => $currentRound,
                'players' => $players_array,
                'allowed-new' => $allowed_newUser
            );
        }
        // check round and value  
        if( (( $val > 10 && $currentRound < 10 ) || ( $currentRound == 10 && $val > 24 ))
            || empty($player) // check if user was specified
            || !$this->usersModel->checkUserById($player)) // check if user exist
            return false;

        if ($this->checkF($data, 'user_id', $player) == 0) {
            // allow new player if round 1
            if ($allowed_newUser && $currentRound == 2)
                $currentRound = 1;
            // player can't be pushed because round already more than 1
            if ($currentRound > 1)
                return false;
        }

        $data_player = $this->dataCheck($data, $player, $currentRound);
        $sum = $data_player['sum'];
        $count_try = $data_player['try'];

        if (( $count_try == 0 && $val == 10 && $currentRound < 10 ) ||
                ( $count_try < 3 && $val == 10 && $currentRound == 10 )
        )   $val = 12;

        if (( ( $sum == 0 && $val <= 12 ) || ( ( $currentRound < 10 && $sum > 0 && $sum + $val <= 10 ) || ( $currentRound == 10 && $sum + $val <= 24 && $count_try < 2 ) || ( $currentRound == 10 && $sum + $val <= 22 && $count_try >= 2 ) ) ) &&
                (( $currentRound < 10 && $count_try < 2 ) || ( $currentRound == 10 && $count_try < 3 ))) {
            $this->gamesModel->putData( array(
                        'game_id' => abs($this->game_id),
                        'round' => abs($currentRound),
                        'user_id' => abs($player),
                        'try_n' => abs($count_try + 1),
                        'value' => abs($val)
                    ));
            $users_data = array();
            // we have users ids in UsersInGame
            // and we need users Data in gameInfo Table
            // so we build an array ( user_id => user_data, .. );
            if (!empty($usersInGame))
                foreach ($usersInGame as $user_id)
                    $users_data[$user_id] = $this->usersModel->get($user_id);
            // we get the updated status
            $status = $this->pushData();
            // insert status and users_arr in gameInfo MySQL Table
            $this->gamesModel->updGameInfo($this->game_id, array(
                'round' => ( $status['status'] == "completed" ? 100 : $currentRound ),
                'users' => $users_data
            ));
            return true;
        }
    }

}

?>