<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages_model extends CI_Model {

    public $table = 'users'; //Numele tabelului
    public $idkey = 'id'; //id index al fecarui utilizator
    /**
     *validarea dateleor pentru crearea utilizatorului
     * @var type array
     */
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
    /**
     *validarea datelor dupa editare
     * @var type array
     */
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
/**
 * introducerea unui user nou in bd sql
 * @param type $users_data array
 */
    public function add_new($users_data) {
       
        $this->db->insert('users', $users_data);
    }
/**
 * stergearea unui utilizator dupa id
 * @param type $id integer
 */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
/**
 * etidatrea utilizatorului dupa id si editarea utilizatorului
 * @param type $id integer
 * @param type $data array
 */
    public function edit($id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update('users', $data);
    }
    /**
     * preluarea toti utilizatori dupa idKey
     * @param type $obj_id integer
     * @return type row_array
     */
    public function get($obj_id) {
        $this->db->where($this->idkey, $obj_id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
}

?>