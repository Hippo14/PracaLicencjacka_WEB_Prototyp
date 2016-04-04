<?php

class Event extends CI_Model {

    private $const = 0.5;
    private $const10 = 1;

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
                    `longitude` > ? - \''.$this->const.'\'
                    AND
                    `longitude` < ? + \''.$this->const.'\'
                    AND
                    `latitude` > ? - \''.$this->const.'\'
                    AND
                    `latitude` < ? + \''.$this->const.'\'';

        $query = $this->db->query($sql, array($longitude, $longitude, $latitude, $latitude));

        return ($this->db->affected_rows() > 0) ? $query->result() : null;
    }

    function get10Events($latitude, $longitude) {
        $sql = 'SELECT Events.name AS title, Users.name AS username FROM `Events`
                JOIN Users ON Users.id = Events.userID
                WHERE
                    `longitude` > ? - \''.$this->const10.'\'
                    AND
                    `longitude` < ? + \''.$this->const10.'\'
                    AND
                    `latitude` > ? - \''.$this->const10.'\'
                    AND
                    `latitude` < ? + \''.$this->const10.'\'
                LIMIT 10';

        $query = $this->db->query($sql, array($longitude, $longitude, $latitude, $latitude));

        return ($this->db->affected_rows() > 0) ? $query->result() : null;
    }

}