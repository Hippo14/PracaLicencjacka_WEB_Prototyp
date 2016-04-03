<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2016-04-03
 * Time: 15:10
 */

class User extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getUserByEmailAndPassword($email, $password) {
        $sql = 'SELECT name, email, accountTypeID, password FROM Users WHERE email = ? LIMIT 1';
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

    function getUserIDByEmail($email) {
        $sql = 'SELECT id FROM Users WHERE email = ? LIMIT 1';
        $query = $this->db->query($sql, array($email));

        return ($this->db->affected_rows() > 0) ? $query->row()->id : false;
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
            'name'            => $name,
            'email'           => $email,
            'accountTypeID'   => $accountType,
            'password'        => $hash_password
        );
        $this->db->insert('Users', $data);

        return ($this->db->affected_rows() > 0) ? true : false;
    }

}