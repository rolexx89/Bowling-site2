<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gamesModel extends CI_Model {

    public $table = 'bowling-game'; //Numele tabelului
    public $idkey = 'game_id'; //id index al fecarui utilizator
        
    public function gamesModel() {
        parent::__construct();
    }
    /**
     * 
     * @param type $obj_id returneaza rezultatul al un array al unei inregistrari
     * @return type el va vrea aceste date dupa game_id 
     */
    public function get($offset = 0,$limit = 0) {
        $this->db->group_by('game_id');
        if( $offset || $limit ) {
            if($limit) {
                $this->db->limit($limit,$offset);
            } else {
                $this->db->limit($offset);
            }
        };
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    public function count() {
        $this->db->select(' 1 ',false);
        $this->db->group_by('game_id');
        $query  = $this->db->get($this->table);
        return $query->num_rows();
    }
    /**
     * 
     * @return type un tip interger cu abs (fara numere negative)
     */
    public function getNewGameId() {
       
        $this->db->select_max('game_id');
        $query  = $this->db->get($this->table);
        $data   = $query->result_array();
        
        return $data[0]['game_id']+1;
    }
    /**
     * 
     * @param type $data inscrie in baza de date datele games
     */
    public function putData($data) {
        $this->db->insert($this->table,$data);
    }
    /**
     * 
     * @param type $game_id se ea datele dupa fiecare id din games
     * @return type returneaza un array cu toate datele jocului
     */
    public function getData($game_id) {
        $this->db->where('game_id', $game_id);
        $this->db->order_by('`round` ASC,`user_id` ASC,`try_n` ASC');
        $query  = $this->db->get($this->table);
        return $query->result_array();
    }
    
}


?>