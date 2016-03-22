<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validate extends CI_Controller {

    public function index()
    {
        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $accountType = $this->input->post('accountType', TRUE);
        $password = $this->input->post('password', TRUE);

        $this->load->model('Validate_model');

        if (!empty($name) || !empty($email) || !empty($accountType) || !empty($password)) {
            $this->Validate_model->insert_user($name, $email, $accountType, $password);
        }
        else {
            print '<pre>';
            print_r($this->Validate_model->get_last_user());
            print '</pre>';
        }
    }
}
