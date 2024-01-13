<?php

class User
{
    private $id;
    private $full_name;
    private $email;
    private $username;
    private $password;
    private $date_of_birth;

    // Constructor to initialize user properties
    public function __construct($id, $full_name, $email, $username, $password, $date_of_birth)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->date_of_birth = $date_of_birth;
    }

    // Getter methods for accessing private properties
    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->full_name;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function get_date_of_birth()
    {
        return $this->date_of_birth;
    }
    // Setter methods for updating private properties
    public function set_name($full_name)
    {
        $this->full_name = $full_name;
    }

    public function set_password($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function set_date_of_birth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;
    }
}
