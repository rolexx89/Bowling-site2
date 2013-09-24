<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gamesModel extends CI_Model {

    /**
     * @var $table Numele tabel
     * @var $idkey id game
     */
    public $table = 'bowling-game';
    public $tableInfo   = 'bowling-game-info';
    public $tableLinks  = 'game-user';
    public $idkey = 'game_id';

    public function gamesModel() {
        parent::__construct();
    }

    /**
     * @param array $offset all date inregister
     * @param int $limit show all list of game ,limit 5 id 
     * @return type array
     */
    public function get($offset = 0, $limit = 0) {
        $this->db->group_by('game_id');
        if ($offset || $limit) {
            if ($limit) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($offset);
            }
        };
        $query = $this->db->get($this->tableInfo);
        return $query->result_array();
    }

    /**
     * slect('1',false) cells with the selected data will replace 1  
     * @return int count how meny game exist
     */
    public function count() {
        $this->db->select(' 1 ', false);
        $this->db->group_by('game_id');
        $query = $this->db->get($this->tableInfo);
        return $query->num_rows();
    }

    /**
     * the selection of users is creating a new game
     * @return int  $data[0]['game_id'] id_jocului new
     */
    public function getNewGameId() {

        $this->db->select_max('game_id');
        $query = $this->db->get($this->table);
        $data = $query->result_array();

        return $data[0]['game_id'] + 1;
    }

    /**
     * 
     * @param numeric $data write in bd value
     */
    public function putData($data) {
        $this->db->insert($this->table, $data);
    }

    /**
     * 
     * @param numeric $game_id select date fot id
     * @return array  date  game
     */
    public function getData($game_id) {
        $this->db->where('game_id', $game_id);
        $this->db->order_by('`round` ASC,`user_id` ASC,`try_n` ASC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * 
     * @param number $game_id
     * @param array $data
     */
    public function updGameInfo($game_id, $data) {
        $this->db->select('game_id');
        $this->db->where('game_id', $game_id);
        $query = $this->db->get($this->tableInfo);
        if ($query->num_rows()) {
            if (isset($data['ctime']))
                unset($data['ctime']);
            if (isset($data['users']))
                unset($data['users']);
            $data['mtime'] = @date("YmdHis");
            $this->db->update($this->tableInfo, $data, array('game_id' => $game_id), 1);
        } else {
            $data['ctime'] = @date("YmdHis");
            $data['mtime'] = $data['ctime'];
            $data['game_id'] = $game_id;
            if (isset($data['users'])) {
                foreach($data['users'] as $user_id => $user_data) {
                    $this->db->insert($this->tableLinks, array(
                        'game'  => $game_id,
                        'user'  => $user_id
                    ));
                }
                $data['users'] = '';
            }
            $this->db->insert($this->tableInfo, $data);
        }
    }

    /**
     * 
     * @param mixed $filter
     * @return array
     */
    public function selectInfoArr($filter) {
        $this->db->select(array("game_id", "name", "users", "ctime", "mtime", "round"));
        if(!is_array($filter)) {
            $this->db->where('game_id',$filter);
        } else {
            if (isset($filter["game_id"]))
                $this->db->like('game_id', $filter['game_id'], 'right');
            if (isset($filter["ctime"]))
                $this->db->like('ctime', $filter['ctime'], 'right');
            if (isset($filter["mtime"]))
                $this->db->like('mtime', $filter['mtime'], 'right');
            if (isset($filter["round"]))
                $this->db->like('round', $filter['round'], 'right');
            if (isset($filter["name"]))
                $this->db->like('name', $filter['name'], 'both');
        }
        // TODO user links table
        // if (isset($filter["users"]))
        //     $this->db->like('users', $filter['users'], 'both');
        $this->db->limit(10);
        $query = $this->db->get($this->tableInfo);
        return $query->result_array();
    }
    /**
     * This function seach games by a search string
     * it searchs in users' name, users' surname and in game's name
     * 
     * @param   string $text
     * @return  array
     */
    public function selectInfoArrBySearch($text) {
        $carr   = array();
        $values = preg_split('/[\s\.\,\;\:]+/',$text);
        foreach($values as $value)
            if(!empty($value))
                $carr[] = " ( `bowling-game-info`.`name` LIKE 0x".bin2hex('%'.$value.'%')." "
                            ." OR `users`.`name` LIKE 0x".bin2hex('%'.$value.'%')." "
                            ." OR `users`.`surname` LIKE 0x".bin2hex('%'.$value.'%')." ) ";
        $q = $this->db->query("SELECT
            `bowling-game-info`.`game_id`   as `game-id`,
            `bowling-game-info`.`name`      as `game-name`,
            `users`.`name`      as `user-name`,
            `users`.`surname`      as `user-surname`
	FROM `game-user`
	left join `bowling-game-info` on ( `bowling-game-info`.`game_id` = `game-user`.`game` )
	left join `users` on ( `users`.`id` = `game-user`.`user` )
WHERE ( ".(count($carr) ? implode(' OR ',$carr) : " 1 ")." ) LIMIT 20");
        return $q->result_array();
    }
    /**
     * Deleting a user from Database structure
     * ( if we use CASCADE [ with foreign keys.. ]
     *   the user will be delete also another
     *   users that played as competitors in same games
     *  )
     * 
     * @param type $user_id
     * @return boolean
     */
    public function deleteGameFromUser($user_id) {
        $this->db->query(" delete from `bowling-game` where (
                                select 1 from `game-user`
                                    where `game-user`.`user` = '".$user_id."'
                                    AND `game-user`.`game` = `bowling-game`.`game_id`
                                LIMIT 1
                   )");
        $this->db->query(" delete from `bowling-game-info` where (
                                select 1 from `game-user`
                                    where `game-user`.`user` = '".$user_id."'
                                    AND `game-user`.`game` = `bowling-game-info`.`game_id`
                                LIMIT 1
                   )");
        $this->db->query(" delete from `game-user` where `game-user`.`user` = '".$user_id."' ");
        return true;
    }
    
    
    public function getDataGrouped($game_id) {
        $r  = array(
            'game-id'   => $game_id,
            'game-info' => array(),
            'users'     => array()
        );
        // get game info
        $k = $this->selectInfoArr($game_id);
        if(count($k))
            $r['game-info'] = $k[0];
        // get game data
        $data   = $this->getData($game_id);
        // group game_data by users_id
        foreach($data as $v) {
            // check if users is added in $r array
            if(!isset($r['users'][$v['user_id']])) {
                $r['users'][$v['user_id']]  = array(
                    'user-id'   => $v['user_id'],
                    'user-info' => array(),
                    'user-data' => array()
                );
                // get user data
                $r['users'][$v['user_id']]['user-info'] = $this->usersModel->get($v['user_id']);
            }
            $k = $v;
            unset($k['game_id']);
            unset($k['user_id']);
            $r['users'][$v['user_id']]['user-data'][]   = $k;
        }
        return $r;
    }
    
    public function insertGameFromArrayStruct($data) {
        if(!is_array($data)) return false;
        // check array structure if is valid
        // TODO ...
        
        // insert array in db Tables
        // TODO ...
        return true;
    }

}

?>