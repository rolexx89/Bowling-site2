<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BowllingGame_lib {
    /*
            DB  table structure
            Table [BowllingGame]
            game_id     round   user_id try_n   value
    */
    private $game_id        = false;
    // proprietatile publice unde pot fi accesate modelle bazelor de date
    public  $games_model    = false;
    public  $users_model    = false;
    private $tableName      = 'bowlling-game';

    function __construct() {
    }

    public  function setGameId($game_id) {
        if($game_id === true) {
            // daca introducem in functie true
            // atunci ea va returna un id nou si neutilizat
            $this->game_id  = $this->games_model->getNewGameId();
        } else {
            $this->game_id  = $game_id;
        }
    }
    public  function getGameId() {
        // returneaza id-ul jocului curent
        return $this->game_id;
    }
    public  function getData() {
        // detectam daca id-ul jocului a fost specificat
        if(!$this->game_id) return false;
        // selectam datele jocului curent
        $data   = $this->games_model->getData($this->game_id);
        return $data;
    }
    // daca ->pushData() -> returnneaza daca e terminat jocul
    public  function pushData($val = false,$player = false) {
        // get data about game score
        $data   = $this->getData();
        if(!is_array($data))
            $data   = array();
        // detect round
        $currentRound   = 1;
        if(count($data)) {
            $currentRound   = $data[count($data)-1]['round'];
        }

        // daca tot utilizatorii au completat roundul curent
        // si $player deja exista atunci
        // if($currentRound < 10) $currentRound += 1;

        // check if current round is completed
        $completed_check    = function($data,$currentRound,&$players) {
            $players_all    = array();
            // selectam lista utilizatorilor ce participa in joc
            foreach ($data as $row) {
                $players_all[$row['user_id']]   = true;
                }
            $players    = array();
            $roundHaveData  = false;
            // grupam datele utilizatorilor din round-ul current a jocului
            // $currentRound
            // pentru asta facem grupare partial egala cu gruparea din
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
            // check if playes completed the round
            // pentru aceasta verificam fiece utilizator daca
                // a aruncat de 3 ori
                // sau
                // a aruncat un suma de >=10
                // sau
                // a aruncat strech
            // daca makar un user nu a inteplinit conditia
            // round-ul nu e complet
                // $completed = false;
            $completed  = true;
            foreach ($players as $user_id => $score )
                if(
                    ( ( $score['try'] < 2 && $currentRound < 10 ) || ( $score['try'] < 3 && $currentRound == 10 ) )
                        &&
                    ( $score['sum'] < 10 )
                ) {

                    $completed  = false;
                }
            return $completed && $roundHaveData && count($players) == count($players_all);
        };
            // check if round completed
            // exista probabilitatea ca round-ul sa fie completat numai ce
            // deci e completat dar un alt round nu a inceput
            $players_array  = array();
            $round_justCompleted    = false;
            if($completed_check($data,$currentRound,$players_array)) {
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
            // daca roundul a fost completat numai ce
            // si deabia incepe round-ul 2 ( nu sau facut inca aruncari in round-ul 2 )
            // sau inca e round-ul 1
            // atunci e posibil ca sa intre in joc noi jucatori
            $allowed_newUser    = (
                $currentRound == 1
                ||
                (
                    $currentRound == 2
                    &&
                    $round_justCompleted
                )
            );
            // daca in metoda currenta $this->pushData()
            // nu se trimit nici o valoare si nici un id al utilizatorului
            // atunci ele se seteaza ca false.. si aceasta e o modalitate
            // de a prelua doar statutul jocului fara a inserta date
            if($val === false && $player === false) {
                    return array(
                        'status'    => 'not-completed',
                        'round'     => $currentRound,
                        'players'   => $players_array,
                        'allowed-new'   => $allowed_newUser
                    );
            }

            // val <= 12
            if($val > 10)
                    return false;
            // check if user was specified
            if(empty($player))
                    return false;
            // controlam daca utilizatorul exista
            if(!$this->users_model->checkUserById($player))
                    return false;

            // functia data anonima returneaza cite array-uri din array-ul dat
            // poseda valoarea de sub keia $key egala cu valoarea $value
            $check_f    = function($data,$key,$value) {
                $match_n    = 0;
                foreach($data as $row)
                    if( $row[$key]  == $value ) {
                        $match_n++;
                    }
                return $match_n;
            };
            // detect if player already used
            if($check_f($data,'user_id',$player) == 0) {
                // allow new player if round 1
                if($allowed_newUser && $currentRound == 2) {
                    $currentRound = 1;
                }
                if($currentRound > 1)
                    // player can't be pushed because round already more than 1
                    return false;
            }
            // functia data returneaza pentru fiece utilizator cite incercari
            // si ce valoare a acumulat in round-ul $currentRound
            $data_check = function($data,$player, $currentRound){
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
            };
            // check if the user can push data in current round
            $data_player    = $data_check($data,$player,$currentRound);
            $sum        = $data_player['sum'];
            $count_try  = $data_player['try'];

            // daca a fost doar o incercare si valoarea e 10 atuncti setam ca strech
            // si transformam valoarea in 12
            if($count_try == 0 && $val == 10)
                $val = 12;
            // insertam valoarea $val oferita de playerul $player
            // daca satisface urmatoarele conditii
            if( ( ( $sum == 0 && $val <= 12 ) || ( $sum > 0 && $sum + $val <= 10 ) )
                    &&
                    (
                        ( $currentRound < 10 && $count_try < 2 )
                            ||
                        ( $currentRound == 10 && $count_try < 3 )
                    )
                ) {
                        $this->games_model->putData(
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