<?php

function connexpdo($base,$user,$password){
    try {
        $db = new PDO($base, $user, $password);
        return $db;
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }

}