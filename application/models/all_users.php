<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_users extends Crud {

    public function get_allusers($page = 0, $per_page = 5) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($per_page, $page * $per_page);
        $query = $this->db->get('users');
        return $query->result_array(); //afiseaza toti utilizatori intrun array
    }

}

?>