<?php

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $role = "customer";
    public $created_at;



    public function __construct($name, $email, $password, $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }



}

?>