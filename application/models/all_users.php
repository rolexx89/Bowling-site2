<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_users extends CI_Model {

    private $table  = 'users';
            
    public function get_allusers($page = 0, $per_page = 5) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($per_page, $page * $per_page);
        $query = $this->db->get($this->table);
        $data   = $query->result_array(); //afiseaza toti utilizatori intrun array
        $list   = array();
        foreach($data as $user)
            $list[$user['id']]  = $user;
        return $list;
    }
    
    public function checkUserById($user_id) {
        $user_id    = abs(0+$user_id);
        $this->db->where('id',$user_id);
        $this->db->limit(1);
        $query  = $this->db->get($this->table);
        $data   = $query->result_array();
//        var_dump($user_id ,( empty($data) ? false : $data[0] ));
        return ( empty($data) ? false : $data[0] );
    }

}

?>