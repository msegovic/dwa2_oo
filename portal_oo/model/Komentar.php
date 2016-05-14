<?php
class Komentar {
    public $id;
    public $vk_clanka;
    public $tekst;
    public $username;
    public $datum_unosa;
    public $up;
    public $down;
    
    public function __construct($row) {
        $this->id = $row['id'];
        $this->vk_clanka = $row['vk_clanka'];
        $this->tekst = $row['tekst'];
        $this->username = $row['username'];
        $this->datum_unosa = $row['datum_unosa'];
        $this->up = $row['up'];
        $this->down = $row['down'];
    }
}
