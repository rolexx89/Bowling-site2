<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_lib {

    public function users_page($data, $name) {
        $CI = &get_instance();

        //var_dump($name.'_view');
        $CI->load->view($name . '_view', $data);
    }

    public function user_info_page($data, $name) {
        $CI = &get_instance();

        // var_dump($name.'_view');
        $CI->load->view('info_preheader_view');
        $CI->load->view($name . '_view', $data);
    
    
    
}

}
?>