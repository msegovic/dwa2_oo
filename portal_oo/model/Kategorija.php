<?php
class Kategorija {
    public $id;
    public $naslov;
    public $objavljen;
    
    public function __construct($row) {
        $this->id = $row['id'];
        $this->naslov = $row['naslov'];
        $this->objavljen = $row['objavljen'];
    }
}
