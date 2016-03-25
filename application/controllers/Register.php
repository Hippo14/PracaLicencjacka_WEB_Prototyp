<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-21
 * Time: 20:01
 */

class Register extends CI_Controller {

    public function index() {
        // json response array
        $response = array("error" => FALSE);

        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $accountType = $this->input->post('accountType', TRUE);
        $password = $this->input->post('password', TRUE);

        if (isset($name) && isset($email) && isset($accountType) && isset($password)) {
            $this->load->model('Validate_model');

            // Check if user already exists
            if ($this->Validate_model->isUserExisted($email)) {
                // User already existed
                $response["error"] = TRUE;
                $response["error_msg"] = "User already existed with " . $email;

                echo json_encode($response);
            } else {
                // Create a new user
                if ($this->Validate_model->storeUser($name, $email, $accountType, $password)) {
                    // Get created user
                    $user = $this->Validate_model->getUserByEmailAndPassword($email, $password);

                    if (isset($user) || !empty($user)) {
                        // User stored successfully
                        $response["error"] = FALSE;
                        $response["user"]["name"] = $user->name;
                        $response["user"]["email"] = $user->email;
                        $response["user"]["accountType"] = $user->accountType;
                        $response["user"]["password"] = $user->password;

                        echo json_encode($response);
                    } else {
                        // User failed to store
                        $response["error"] = TRUE;
                        $response["error_msg"] = "Unknown error occurred in registration!";

                        echo json_encode($response);
                    }
                } else {
                    // User failed to store
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Unknown error occurred in registration!";

                    echo json_encode($response);
                }
            }
        } else {
            // Required post params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters is missing!";

            echo json_encode($response);
        }
    }

}