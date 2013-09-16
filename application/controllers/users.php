<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->library('captcha_lib');
    }

    public function allUsers() {
        $data['allUsers'] = $this->UsersModel->GetAllUsers();

        $name = 'pages/allUsers';

        $this->display_lib->usersPage($data, $name);
    }

    public function field() {

        if (!isset($_POST['send_message'])) {
            $data['imgcode'] = $this->captcha_lib->captcha_actions();
            $data['info'] = '';

            $name = 'pages/field';

            $this->display_lib->usersPage($data, $name);
        } else {
            $this->form_validation->set_rules($this->UsersModel->fieldRules);

            $val_res = $this->form_validation->run();

            //daca falidarea merge
            if ($val_res == TRUE) {
                $entered_captcha = $this->input->post('captcha');

                if ($entered_captcha == $this->session->userdata('rnd_captcha')) {



                    $this->load->library('typography');
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $nick = $this->input->post('nick');

                    $this->display_lib->usersPage(array('info' => 'Succes'), 'info');
                    $this->UsersModel->addNew(array(
                        'name' => $name,
                        'surname' => $surname,
                        'nick' => $nick
                    ));
                    redirect('/users/all', 'localtion', 302);
                } else {
                    $data['imgcode'] = $this->captcha_lib->captcha_actions();
                    $data['info'] = 'nui corec';
                    $name = 'pages/field';
                    $this->display_lib->usersPage($data, $name);
                }
            } else {
                $data['imgcode'] = $this->captcha_lib->captcha_actions();
                $data['info'] = '';
                $name = 'pages/field';
                $this->display_lib->usersPage($data, $name);
            }
        }
    }

    public function show($id) {
        $data = array();
        $data ['main_info'] = $this->UsersModel->get($id);

        if ($id) {

            if (empty($data['main_info'])) {
                $data['info'] = 'nu exista asa pagina';
                $name = 'info';

                $this->display_lib->userInfoPage($data, $name);
            } else {
                $name = 'pages/user';

                $this->display_lib->usersPage($data, $name);
            }
        }
    }

    /**
     * @param int $user_id delete user for id
     */
    public function userRemove($user_id) {
        $this->UsersModel->delete($user_id);
        redirect('users/all', 'localtion', 302);
    }

    /**
     * @param int $id  edit users for id 
     */
    public function edit($id) {
        $data['main_info'] = $this->UsersModel->get($id);

        if (!empty($data['main_info']) && isset($_POST['edit'])) {
            $this->form_validation->set_rules($this->UsersModel->contactEditRules);
            $val_res = $this->form_validation->run();
            if ($val_res == TRUE) {
                $this->UsersModel->edit($id, array(
                    'name' => $this->input->post('name'),
                    'surname' => $this->input->post('surname'),
                    'nick' => $this->input->post('nick')
                ));
                redirect('/users/all', 'localtion', 302);
            }
        }

        $this->display_lib->usersPage($data, 'pages/edit');
    }

}

?>