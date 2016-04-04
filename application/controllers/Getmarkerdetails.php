<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-04-03
 * Time: 18:07
 */

class Getmarkerdetails extends CI_Controller {

    public function index() {
//        $_POST["name"] = "Warszawa";
//        $_POST["latitude"] = "52.2296756";
//        $_POST["longitude"] = "21.0122287";

        // json response array
        $response = array("error" => FALSE);

        $title = $this->input->post('name', TRUE);
        $latitude = $this->input->post('latitude', TRUE);
        $longitude = $this->input->post('longitude', TRUE);

        if (isset($title) && isset($latitude) && isset($longitude)) {
            $this->load->model('Marker');

            // Get marker details
            $marker = $this->Marker->getDetails($title, $latitude, $longitude);

            if (isset($marker) || !empty($marker)) {
                // Put to json
                $response["error"] = FALSE;
                $response["marker"]["title"] = $marker->title;
                $response["marker"]["username"] = $marker->username;
                $response["marker"]["description"] = $marker->description;

                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }

        } else {
            // Required post params is missing
            $response["error"] = TRUE;
            $response["error_msg"] = "Required parameters is missing!";

            echo json_encode($response);
        }
    }

}