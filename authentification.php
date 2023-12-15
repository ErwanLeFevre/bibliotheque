
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>authentification</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
<form method="POST" action="accueil.php">
        Identifiant</br> <input type="text" name="id"></br>
        Mot de passe</br> <input type="password" name="mdp"></br>
        <input type="submit" name="ok" value="ok">
</form>
</body>
<?php
if (isset($_REQUEST["ok"])){ 
    try{
        require_once("connexion.php");
        $id = $_REQUEST["id"];
        $_SESSION["id"] = $id;
        $mdp = $_REQUEST["mdp"];
        $_SESSION["mdp"] = $mdp;

        $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE mel=$id and motdepasse=$mdp");
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        while($enregistrements = $stmt->fetch())
        {
            echo "<p> $enregistrements->profil  </p>";
        }
    }catch (Exception $e) {     
        echo $e->getMessage();     
        die();
    }
}

?>
</html>