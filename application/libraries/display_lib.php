<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_lib {
/**
 * cu ajutorul acestei classe putem lega controlerul si pagena view
 * @param type $data array continutului pageni
 * @param type $name denumirea pageni dupa url
 */
    public function users_page($data, $name) {
        $CI = &get_instance();

        //var_dump($name.'_view');
        if(method_exists($CI, 'actionSuffix'))
            $CI->actionSuffix($data);
        $CI->load->view($name . '_view', $data);
    }
/**
 * rederectioneaza pla paginea de eroare , cu datele $data si denumirea $name
 * @param type $data continutul de pe pagina
 * @param type $name url
 */
    public function user_info_page($data, $name) {
        $CI = &get_instance();
        $CI->load->view($name . '_view', $data);
    }

}

?>