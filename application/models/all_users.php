<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_users extends Crud {

    public function get_allusers() {
        $this->db->order_by('id', 'desc');
        $this->db->limit(4);
        $query = $this->db->get('users');
        return $query->result_array(); //afiseaza toti utilizatori intrun array
    }

}

?> 