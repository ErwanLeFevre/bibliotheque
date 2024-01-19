<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Panier</title>
</head>
<body>
    <?php
        require_once('connexion.php');
        require("entete.html");
        if($_SESSION["connected"]){
            if(isset($_POST["ajout_panier"])){
                if(!in_array($_POST["nolivre"], $_SESSION["panier"])){
                    array_push($_SESSION["panier"], $_POST["nolivre"]);
                }
            }
        }
    ?>
    <div class="container-sm ">
        <div class="col-sm-6">
            <?php
            require("authentification.php");
            ?>
            <h1>Votre panier</h1>
            <?php
            if(!isset($_SESSION["panier"])){
                echo "Vous n'êtes pas connecté. Connectez-vous pour ajouter des livres dans votre panier.";
            } else {
                if(count($_SESSION["panier"]) > 0){
                    foreach($_SESSION["panier"] as $livre){
                        $req = $connexion->prepare("SELECT nolivre, nom, prenom, titre, anneeparution FROM livre JOIN auteur ON livre.noauteur = auteur.noauteur WHERE nolivre = :nolivre;");
                        $req->bindValue(":nolivre", $livre, PDO::PARAM_INT);
                        $req->setFetchMode(PDO::FETCH_OBJ);
                        $req->execute();
                        while($panier_info = $req->fetch()){
                            echo '<div class="panier-info">';
                            echo "<p>".$panier_info->nom." ".$panier_info->prenom." - ".$panier_info->titre." (".$panier_info->anneeparution.")</p>";
                            echo '<a href="retirer=true&nolivre='.$panier_info->nolivre.'&redirect=panier.php" class="btn btn-primary">Annuler</a>';
                            echo '</div>';
                        }
                    }
                    echo '<form method="post">';
                    echo '<input type="hidden" name="emprunt_livre" value="true">';
                    echo '<input type="submit" value="Valider le panier" class="btn btn-primary">';
                    echo '</form>';
                } else {
                    echo "<p>Vous n'avez rien dans votre panier !</p>";
                }
            

            }
        ?>
        </div>
        
    </div> 
</body>
</html>