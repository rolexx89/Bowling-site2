<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_lib
{
    public function captcha_actions()
    {
        $CI=& get_instance();
        //incarcarea plagin cap4a
        $CI->load->plugin('captha');
        //incarcarea incarcarea halper pentru generarea unui string
        $CI->load->helper('string');
        $rnd_str = random_string('numeric',5);
        //incarcarea unei cuvint , dupa sesie
        $ses_data = array();
        $ses_data['rnd_captcha']= $rnd_str;
        $CI->session->set_userdata($ses_data);
        
        //parametrul imageni
        $settings = array('wold' =>$rnd_str ,
                          'img_path'=>'./img/captcha/',
                          'img_url' =>base_url().'img/captcha/',
                          'font_path'=>'./system/fonts/cour/ttf',
                          'img_width'=>120,
                          'img_height'=>30,
                          'expiration'=>10
                );
        //crearea captcha
        $captcha = create_captcha($settings);
        //primim codul
        $imgcode = $captcha['image'];
        return $imgcode;
    }
}
