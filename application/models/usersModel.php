<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usersModel extends CI_Model {

    /**
     * @var $table name table
     * @var $idkey id  tabel
     */
    private $table = 'users';
    public $idkey = 'id';

    /**
     * @var array $fieldRulers validation of user data
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
     * @var array $contactEditRules validation of user data for edit
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
     * @param array $users_data write new user in bd sql
     */
    public function addNew($users_data) {

        $this->db->insert('users', $users_data);
    }

    /**
     * 
     * @param integer $id delete user by id
     */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    /**
     * edit user by id
     * @param type $id integer
     * @param type $data string
     */
    public function edit($id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update('users', $data);
    }

    /**
     * After taking all users idKey
     * @param int $obj_id 
     * @return row_array
     */
    public function get($obj_id) {
        $this->db->where($this->idkey, $obj_id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    /**
     * @return $list 
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
     * @param int $user_id check if the user does not have negative value and if in bd
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
    public function exportDataJson($user_id) {
       $this->db->where('id', $user_id);
       $rel =  $query = $this->db->get($this->table);
        
        if($rel->num_row!=0)
        {
            
            $user=array();    
            foreach ($rel->result_array() as $row)
            {
                $user[]=  array(
                   'id'=>$row['id'],
                    'user'=>$row['user']
                    
                    
                );
            }
        return $user;}
        else {
            return FALSE;
        }
            echo json_encode ($getData);
    }

}

?>