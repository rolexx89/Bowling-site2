<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('all_users');
    }

    function Pages() {
        parent::CI_Controller();
    }
    
    public function index() {
        redirect (base_url());
    }

    public function show($id) {
        // $this->load->model('pages_model');
        $data = array();
        //toti utilizatori intru masif care va afisha pe toti printru for
        $data['all_users'] = $this->all_users->get_allusers();

        //afisheaza doar dupa un id 
        $data ['main_info'] = $this->pages_model->get($id); //tot araiul va fi doar pe o pagina

        switch ($id) {
            case '2':   //dupa id putem afisha orce utilizator si toate datele din bd
                $name = 'pages/pages';

                $this->display_lib->users_page($data, $name);
                
                break;
               
            //pagina filed
            case 'filed':
                $this->load->library('captcha_lib');
                //butonul nu este tastat pentru transmite
                
                if (!isset($_POST['send_message']))
                {
                    $data['imgcode'] = $this->captcha_lib->captcha_actions();
                    $data['info'] = '';
                    
                    $name= 'pages/filed';
                    
                    $this->dispaly_lib->user_page($data,$name);
                    
                }
                else
                {
                    $this->form_validation->set_rules($this->pages_model->contact_rules);
                    
                    $val_res = $this->form_validation->run();
                    
                    //daca falidarea merge
                    if($val_rus==TRUE)
                    {
                        $entered_captcha= $this->input->post('capthca');
                        
                        if($entered_captcha == $this->session->userdata('rnd_captcha'))
                        {
                            $this->load->library('typography');
                            $name->load->input->post('name');
                            $surname->load->input->post('surname');
                            $nick->load->input->post('nick');
                            $name = $this->typography->auto_typography($name,TRUE);
                            $name= strip_tags($name);
                            $message = "A scris:$name\nTema: $surname\nmesaj:\n$nick\nsdad";
                        
                            mail($name,$surname,$nick,"Content_type:text/plain;charset = windows-1251\r\n");
                            $data['info']= 'merssi';
                            $name = 'info';
                            $this->display_lib->user_info_page($data,$name);
                        }
                           else
                           {
                               $data['imgcode']= $this->captcha_lib->captcha_actions();
                               $data['info']= 'nui corec';
                               $name = 'pages/filed';
                               $this->display_lib->user_page($data,$name);
                           }
                        }    
                    
                        else{
                            $data['imgcode']=$this->captcha_lib->captcha_actions();
                            $data['info']='';
                            $name='pages/contact';
                            $this->display_lib->user_page($data,$name);
                            
                        }
                        
                           }
            
                break; 
            default :
                //daca e gol
                if (empty($data['main_info']))
                {
                    $data['info'] = 'nu exista asa pagina';
                    $name = 'info';
                    
                    $this->display_lib->user_info_page($data,$name);
                }
                else 
                {
                   $name = 'pages/page';

                $this->display_lib->users_page($data, $name);
                
                break;
                }
        }
    }

}

?>