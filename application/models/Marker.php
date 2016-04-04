<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-04-03
 * Time: 18:07
 */

class Marker extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getDetails($title, $latitude, $longitude) {
        $sql = 'SELECT Events.name AS title, description, longitude, latitude, Users.name AS username
                  FROM Events
                  JOIN Users ON Users.id = Events.userID
                  WHERE Events.name = ? AND latitude = ? AND longitude = ?
               ';
        $query = $this->db->query($sql, array($title, $latitude, $longitude));

        return ($this->db->affected_rows() > 0) ? $query->row() : null;
    }

}