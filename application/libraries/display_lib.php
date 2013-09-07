<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_Lib {
    
    function __construct() {
    }
/**
 * cu ajutorul acestei classe putem lega controlerul si pagena view
 * @param type $data array continutului pageni
 * @param type $name denumirea pageni dupa url
 */
    public function usersPage($data, $name, $only_content = false) {
        $CI = &get_instance();
        if(!$only_content)
            $CI->load->view('header', $data);
                //var_dump($name.'_view');
        if(method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
        if(!$only_content)
            $CI->load->view('footer', $data);
    }
/**
 * rederectioneaza pla paginea de eroare , cu datele $data si denumirea $name
 * @param type $data continutul de pe pagina
 * @param type $name url
 */
    public function userInfoPage($data, $name) {
        $CI = &get_instance();
        if(method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
    }

}

?>