<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BowllingGame {
/**
 * Table [BowllingGame]
 * game_id     round   user_id try_n   value 
 */
    private $game_id       = false;
    public  $gamesModel    = false;
    public  $usersModel    = false;
   
    function __construct() {
    }
/**
 * 
 * @param type $game_id daca contitia se true atunci se creiaza un nou joc
 * daca este fals atunci exita jocul si ne va afisha jocul dupa $game_id
 * @abs e pus daca utilizatorul in url scrie nu int dar '24r' 
 * atunci fortsam sa fie int si sa afisheze id cu joc 24
 */
    public  function setGameId($game_id) {
        if($game_id === true) {
            $this->game_id  = $this->gamesModel->getNewGameId();
        } else {
            $this->game_id  = @abs($game_id);
        }
    }
    /**
     * @return id jocului curent
     */
    public  function getGameId() {
        return $this->game_id;
    }
    /**
     * 
     * @return boolean el verifica daca id jocului a fost specificat 
     * atunci ea datele din bd.
     */
    public  function getData() {
        
        if(!$this->game_id) return false;
        $data   = $this->gamesModel->getData($this->game_id);
        return $data;
    }
    /**
     * 
     * @param array $data datele users
     * @param type $currentRound grupam datele utilizatorilor 
     * din round-ul current cu controler game si sufex uniune
     * @param array $players selectam lista utilizatorilor ce participa in joc
     * @param  $usersInGame date cu utilizatori si game
     * @return type check if current round is completed
     */
   function completedCheck($data,$currentRound,&$players,$usersInGame) {
            $players_all    = array();
            foreach ($data as $row) {
                $players_all[$row['user_id']]   = true;
                }
            foreach($usersInGame as $i)
                $players_all[$i]    = true;
            $players    = array();
            $roundHaveData  = false;
            
            // pentru asta facem grupare partial a user si games
            // controlerul games / actiunea actionSufix
            foreach ($data as $row)
                if( $row['round'] == $currentRound ) {
                    $roundHaveData  = true;
                    if(!isset($players[$row['user_id']]))
                        $players[$row['user_id']]   = array(
                                'sum'   => 0,
                                'try'   => 0
                            );
                    $players[$row['user_id']]['sum']    += $row['value'];
                    $players[$row['user_id']]['try']    += 1;
                }
            // check if playes completed the round try =3 || sum>=10 ||strech
            // daca user nu a inteplinit conditia round-ul nu e complet
            // $completed = false;
            $completed  = true;
            foreach ($players as $user_id => $score )
                if(
                    ( ( $score['try'] < 2 && $currentRound < 10 ) || ( $score['try'] < 3 && $currentRound == 10 ) )
                        &&
                    ( ( $score['sum'] < 10 && $currentRound < 10 ) || ( $score['sum'] < 24 && $currentRound == 10 ) )
                       
                ) {

                    $completed  = false;
                }
            return $completed && $roundHaveData && count($players) == count($players_all);
        }
 
        /*
         * poseda valoarea de sub keia $key egala cu valoarea $value
         * fiecare user a aruncat valor
         * detect if player already used
         */
        public function checkF($data,$key,$value) {
                $match_n    = 0;
                foreach($data as $row)
                    if( $row[$key]  == $value ) {
                        $match_n++;
                    }
                return $match_n;
            }
            
              /**
               *  ce valoare a acumulat in round-ul $currentRound
               *  check if the user can push data in current round
               */        

        public function dataCheck($data,$player, $currentRound){
                $r  = array(
                    'sum'   => 0,
                    'try'   => 0
                );
                foreach ($data as $row)
                    if($row['round'] == $currentRound && $row['user_id'] == $player) {
                        $r['sum']   += $row['value'];
                        $r['try']   += 1;
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
    public  function pushData($val = false,$player = false, $usersInGame = false) {

        $data   = $this->getData();
        if(!is_array($usersInGame))
            $usersInGame    = array();
        if(!is_array($data))
            $data   = array();
        // detect round
        $currentRound   = 1;
        if(count($data)) {
            $currentRound   = $data[count($data)-1]['round'];
        }

        // daca tot utilizatorii au completat roundul curent
        // si $player deja exista atunci se trece la round urmator
 
            $players_array  = array();
            $round_justCompleted    = false;
            if($this->completedCheck($data,$currentRound,$players_array,$usersInGame)) {
                if($currentRound < 10) {
                    $currentRound += 1;
                    $round_justCompleted    = true;
                } else {
                    return array(
                            'status'    => 'completed',
                            'players'   => $players_array,
                            'allowed-new'   => false
                        );
                }
            }
            //posibilitatea de adauga nou user
            $allowed_newUser    = (
                $currentRound == 1
                ||
                (
                    $currentRound == 2
                    &&
                    $round_justCompleted
                )
            );

            // de a prelua doar statutul jocului fara a inserta date
            if($val === false && $player === false) {
                    return array(
                        'status'    => 'not-completed',
                        'round'     => $currentRound,
                        'players'   => $players_array,
                        'allowed-new'   => $allowed_newUser
                    );
            }
            // check round and value  
            
            if( ( $val > 10 && $currentRound < 10 ) || ( $currentRound == 10 && $val > 24 ) )
                    return false;
            // check if user was specified
            if(empty($player))
                    return false;
            // check if user exist
            if(!$this->usersModel->checkUserById($player))
                    return false;

           
            if($this->checkF($data,'user_id',$player) == 0) {
                // allow new player if round 1
                if($allowed_newUser && $currentRound == 2) {
                    $currentRound = 1;
                }
                if($currentRound > 1)
                    // player can't be pushed because round already more than 1
                    return false;
            }

            $data_player    = $this->dataCheck($data,$player,$currentRound);
            $sum        = $data_player['sum'];
            $count_try  = $data_player['try'];

            // daca a fost doar o incercare si valoarea e 10 atuncti setam ca strech
            // si transformam valoarea in 12
            
            if( ( $count_try == 0 && $val == 10 && $currentRound < 10 )
                    ||
                ( $count_try < 3 && $val == 10 && $currentRound == 10 )
                    )
                $val = 12;

            if( ( ( $sum == 0 && $val <= 12 ) || ( ( $currentRound < 10 && $sum > 0 && $sum + $val <= 10 ) || ( $currentRound == 10 && $sum+$val <= 24 && $count_try < 2 ) ||  (  $currentRound == 10 && $sum+$val <= 22 && $count_try >= 2  )   ) )
                    &&
                    (
                        ( $currentRound < 10 && $count_try < 2 )
                            ||
                        ( $currentRound == 10 && $count_try < 3 )
                    )
                ) {
                        $this->gamesModel->putData(
                            array(
                                'game_id'   => abs($this->game_id),
                                'round'     => abs($currentRound),
                                'user_id'   => abs($player),
                                'try_n'     => abs($count_try+1),
                                'value'     => abs($val)
                            )
                        );
                        return true;
                    }
    }

}

?>