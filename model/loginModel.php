<?php

namespace App\Model;

class LoginModel extends BasicModel
{
    public function login($login, $pass)
    {
        // execute read method
        // is user with this username and password exists
        // return true
        // else return false

        $login_query = "SELECT * FROM `users` WHERE `nick` = ? AND `password` = ?";

        $stmt = $this->read($login_query, [$login, $pass]);

        if ($stmt->fetchAll()) {
            return true;
        } else {
            return false;
        }
    }
}
