<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
function isAdmin():void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}

function isAuth():void{
    if(!$_SESSION['login']){
        header('Location:/');
    }
}