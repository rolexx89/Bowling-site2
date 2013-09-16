<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gamesModel extends CI_Model {

    /**
     * @var $table Numele tabel
     * @var $idkey id game
     */
    public $table = 'bowling-game';
    public $tableInfo = 'bowling-game-info';
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
            $this->db->insert($this->tableInfo, $data);
        }
    }

    /**
     * 
     * @param array $filter
     * @return array
     */
    public function selectInfoArr($filter) {
        $this->db->select(array("game_id", "name", "users", "ctime", "mtime", "round"));
//        $this->db->where($filter);
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
        if (isset($filter["users"]))
            $this->db->like('users', $filter['users'], 'both');
        $this->db->limit(10);
        $query = $this->db->get($this->tableInfo);
        return $query->result_array();
    }

}

?>