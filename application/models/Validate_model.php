<?php

class Validate_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_last_user() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('Users', 1);

        return $query->result();
    }

    function insert_user($name, $email, $accountType, $password) {
        $data = array(
            'name'          => $name,
            'email'         => $email,
            'accountType'   => $accountType,
            'password'      => $password
        );
        $this->db->insert('Users', $data);
    }

    function getUserByEmailAndPassword($email, $password) {
        $sql = 'SELECT name, email, accountType, password FROM Users WHERE email = ? LIMIT 1';
        $query = $this->db->query($sql, array($email));

        if ($this->db->affected_rows() > 0) {
            // Verifying user password
            $this->load->helper('phppass');
            $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
            $checkPassword = $hasher->CheckPassword($password, $query->row()->password);

            // Check for password equality
            if ($checkPassword == 1) {
                return $query->row();
            }
            else {
                return null;
            }
        }
        else {
            return null;
        }
    }

    function isUserExisted($email) {
        $sql = 'SELECT email FROM Users WHERE email = ?';
        $query = $this->db->query($sql, array($email));

        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function storeUser($name, $email, $accountType, $password)
    {
        $this->load->helper('phppass');
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        $hash_password = $hasher->HashPassword($password);

        $data = array(
            'name'          => $name,
            'email'         => $email,
            'accountType'   => $accountType,
            'password'      => $hash_password
        );
        $this->db->insert('Users', $data);

        return ($this->db->affected_rows() > 0) ? true : false;
    }

}