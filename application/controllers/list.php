<?php

/* SEND EMAIL WITH GMAIL */

class List extends CI_Controller
{
    
    
    function __construct()
        {
            parent::__construct();
                 $this->logged_in();
        }

     var $data;
     
     public function logged_in()
     {
         $logged_in = $this->session->userdata('logged_in');
         
         if(!isset($logged_in)|| $logged_in != true)
         {
             //echo 'You do not have permission to access this page.';
             $this->data['header_content'] = 'includes/headerout';
         }
         else
         {
             $this->data['header_content'] = 'includes/headerin';
         }
     }
    
    public function index()
    {
 
        $test = "this was sent";
        return $test;
    }
}