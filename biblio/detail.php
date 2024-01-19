<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Détail</title>
</head>
<body>
    <?php
        require_once('connexion.php');// Appel la page connexion.php pour avoir accès à la base de donnée
        if(isset($_POST["ajout_panier"])){
            echo "rest post";
            $_POST = array(); 
        }
        require("entete.html"); // Appel la page entete.html
        ?>
    <div class="container-sm"><!-- Ouverture du contenaire -->
        <?php
            echo'<div class="row">';
                require("authentification.php");// Appel la page authentification.php
            echo'</div>';

            if(!isset($_GET["livre"])) { // Vérifie si un livre est renseigné
                echo '<h1">Aucun livre renseigné.</h1>.'; // Message d'erreur
                exit;
            }
            else { // Affectation des données du livre selectionner depuis la bdd dans une variable
                $req = $connexion->prepare("SELECT nom,prenom,isbn13,resume,image FROM livre INNER JOIN auteur ON livre.noauteur = auteur.noauteur WHERE nolivre = :nolivre;");
                $req->bindValue(":nolivre", $_GET["livre"], PDO::PARAM_INT);
                $req->setFetchMode(PDO::FETCH_OBJ);
                $req->execute();
                $info_livre = $req->fetch();
            }
        ?>
        <div class="row"> <!-- Affichage des données du livre -->
            <div class="col-sm-8">
                <p><b>Auteur:</b> <?php echo $info_livre->nom . " " . $info_livre->prenom ;?></p>
                <p><b>ISBN13:</b> <?php echo $info_livre->isbn13;?></p>
                <p><b>Résumé du livre:</b></p>
                <?php echo $info_livre->resume;?>
                <div>
                    <?php
                    $req = $connexion->prepare("SELECT nolivre FROM emprunter WHERE nolivre = :nolivre;");
                    $req->bindValue(":nolivre", $_GET["livre"], PDO::PARAM_INT);
                    $req->setFetchMode(PDO::FETCH_OBJ);
                    $req->execute();
                    $emprute = $req->fetch();
                    if($emprute){
                        echo '<p>Indisponible</p>';
                    } else {
                        echo '<p">Disponible</p>';
                    }                            
                    ?>
                    <!-- Ajouter un livre au panier ? -->
                    <form method="post" action="panier.php">
                        <?php
                        if($_SESSION["connected"]){
                            if(in_array($_GET["livre"],$_SESSION["panier"])){
                                echo "<p>Déjà dans votre panier.</p>"; // Informe l'utilisateur que le livre est déjà présent dans le panier
                            } else { // Affiche un boutton qui permet d'ajouter le livre dans le panier
                                echo '<input type="hidden" name="ajout_panier" value="true">'; 
                                echo '<input type="hidden" name="nolivre" value="'.$_GET["livre"].'">';
                                echo '<input type="submit" value="Ajouter au panier" class="btn btn-primary">';
                            }

                        } else {
                            echo "<p>Connectez vous pour ajouter à votre panier.</p>"; // Informe l'utilisateur qu'il doit être connecté pour ajouter un livre au panier
                        }
                        ?>
                    </form>
                </div>
            </div>    
            <div class="col-sm-4">
                <?php
                if(file_exists("images/covers/".$info_livre->image)){ // Affichage de l'image correspondant au livre selectionné
                    $cover = $info_livre->image;
                }
                ?>
                <img src="images/covers/<?php echo $cover?>" alt="Couverture de Livre" height=500em>
            </div>
        </div>
 
    </div>   
</body>
</html>

