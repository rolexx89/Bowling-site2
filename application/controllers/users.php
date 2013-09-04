<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    public   $load;
    public   $all_users;

    function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->library('captcha_lib');
    }
    
/**
 * redirectioneaza la pagina initiala 
 */
    public function index() {
        redirect(base_url());
    }
    
/**
 * acceseaza modelul allUsers si inscrie in array $data['all_users']
 * si apoi trece prin clasa display pentru a afisha datele
 */
    public function allUsers() {
        $data['all_users'] = $this->users_model->get_allusers();

        $name = 'pages/pages';

        $this->display_lib->users_page($data, $name);
       
    }
/**
 * functia filed aceasta e field introducerea datelor utilizatorului in bd 
 * crearea si captcha
 */
    public function filed() {
        
        if (!isset($_POST['send_message'])) {
            $data['imgcode'] = $this->captcha_lib->captcha_actions();
            $data['info'] = '';

            $name = 'pages/filed';

            $this->display_lib->users_page($data, $name);
        } else {
            $this->form_validation->set_rules($this->users_model->field_rules);

            $val_res = $this->form_validation->run();

            //daca falidarea merge
            if ($val_res == TRUE) {
                $entered_captcha = $this->input->post('captcha');

                if ($entered_captcha == $this->session->userdata('rnd_captcha')) {



                    $this->load->library('typography');
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $nick = $this->input->post('nick');

                    $this->display_lib->users_page(array('info' => 'Succes'), 'info');
                    // $this->input->post('users');
                    $this->users_model->add_new(array(
                        'name' => $name,
                        'surname' => $surname,
                        'nick' => $nick
                    ));
                    redirect('/users/all', 'localtion', 302);
                } else {
                    $data['imgcode'] = $this->captcha_lib->captcha_actions();
                    $data['info'] = 'nui corec';
                    $name = 'pages/filed';
                    $this->display_lib->users_page($data, $name);
                }
            } else {
                $data['imgcode'] = $this->captcha_lib->captcha_actions();
                $data['info'] = '';
                $name = 'pages/filed';
                $this->display_lib->users_page($data, $name);
            }
        }
    }
/**
 * 
 * @param type $id un array care prin id utilizatorului 
 * prea toate datele utilizatorului
 * tot araiul va fi doar pe o pagina
 * $data['info'] acest array va fi afishat doar chind in url scriem nu crecta pagina
 */
    public function show($id) {
        $data = array();
        $data ['main_info'] = $this->users_model->get($id); 

        if ($id) {

            if (empty($data['main_info'])) {
                $data['info'] = 'nu exista asa pagina';
                $name = 'info';

                $this->display_lib->user_info_page($data, $name);
            } else {
               
                $name = 'pages/page';

                $this->display_lib->users_page($data, $name);
            }
         }
     }
/**
 * va sterge tot utilizatoul dupa id , o line 
 * @param type $user_id integer
 */
    public function userRemove($user_id) {
        $this->users_model->delete($user_id);
        redirect('users/all', 'localtion', 302);
    }
/**
 * dupa id va fi efectuat edit pentru editarea utilizatorului
 * @param type $id integer 
 */
    public function edit($id) {
        $data['main_info'] = $this->users_model->get($id);

        if (!empty($data['main_info']) && isset($_POST['edit'])) {
            $this->form_validation->set_rules($this->users_model->contact_edit_rules);
            $val_res = $this->form_validation->run();
            if ($val_res == TRUE) {
                $this->users_model->edit($id, array(
                    'name' => $this->input->post('name'),
                    'surname' => $this->input->post('surname'),
                    'nick' => $this->input->post('nick')
                ));
                redirect('/users/all', 'localtion', 302);
            } 
        }
        
        $this->display_lib->users_page($data, 'pages/edit');
        
    }

}

?>