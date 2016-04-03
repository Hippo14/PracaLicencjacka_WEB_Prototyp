<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-29
 * Time: 21:34
 */

class Getevent extends CI_Controller {

    public function index() {
//        $_POST["latitude"] = "52.2296756";
//        $_POST["longitude"] = "21.0122287";

        // json response array
        $response = array("error" => FALSE);

        $latitude = $this->input->post('latitude', TRUE);
        $longitude = $this->input->post('longitude', TRUE);

        if (isset($latitude) && isset($longitude)) {
            $this->load->model('Event');

            $events = $this->Event->getEvents($latitude, $longitude);

            // Get all events
            if (isset($events) || !empty($events)) {
                // Put to json
                $response["error"] = FALSE;
//                for ($i = 0; $i < count($events); $i++) {
//                    $response["events"][$i]["name"] = $events->name;
//                    $response["events"][$i]["latitude"] = $events->latitude;
//                    $response["events"][$i]["longitude"] = $events->longitude;
//                }
                $response["events"] = $events;

                echo json_encode($response, JSON_UNESCAPED_UNICODE);

            } else {
                // Error - not found events

                $response["error"] = TRUE;
                $response["error_msg"] = "No events found!";

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