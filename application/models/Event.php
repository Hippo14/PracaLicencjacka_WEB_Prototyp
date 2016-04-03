<?php

class Event extends CI_Model {

    function __construct() {
        parent::__construct();
    }



    function isEventExist($longitude, $latitude) {
        $sql = 'SELECT name FROM Events WHERE longitude = ? AND latitude = ?';
        $query = $this->db->query($sql, array($longitude, $latitude));

        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function getEventByLatLng($latitude, $longitude) {
        $sql = 'SELECT name, description, latitude, longitude FROM Events WHERE latitude = ? AND longitude = ? LIMIT 1';
        $query = $this->db->query($sql, array($latitude, $longitude));

        return ($this->db->affected_rows() > 0) ? $query->row() : null;
    }

    function storeEvent($name, $description, $latitude, $longitude, $userID, $categoryID) {
        $data = array(
            'name'         => $name,
            'description'  => $description,
            'latitude'     => $latitude,
            'longitude'    => $longitude,
            'userID'       => $userID,
            'categoryID'   => $categoryID
        );

        $this->db->insert('Events', $data);

        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function getEvents($latitude, $longitude) {
        $sql = 'SELECT * FROM `Events` WHERE
                    `longitude` > ? - 0.005
                    AND
                    `longitude` < ? + 0.005
                    AND
                    `latitude` > ? - 0.005
                    AND
                    `latitude` < ? + 0.005';

        $query = $this->db->query($sql, array($longitude, $longitude, $latitude, $latitude));

        return ($this->db->affected_rows() > 0) ? $query->result() : null;
    }

}