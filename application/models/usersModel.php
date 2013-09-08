<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usersModel extends CI_Model {

    /**
     * @var $table numele tabelului
     * @var $idkey id  tabelului
     */
    private $table = 'users';
    public $idkey = 'id';

    /**
     * @var array $fieldRulers validarea dateleor utilizatorului
     */
    public $fieldRules = array(
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
     * @var array $contactEditRules validarea datelor la editare
     */
    public $contactEditRules = array(
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
     * @param array $users_data introducerea unui user nou in bd sql
     */
    public function addNew($users_data) {

        $this->db->insert('users', $users_data);
    }

    /**
     * stergearea unui utilizator dupa id
     * @param integer $id stergearea utilizator dupa id
     */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    /**
     * etidatrea utilizatorului dupa id si editarea utilizatorului
     * @param type $id integer
     * @param type $data string
     */
    public function edit($id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update('users', $data);
    }

    /**
     * preluarea toti utilizatori dupa idKey
     * @param int $obj_id 
     * @return row_array
     */
    public function get($obj_id) {
        $this->db->where($this->idkey, $obj_id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    /**
     * @return $list preiea toti utilizatori din bd dupa id si preaiea utilizatori
     */
    public function GetAllUsers() {

        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table);
        $data = $query->result_array(); 
        $list = array();
        foreach ($data as $user)
            $list[$user['id']] = $user;
        return $list;
    }

    /**
     * @param int $user_id verifica daca utilizatori daca nare valoare negativa 
     * si daca exista in bd
     * @return integer
     */
    public function checkUserById($user_id) {
//      $user_id    = abs(0+$user_id);
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $data = $query->result_array();
        return ( empty($data) ? false : $data[0] );
    }

}

?>