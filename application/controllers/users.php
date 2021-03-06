<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/users
	 *	- or -  
	 * 		http://example.com/index.php/users/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/game/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        /**function User()
        {
            parent::Controller();
            
            $this->view_data['base_url'] = base_url();
        }
                
        function index()
        {
            $this->add();
        }
    */
    /**
     * aici este finctia  de adaugarea a utilizatorului in baza de date la
     * moment  datele sunt introduse direct in cod, forma este in curs de creare
     */
	public function add() 
        {
        $data['id'] = "2";
	$data['name'] = "Alexandru";
        $data['surname'] ="Plotnic";
        $data['nick'] = "ae";
        
        $this-> load -> model('users_model');
        $this-> users_model-> add($data);
        //$this->load -> library('form_validation');
        // $this->form_validation->set_rulse('name');
       // if($this->form_validation->run() == FALSE){
            
        
        //$this->load->view('add_index', array ($data));
       // }
       // else
       // {
         //  $id = $this-> input -> post('id');
         //  $this->users_model->add($id);
         //  $name = $this-> input -> post('name');
         //  $this->users_model->add($name);
        //   $surname = $this-> input -> post('surname');
         //  $this->users_model->add($surname);
        //   $nick = $this-> input -> post('nick');
         //  $this->users_model->add($nick);
        //}
        }
/**
 * 
 * @param type $id se va sterge utilizatorul dupa id sau
 * este functia delete 
 */
	public function delete($id) 
        {
        $this-> load -> model('users_model');
        $this-> users_model-> delete($id);
                
	}
/**
 * aceasta functie face inlocuirea datelor un utilizator isi schimba nick pe altul
 */
	public function update() 
                {
	$data['id'] = "4";
	$data['name'] = "sergiu2";
        $data['surname'] ="Gordienco2";
        $data['nick'] = "S2";
        $this-> load -> model('users_model');
        $this-> users_model-> update($data);
                }
                /**
                 * este insashi afisarea datelor chind intram pe test.local 
                 * este afisati toti utilizatori a bd
                 */
        public function articles()
                {
           $this->load->library('pagination');

            $config['base_url'] = 'http://test.local/index.php/users/articles';
            $config['total_rows'] = '1';
            $config['per_page'] = '1'; 
            $config['full_tag_open'] = "<p style='text-align:center;'>";
            $config['full_tag_close'] = '</p>';

            $this->pagination->initialize($config); 

            
            $this->load->model('users_model');
            $data['users'] = $this->users_model->get_users($config['per_page'], $this->uri->segment(3));
            $this->load->view('users_index', $data);
            
                }
      
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */