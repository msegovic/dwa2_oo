<?php
class Korisnik {
    public $id;
    public $ime;
    public $prezime;
    public $username;
    public $password;
    public $vk_tip;
    
    public function __construct() {
        $this->id = $row['id'];
        $this->ime = $row['ime'];
        $this->prezime = $row['prezime'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->vk_tip = $row['vk_tip'];
    }
}
