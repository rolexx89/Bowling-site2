<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gamesModel extends CI_Model {
/**
 * @var $table Numele tabelului
 * @var $idkey id jocului
 */
    public $table = 'bowling-game'; 
    public $tableInfo = 'bowling-game-info'; 
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
    
    public function updGameInfo( $game_id, $data ) {
        $this->db->select('game_id');
        $this->db->where('game_id', $game_id);
        $query  = $this->db->get($this->tableInfo);
        if($query->num_rows()) {
            if(isset($data['ctime']))   unset($data['ctime']);
            if(isset($data['users']))   unset($data['users']);
            $data['mtime']  = @date("YmdHis");
            $this->db->update($this->tableInfo, $data, array( 'game_id' => $game_id ), 1);
        } else {
            $data['ctime']  = @date("YmdHis");
            $data['mtime']  = $data['ctime'];
            $data['game_id']= $game_id;
            $this->db->insert($this->tableInfo, $data );
        }
    }
    
    public function selectInfoArr($filter) {
        $this->db->select(array("game_id","name","users","ctime","mtime","round"));
//        $this->db->where($filter);
        if(isset($filter["game_id"]))  $this->db->like('game_id',$filter['game_id'],'right');
        if(isset($filter["ctime"])) $this->db->like('ctime',$filter['ctime'],'right');
        if(isset($filter["mtime"])) $this->db->like('mtime',$filter['mtime'],'right');
        if(isset($filter["round"])) $this->db->like('round',$filter['round'],'right');
        if(isset($filter["name"])) $this->db->like('name',$filter['name'],'both');
        if(isset($filter["users"])) $this->db->like('users',$filter['users'],'both');
        $this->db->limit(10);
        $query  = $this->db->get($this->tableInfo);
        return $query->result_array();
    }
    
}


?>