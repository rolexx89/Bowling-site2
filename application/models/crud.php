<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Model {

    public $table = ''; //numele tabelei
    public $idkey = ''; //numele id

    public function Crud() {
        parent::__construct();
    }

    public function get($obj_id) {
        $this->db->where($this->idkey, $obj_id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

}

