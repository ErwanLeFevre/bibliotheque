<?php
    try {
        $dns = 'mysql:host=localhost;dbname=bibliodrive'; // selection de la base de donnée
        $utilisateur = 'root'; // root sur vos postes
        $motDePasse = ''; // pas de mot de passe sur vos postes
        $connexion = new PDO( $dns, $utilisateur, $motDePasse );
    } catch (Exception $e) { // Message si erreur de connexion
        echo "Connexion à la base de donnée bibliodrive impossible : ", $e->getMessage();
        die();
    }






?>