<?php

class Checksess {

	private $CI;

	function __construct()
    {
        $this->CI =& get_instance();

        if(!isset($this->CI->session)){  //Check if session lib is loaded or not
              $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }

	function check_user_session()
    {
        if(null==$this->CI->session->userdata('user_name')) {
        	// remove /dtrqr
        	if($_SERVER['REQUEST_URI'] != '/login') {
        		redirect('login');
        	}
        } else {
        	// remove /dtrqr
        	if($_SERVER['REQUEST_URI'] == '/login') {
        		redirect('employee_time');
        	}
        }
    }
}