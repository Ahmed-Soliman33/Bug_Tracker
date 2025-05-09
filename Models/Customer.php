<?php

require_once 'User.php';

class Customer extends User
{
    public function __construct($name, $email, $password, $role)
    {
        parent::__construct($name, $email, $password, $role);
    }
}
?>