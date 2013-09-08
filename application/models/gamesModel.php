<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gamesModel extends CI_Model {
/**
 * @var $table Numele tabelului
 * @var $idkey id jocului
 */
    public $table = 'bowling-game'; 
    public $idkey = 'game_id'; 
        
    public function gamesModel() {
        parent::__construct();
    }
  /**
     * @param array $offset toate datele inregistrate
     * @param int $limit afiseaza toate listele jocurilor ,limita de 5
     * @return type array
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
    /**
     * slect('1',false) in celulele cu datele selectate se va inlocui cu 1 
     * pentru nu a incarca datele  
     * @return int caluculeaza chite jocuri sunt
     */
    public function count() {
        $this->db->select(' 1 ',false);
        $this->db->group_by('game_id');
        $query  = $this->db->get($this->table);
        return $query->num_rows();
    }
    /**
     * la selectarea utilizatorilor se creaza un joc nou
     * @return int  $data[0]['game_id'] id_jocului nou
     */
    public function getNewGameId() {
       
        $this->db->select_max('game_id');
        $query  = $this->db->get($this->table);
        $data   = $query->result_array();
        
        return $data[0]['game_id']+1;
    }
    /**
     * 
     * @param numeric $data inscrie in bd valorile
     */
    public function putData($data) {
        $this->db->insert($this->table,$data);
    }
    /**
     * 
     * @param numeric $game_id se ea datele dupa fiecare id
     * @return array  datele jocului
     */
    public function getData($game_id) {
        $this->db->where('game_id', $game_id);
        $this->db->order_by('`round` ASC,`user_id` ASC,`try_n` ASC');
        $query  = $this->db->get($this->table);
        return $query->result_array();
    }
    
}


?>