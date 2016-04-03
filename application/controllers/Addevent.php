<?php

/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-25
 * Time: 07:22
 */
class Addevent extends CI_Controller
{

    public function index()
    {
        // json response array
        $response = array("error" => FALSE);

        $_POST["categoryID"] = "1";
//        $_POST["email"] = "hitler@lol.pl";
//        $_POST["name"] = "asdasdasd";
//        $_POST["description"] = "asdasdasdasdasdasdasda1";
//        $_POST["latitude"] = "1";
//        $_POST["longitude"] = "1";

        $email = $this->input->post('email', TRUE);
        $name = $this->input->post('name', TRUE);
        $description = $this->input->post('description', TRUE);
        $latitude = $this->input->post('latitude', TRUE);
        $longitude = $this->input->post('longitude', TRUE);
        $categoryID = $this->input->post('categoryID', TRUE);

        if (isset($email) && isset($name) && isset($description) && isset($latitude) && isset($longitude) && is_numeric($latitude) && is_numeric($longitude)) {
            $this->load->model('Event');
            $this->load->model('User');

            // Check if event exists
            if ($this->Event->isEventExist($longitude, $latitude)) {
                // Event already existed
                $response["error"] = TRUE;
                $response["error_msg"] = "Event already existed on that location!";

                echo json_encode($response);
            } else {
                $userID = $this->User->getUserIDByEmail($email);

                // Get user ID
                if (!is_numeric($userID)) {
                    // Not found user ID
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Not found ID!".$userID;

                    echo json_encode($response);
                } else {
                    // Create new event
                    if ($this->Event->storeEvent($name, $description, $latitude, $longitude, $userID, $categoryID)) {
                        // Get created event
                        $event = $this->Event->getEventByLatLng($latitude, $longitude);

                        if (isset($event) || !empty($event) || $latitude == $event->latitude || $longitude == $event->longitude) {
                            // Event stored successfully
                            $response["error"] = FALSE;
                            $response["error_msg"] = "Event created successfully!";

                            echo json_encode($response);
                        } else {
                            // Event failed to store
                            $response["error"] = TRUE;
                            $response["error_msg"] = "Unknown error occured in creating!";

                            echo json_encode($response);
                        }
                    } else {
                        // Event failed to store
                        $response["error"] = TRUE;
                        $response["error_msg"] = "Unknown error occured in creating!";

                        echo json_encode($response);
                    }
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