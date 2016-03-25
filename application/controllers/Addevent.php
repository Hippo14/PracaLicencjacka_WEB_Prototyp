<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-25
 * Time: 07:22
 */

class Addevent extends CI_Controller {

    public function index() {
        // json response array
        $response = array("error" => FALSE);

        $name = $this->input->post('name', TRUE);
        $description = $this->input->post('description', TRUE);
        $latitude = $this->input->post('latitude', TRUE);
        $longitude = $this->input->post('longitude', TRUE);

        if (isset($name) && isset($description) && isset($latitude) && isset($longitude) && is_numeric($latitude) && is_numeric($longitude)) {
            $this->load->model('Validate_model');

            // Check if event exists
            if ($this->Validate_model->isEventExist($latitude, $longitude)) {
                // Event already existed
                $response["error"] = TRUE;
                $response["error_msg"] = "Event already existed on that location!";

                echo json_encode($response);
            } else {
                // Create new event
                if ($this->Validate_model->storeEvent($name, $description, $latitude, $longitude)) {
                    // Get created event
                    $event = $this->Validate_model->getEventByLatLng($latitude, $longitude);

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
        } else {
            // Required post params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters is missing!";

            echo json_encode($response);

        }
    }

}