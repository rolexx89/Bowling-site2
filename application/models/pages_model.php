<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages_model extends crud {

    public $table = 'users'; //Numele tabelului
    public $idkey = 'id'; //id index al fecarui utilizator
    public $field_rules = array(
        array(
            'field' => 'name',
            'label' => 'nume',
            'rules' => 'trim|required|xss_clean|max_length[70]'
        ),
        array(
            'field' => 'surname',
            'label' => 'surname',
            'rules' => 'trim|required|xss_clean|max_leangth[70]'
        ),
        array(
            'field' => 'nick',
            'label' => 'nickname',
            'rules' => 'trim|required|xss_clean|max_leangth[70]'
        ),
        array(
            'field' => 'captcha',
            'label' => 'cifrele din imagine',
            'rules' => 'required|numeric|exact_length[5]'
        )
    );
    public $contact_edit_rules = array(
        array(
            'field' => 'name',
            'label' => 'nume',
            'rules' => 'trim|required|xss_clean|max_length[70]'
        ),
        array(
            'field' => 'surname',
            'label' => 'surname',
            'rules' => 'trim|required|xss_clean|max_leangth[70]'
        ),
        array(
            'field' => 'nick',
            'label' => 'nickname',
            'rules' => 'trim|required|xss_clean|max_leangth[70]'
        )
    );

    public function get_by($id) {
        $this->db->order_by('id', 'desc');
        //  $this->db->where('id',$id);
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function add_new($users_data) {
       
        $this->db->insert('users', $users_data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function edit($id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update('users', $data);
    }

}

?>