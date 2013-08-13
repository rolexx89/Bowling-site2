<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages_model extends crud {

    public $table = 'users'; //Numele tabelului
    public $idkey = 'id'; //id index al fecarui utilizator

    
    public $contact_rules = array
            (
        array
        (
            'field'=>'name',
            'label'=>'nume',
            'rules'=>'trim|required|xss_clean|max_length[70]'
        ),
        array (
            'field'=>'surname',
            'label'=>'surname',
            'rules'=>'trim|required|valid_email|xss_clean|max_leangth[70]'
        ),
         array (
            'field'=>'nick',
            'label'=>'nickname',
            'rules'=>'trim|required|valid_email|xss_clean|max_leangth[70]'
        ),
        array (
            'field'=>'captcha',
            'label'=>'cifrele din imagine',
            'rules'=>'required|numeric|exact_length[5]'
        )
            );
}

?> 