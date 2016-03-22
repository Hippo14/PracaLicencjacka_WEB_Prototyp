<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-20
 * Time: 20:07
 */

class Login extends CI_Controller {

    public function index() {
        // JSON Response array
        $response = array("error" => FALSE);

        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);

        if ((!empty($email) && !empty($password)) || (isset($email) && isset($password))) {
            // Get the user by email and password
            $this->load->model('Validate_model');
            $user = $this->Validate_model->getUserByEmailAndPassword($email, $password);

            if (isset($user) || !empty($user)) {
                // User is found
                $response["error"] = FALSE;
                $response["user"]["name"] = $user->name;
                $response["user"]["email"] = $user->email;

                echo json_encode($response);
            }
            else {
                // User is not found
                $response["error"] = TRUE;
                $response["error_msg"] = "Login credentials are wrong. Please try again!";
                echo json_encode($response);
            }
        } else {
            // Required post params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters is missing!";
            echo json_encode($response);
        }

    }

}