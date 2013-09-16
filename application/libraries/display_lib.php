<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_Lib {

    /**
     * connection between controller and view page
     * @param array $data  content on page
     * @param $name name view
     */
    public function usersPage($data, $name, $only_content = false) {
        $CI = &get_instance();

        if (!$only_content)
            $CI->load->view('header', $data);

        if (method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
        if (!$only_content)
            $CI->load->view('footer', $data);
    }

    /**
     * @param array $data content on page
     * @param  $name name view for error 
     */
    public function userInfoPage($data, $name) {
        $CI = &get_instance();
        if (method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
    }

}

?>