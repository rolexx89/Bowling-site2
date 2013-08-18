<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games_model extends CI_Model {

    public $table = 'bowling-game'; //Numele tabelului
    public $idkey = 'game_id'; //id index al fecarui utilizator
        
    public function Games_model() {
        parent::__construct();
    }
    /**
     * 
     * @param type $obj_id returneaza rezultatul al un array al unei inregistrari
     * @return type el va vrea aceste date dupa game_id 
     */
    public function get() {
     // $this->db->where($this->idkey, $obj_id);
        $this->db->group_by('game_id');
        $query = $this->db->get($this->table);       
        return $query->result_array();
    }
    
    public function getNewGameId() {
//        $row	= mysql_fetch_row(mysql_query("select
//            max(`game_id`)+1 from `{$this->tableName}` where 1 "));
//        $this->game_id	= max(1,$row[0]);
        $this->db->order_by('game_id','DESC');
        $this->db->limit(1);
        $query  = $this->db->get($this->table);
        $data   = $query->result_array();
        
        return max(
                    1,
                    @abs(
                        @$data[0]['game_id']
                    )+1
                );
    }
    
    public function putData($data) {
        $this->db->insert($this->table,$data);
    }
    
    public function getData($game_id) {
        $this->db->where('game_id', $game_id);
        $this->db->order_by('`round` ASC,`user_id` ASC,`try_n` ASC');
        $query  = $this->db->get($this->table);
        return $query->result_array();
    }
    
}


?>