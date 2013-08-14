<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_lib
{    

public function captcha_actions()
{
    $CI =& get_instance ();          
        
    
    //$CI->load->plugin('captcha');
      $CI->load->helper('captcha');   

    $CI->load->helper('string');		
    $rnd_str = random_string('numeric',5);
            			
    
    $ses_data = array();
    $ses_data['rnd_captcha'] = $rnd_str;
    $CI->session->set_userdata($ses_data);
            			
    $settings = array(            'word'	   => $rnd_str,
     				  'img_path'   => './img/captcha/',
       				  'img_url'    => base_url().'img/captcha/',
       				  'font_path'  => './system/fonts/cour.ttf',
      				  'img_width'  => 120,
      				  'img_height' => 30,
       				  'expiration' => 10);


    $captcha = create_captcha($settings);
                     
 
    $imgcode = $captcha['image'];   
    return $imgcode;          
}
   
}
?>