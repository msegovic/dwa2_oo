﻿<?php require('admin/db.php'); $c = db();
/*
 * GLAVNI SADRZAJ
 * PREMA PARAMETRU a U GET NIZU ODLUCUJEMO STO PRIKAZATI
 */
if(!isset($_GET['a'])) { $a = ''; } else { $a = $_GET['a']; }
$view = 'pregled';
$kategorije = dohvacanjeKategorija();
$tagovi = dohvacanjeTagova();
switch($a){
    case 'kat':   
        $clanci = dohvacanjeClanaka('kat',$_GET['id']); 
        break;
    case 'clanak': 
        $clanak = dohvacanjeJednogClanka(); 
        $komentari = dohvacanjeKomentaraClanka($_GET['id']);
        $view = 'clanak';
        break;
    case 'sortiraj': postaviSortiranje(); break;
    case 'komentar' : unosKomentara(); break;
    case 'tagovi':
        $clanci = dohvacanjeClanaka('tag',$_GET['id']);
        break;
    case 'updown': updown(); break;
    default: 
        $clanci = dohvacanjeClanaka(); 
        //break;
}

function updown(){
    $ocjena = $_GET['o'];
    $id = $_GET['id'];
    $idc = $_GET['idc'];
    if($ocjena == 'u'){
      $q = "UPDATE komentari SET up = up+1 WHERE id = $id";
    }
    elseif($ocjena == 'd'){
      $q = "UPDATE komentari SET down = down+1 WHERE id = $id";
    }
    else{}
    global $c;
    if($q){ 
        $c->query($q); 
        if($c->affected_rows == 1){
            header('Location: ?a=clanak&id='.$idc);          
        }
    }
}

function unosKomentara(){
    $id = $_POST['id'];
    $tekst = $_POST['tekst'];
    $username = $_POST['username'];
    $q = "INSERT INTO komentari(vk_clanka, tekst, username) 
        VALUES($id,'$tekst','$username')";
    global $c;
    $c->query($q);
    if($c->affected_rows==1){
        header('Location: ?a=clanak&id='.$id);
    }else {
        echo $q;
        echo $c->error;
    }
   
}


function dohvacanjeClanaka($nacin='a',$id=0){
    global $c;

    switch($nacin){
        case 'kat': // pripremi upit za ispis clanaka
                    // u kategoriji
             $sql = "SELECT c.id, c.naslov, c.uvod, 
                    DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum,
                    c.pogledi, a.ime, a.prezime, k.naziv, c.vk_autora, 
                    c.suma_ocjena, c.broj_ocjena 
                    FROM clanci c 
                    LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
                    LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
                    WHERE k.id = $id 
                    AND c.objavljen = 1";
            break;
        case 'tag': // pripremi upit za ispis clanaka
                    // po tagu
            $sql = "SELECT c.id, c.naslov, c.uvod, 
                    DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum,
                    c.pogledi, a.ime, a.prezime, k.naziv, c.vk_autora, 
                    c.suma_ocjena, c.broj_ocjena 
                    FROM  clanci c   
                    LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
                    LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
                    LEFT JOIN clanci_tagovi ct ON (c.id = ct.vk_clanka)  
                    WHERE ct.vk_taga = $id";
            break;
        case 'a' : // ovaj upit ispod
         $sql = "SELECT c.id, c.naslov, c.uvod, 
                DATE_FORMAT(c.datum,'%d.%m.%Y u %H:%i') AS datum,
                c.pogledi, a.ime, a.prezime, k.naziv, c.vk_autora, 
                c.suma_ocjena, c.broj_ocjena 
                FROM clanci c 
                LEFT JOIN kategorije k ON (c.vk_kategorije = k.id) 
                LEFT JOIN korisnici a ON (c.vk_autora = a.id) 
                AND c.objavljen = 1";   
    }
if(isset($_COOKIE['kako'])){
    if($_COOKIE['kako']=='vrijeme') { $orderby = 'c.datum'; } else { $orderby = 'c.pogledi'; }
    $sql.=" ORDER BY $orderby DESC";
}
$r = $c->query($sql);
    return $r;
}

function dohvacanjeJednogClanka(){
    global $c;
    $id = $_GET['id'];
    inkrementirajBrojPrikaza($id);
    $sql = "SELECT * FROM clanci WHERE id = $id AND objavljen = 1 LIMIT 1";
    $r = $c->query($sql);
    $row = $r->fetch_assoc();    
    return $row;
}

function dohvacanjeKomentaraClanka($id){
     // 1. ISPIS SVIH KOMENTARA
    global $c;
    $q = "SELECT * FROM komentari WHERE vk_clanka = $id 
            ORDER BY datum_unosa DESC";
    $r = $c->query($q);
    return $r;
}

function inkrementirajBrojPrikaza($id){
    global $c;
    $sql = "UPDATE clanci SET pogledi = pogledi+1 WHERE id = $id";
    $c->query($sql);
}

function postaviSortiranje(){
    $kako = $_GET['kako']; // DOHVATI NACIN SORTIRANJA IZ LINKA
    if(isset($_COOKIE['kako'])){ // AKO JE VEC POSTAVLJEN
       if($_COOKIE['kako']!=$kako){ setcookie('kako', $kako, time()+360000); } // POSTAVLJEN JE, ALI NA DRUGI NACIN SORTIRAJA, POSTAVI NA NOVI NACIN
    }
    else { // INACE, POSTAVI GA
        setcookie('kako', $kako, time()+360000);
    }
    header('Location: '.$_SERVER['SCRIPT_NAME']);
}
function dohvacanjeKategorija(){
    global $c;
    $sql = "SELECT * FROM kategorije";
    $r = $c->query($sql);
    return $r;


}
function dohvacanjeTagova(){
    global $c;
   if(isset($_GET['id'])){
       $id = $_GET['id'];
       $upit = "SELECT t.id, t.naziv 
            FROM tagovi t, clanci_tagovi ct 
            WHERE t.id = ct.vk_taga 
            AND ct.vk_clanka = $id";
        $rT = $c->query($upit);
        return $rT;
   }
   else{
       return false;
   }
}
require_once('view/main.php');
?>
