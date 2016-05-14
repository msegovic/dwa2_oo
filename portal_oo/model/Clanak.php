<?php
class Clanak {
    public $id;
    public $naslov;
    public $vk_autora;
    public $vk_kategorije;
    public $datum;
    public $objavljen;
    public $uvod;
    public $tekst;
    public $pogledi;
    public $suma_ocjena;
    public $broj_ocjena;
    public $kom_ur;
    public $vk_kom_ur;
    
    public function __construct($row) {
        $this->id = $row['id'];
        $this->naslov = $row['naslov'];
        $this->vk_autora = $row['vk_autora'];
        $this->vk_kategorije = $row['vk_kategorije'];
        $this->datum = $row['datum'];
        $this->objavljen = $row['objavljen'];
        $this->uvod = $row['uvod'];
        $this->tekst = $row['tekst'];
        $this->pogledi = $row['pogledi'];
        $this->suma_ocjena = $row['suma_ocjena'];
        $this->broj_ocjena = $row['broj_ocjena'];
        $this->kom_ur = $row['kom_ur'];
        $this->vk_kom_ur = $row['vk_kom_ur'];
    }
}
