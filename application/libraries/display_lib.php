<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_Lib {

/**
 * legatura intre controler si page view
 * @param array $data  continutului pageni
 * @param $name denumirea view
 */
    public function usersPage($data, $name, $only_content = false) {
        $CI = &get_instance();
        
        if(!$only_content)
            $CI->load->view('header', $data);
     
        if(method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
        if(!$only_content)
            $CI->load->view('footer', $data);
    }
/**
 * @param array $data continutul de pe pagina
 * @param  $name denumirea view rederectioneaza paginea de eroare 
 */
    public function userInfoPage($data, $name) {
        $CI = &get_instance();
        if(method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
    }

}

?>