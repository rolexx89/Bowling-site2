<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_users extends CI_Model {

    private $table  = 'users';
/**
 * preiea toti utilizatori din array dupa id si 
 * cu ajutorul foreach preaiea fiecare  utilizator
 * @return type integer $list
 */   
    public function get_allusers() {   
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table);
        $data   = $query->result_array(); //afiseaza toti utilizatori intrun array
        $list   = array();
        foreach($data as $user)
            $list[$user['id']]  = $user;
        return $list;
    }
    /**
     * verifica daca utilizatori daca nare valoare negativa si daca exista in bd
     * @param type $user_id integer
     * @return type integer
     */
    public function checkUserById($user_id) {
        $user_id    = abs(0+$user_id);
        $this->db->where('id',$user_id);
        $this->db->limit(1);
        $query  = $this->db->get($this->table);
        $data   = $query->result_array();
        return ( empty($data) ? false : $data[0] );
    }

}

?>