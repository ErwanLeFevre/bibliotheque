
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Detail</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
    <?php
    
    require_once('connexion.php');
    if(isset($_POST["ajout_panier"])){
        echo "rest post";
        $_POST = array(); 
    }

    if(!isset($_GET["livre"])) {
        echo '<h1 class="big-title">Aucun livre renseigné.</h1>.';
        exit;
    }
    else {
        $req = $connexion->prepare("SELECT nom,prenom,isbn13,resume,image FROM livreINNER JOIN auteur ON livre.noauteur = auteur.noauteurWHERE nolivre = :nolivre;");

        $req->bindValue(":nolivre", $_GET["livre"], PDO::PARAM_INT);

        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();
        $info_livre = $req->fetch();
    }
?>



<div class="resume-container">
    <div>
        <p><b>Auteur:</b> <?php echo $info_livre->nom . " " . $info_livre->prenom ;?></p>
        <p><b>ISBN13:</b> <?php echo $info_livre->isbn13;?></p>
        <p class="titre-resume">Résumé du livre</p>
        <div class="bloc-resume">
            <?php echo $info_livre->resume;?>
        </div>
        <div class="info-commande">
            <?php
                $req = $connexion->prepare("SELECT nolivre FROM emprunterWHERE nolivre = :nolivre;");
    
                $req->bindValue(":nolivre", $_GET["livre"], PDO::PARAM_INT);
    
                $req->setFetchMode(PDO::FETCH_OBJ);
                $req->execute();
                $emprute = $req->fetch();

                if($emprute){
                    echo '<p class="order-unavailable">Indisponible</p>';
                } else {
                    echo '<p class="order-available">Disponible</p>';
                }
            
            
            ?>

            <form method="post" action="panier.php">
                <?php
                    if($_SESSION["connected"]){
                        if(in_array($_GET["livre"],$_SESSION["panier"])){
                            echo "<p>Déjà dans votre panier.</p>";
                        } else {
                            echo '<input type="hidden" name="ajout_panier" value="true">';
                            echo '<input type="hidden" name="nolivre" value="'.$_GET["livre"].'">';
                            echo '<input type="submit" value="Ajouter au panier" class="button-general ajout-panier">';
                        }

                    } else {
                        echo "<p>Connectez vous pour ajouter à votre panier.</p>";
                    }
                ?>
            </form>
        </div>
    </div>
    <div>
        <?php
            if(file_exists("images/bibliotheque.jpg".$info_livre->image)){
                $cover = $info_livre->image;
            } else {
                $cover = "book-cover-placeholder.png";
            }
        ?>
        <img src="images/covers/<?php echo $cover?>" alt="Book cover" class="book-cover-img">
    </div>
</div>
</body>
</html>