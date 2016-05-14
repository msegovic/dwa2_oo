<?php

class Tag {
    public $id;
    public $naziv;
    public $klikova;
    
    public function __construct($row) {
        $this->id = $row['id'];
        $this->naziv = $row['naziv'];
        $this->klikova = $row['klikova'];
    }
}
