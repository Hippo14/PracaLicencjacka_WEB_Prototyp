<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-03-29
 * Time: 21:34
 */

class Getevent extends CI_Controller {

    public function index() {
        // json response array
        $response = array("error" => FALSE);

        $response["error"] = TRUE;
        $response["error_msg"] = "Some webservice error!";

        echo json_encode($response);
    }

}