<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('all_users');
        $this->load->library('captcha_lib');
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
         //   case 'user'
             //   $data ['fail_captcha']= '';
        //$data ['success_user']= '';
           //     $data ['user_list']= $this->users_model->get_by($id);
           //     $name = 'pages/user';
           //     $this->display_lib->users_page($data,$name);
           // break;
        
        
            case 'all':   //dupa id putem afisha orce utilizator si toate datele din bd
                $name = 'pages/pages';

                $this->display_lib->users_page($data, $name);
                
                break;
               
            //pagina filed
            case 'filed':
              
                
                //butonul nu este tastat pentru transmite
                
                if ( ! isset($_POST['send_message']))
                {
                    $data['imgcode'] = $this->captcha_lib->captcha_actions();
                    $data['info'] = '';
                    
                    $name= 'pages/filed';
                    
                    $this->display_lib->users_page($data,$name);
                }
                else
                {
                    $this->form_validation->set_rules($this->pages_model->contact_rules);
                    
                    $val_res = $this->form_validation->run();
                    
                    //daca falidarea merge
                    if( $val_res == TRUE )
                    {
                        $entered_captcha= $this->input->post('captcha');
                        
                        if($entered_captcha == $this->session->userdata('rnd_captcha'))
                        {
                          
                                
                            
                            $this->load->library('typography');
                            $name   = $this->input->post('name');
                            $surname= $this->input->post('surname');
                            $nick   = $this->input->post('nick');
                        //  $name = $this->typography->auto_typography($name,TRUE);
                        //  $name= strip_tags($name);
                         
                            
                            
                            $this->display_lib->users_page(array('info' => 'Succes'),'info');
                           // $this->input->post('users');
                            $this->pages_model->add_new(array(
                                'name'      => $name,
                                'surname'   => $surname,
                                'nick'      => $nick
                            ));
                        }
                           else
                           {
                               $data['imgcode']= $this->captcha_lib->captcha_actions();
                               $data['info']= 'nui corec';
                               $name = 'pages/filed';
                               $this->display_lib->users_page($data,$name);
                           }
                        }    
                    
                        else{
                            $data['imgcode']=$this->captcha_lib->captcha_actions();
                            $data['info']='';
                            $name='pages/filed';
                            $this->display_lib->users_page($data,$name);
                            
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
    
    public function userremove($user_id) {
        $this->pages_model->delete($user_id);
        redirect('/pages/all','localtion',302);
    }

}

?>