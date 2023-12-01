<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>authentification</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
<form method="POST" action="test.php">
        Identifiant</br> <input type="text" name="id"></br>
        Mot de passe</br> <input type="text" name="mdp"></br>
        <input type="submit" name="ok" value="ok">
</form>
</body>
<?php
if (isset($_REQUEST["ok"])){ // pour vérifier si la variable est définie
    $id = $_REQUEST["id"];
    $_SESSION["id"] = $id;
    $mdp = $_REQUEST["mdp"];
    $_SESSION["mdp"] = $mdp;
}
?>
</html>