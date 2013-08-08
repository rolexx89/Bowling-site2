<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model {

    function get_users($num , $offset)
    {
       $this-> db-> limit('10'); 
       $this-> db-> order_by('id','desc'); 
       $query = $this-> db-> get('users', $num, $offset);
       return $query->result_array();
    }
	
    function add($data)
    {
       // $data = array('id' => $id , name => $name, 'surname' => $surname, 'nick' => $nick);
      //  $str = $this->db->insert_string('users', $data);
       // $str1 ="INSERT INTO table_name (id , name, surname, nick) VALUES ('id', 'Rick', 'lala', 'la')";
       // $this->load->view('add_index', $data);
        $this->db->insert('users',$data);
        //$query_str = "INSERT INTO users (name) VALUES(?)";
        //$this->db->insert('users', array('name'=>'?'));
        
    }

    function update ($data)
    {
        $this->db->where('id','4');
        $this->db->update('users',$data);
    }
    function  delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('users');
    }
	
}

/* End of file users.php */
/* Location: ./application/models/users_model.php */
