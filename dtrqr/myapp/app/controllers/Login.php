<?php

class Login extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    function index()
    {
        $this->form_validation->set_rules('user_name', 'Username', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        $data['err_msg'] = '';

        if ($this->form_validation->run() == TRUE)
        {
            $user = $this->User_model->login();
            if(!empty($user))
            { 
                $this->session->set_userdata(array('id'=>$user->id,'user_name'=>$user->user_name,'user_type'=>$user->user_type));
                redirect('employee_time', 'auto');
            }
            $data['err_msg'] = 'Invalid Username or Password.';
        }

        $this->load->view('login', $data);
    }

    function logout() {
        session_destroy();
        redirect('login', 'auto');
    }
}