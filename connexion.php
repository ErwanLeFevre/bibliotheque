<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <?php
    try { 
        $dns = 'mysql:host=localhost;dbname=bibliotheque';   
        $utilisateur = 'root';      
        $motDePasse = '';    
        $connexion = new PDO( $dns, $utilisateur, $motDePasse );
        
      
    } catch (Exception $e) {     
        echo "Connexion à MySQL impossible : ", $e->getMessage();     
        die();
    }  
    ?>
</html>   
