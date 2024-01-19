<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Recherche Livre</title>
</head>
<body>
<div class="container-xl"><!-- Ouverture du contenaire -->
        <div class="col-md-12">
            <div class=row>
                <?php include 'entete.html';// Appel la page entete.html?>
            </div>
            <div class=row>
            <div class="col-sm-1"></div>
                <div class="col-sm-6">
                    <div class=row>
                        <h2>
                        <?php
                        if(isset($_GET["auteur"])) {// Vérifie si un auteur est bien renseigné
                            $auteur = $_GET["auteur"];//oui
                            echo "Recherche pour " . $auteur;
                        } else {
                            echo "Aucun auteur renseigné.";//non
                        } 
                        ?>
                        </h2>
                    </div>
                    <div class=row>
                        <?php
                        require_once("connexion.php"); // Appel de la page connexion.php pour ce connecter à la bdd
                        $req = $connexion->prepare("SELECT nolivre,titre FROM livre INNER JOIN auteur ON livre.noauteur = auteur.noauteur WHERE nom = :auteur;");
                        $req->bindValue(":auteur", $auteur);
                        $req->setFetchMode(PDO::FETCH_OBJ);
                        $req->execute();
                        if($req->rowCount() == 0) { // Vérification que le nom de l'auteur renvois un résultat
                            echo "<p>Aucun Résultat.</p>"; //non
                        } else { //oui
                            while($livre = $req->fetch()) { // Affichage des livres
                                echo '<div class=row>';
                                echo '<a href="detail.php?livre='.$livre->nolivre.'"><button class="btn btn-primary">'.$livre->titre.'</button></a>';
                                echo '</div>';
                            }
                        }
                    ?>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-4">
                    <?php 
                    include("authentification.php"); // Appel de la page authetification.php
                    ?>   
                    </div>
                </div>
            </div>
        
    </div>

    


    


</body>
</html>