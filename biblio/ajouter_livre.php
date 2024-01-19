<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Ajouter un livre</title>
</head>
<body>
    <!-- Ajout d'un utilisateur -->
    <?php
        if(!$_SESSION["adminUser"] || !isset($_SESSION["adminUser"])) {
            echo "Accès non autorisé."; // Refuse l'accès un utilisateur si il n'est pas autorisé
            exit;
        }
        require("entete-admin.html"); // Appel la page entete-admin.html
        ?>
        <div class="container-sm"> <!-- Ouverture du contenaire -->
            <?php
            require("authentification.php"); // Appel la page authentification.php
            if(isset($_POST["noauteur"])){ // Affectation des valeur pour ajouter un livre à des variables
                $noauteur = $_POST["noauteur"];
                $titre = $_POST["titre"];
                $ISBN13 = $_POST["ISBN13"];
                $annee_parution = $_POST["annee_parution"];
                $resume = $_POST["resume"];
                $cover = $_POST["cover"];
                try {
                    $req = $connexion->prepare("INSERT INTO livre(noauteur, titre, isbn13, anneeparution, resume, dateajout, image) VALUES(:noauteur, :titre, :ISBN13, :annee_parution, :resume, :dateajout, :cover)");
                    $req->bindValue(":noauteur", $noauteur, PDO::PARAM_INT);
                    $req->bindValue(":titre", $titre);
                    $req->bindValue(":ISBN13", $ISBN13);
                    $req->bindValue(":annee_parution", $annee_parution);
                    $req->bindValue(":resume", $resume);
                    $req->bindValue(":dateajout", date("Y-m-d"));
                    $req->bindValue(":cover", $cover);
                    $req->execute();
                    $livre_ajout = TRUE;
                } catch(Exception $e) {
                    $erreur = $e;
                    $livre_ajout = FALSE;
                }   
            }
            ?>
            <h1>Ajouter un livre</h1>
            <form method="post" action="ajouter_livre.php"> <!-- Formulaire d'entrée -->
                <label for="auteur">Auteur : </label><!-- Liste déroulante des noms des Auteurs -->
                <?php
                    echo '"<select name="noauteur" id="auteur" required>"';
                    echo '"<option value="hhh" disabled selected>---- Sélectionner ----</option>"';
                    $req = $connexion->query("SELECT noauteur,nom FROM auteur Order By nom ASC");
                    $req->setFetchMode(PDO::FETCH_OBJ);
                    while($auteur = $req->fetch()){
                        echo "<option value=\"{$auteur->noauteur}\">{$auteur->nom}</option>";
                    }
                    echo "</select>";
                ?>
                <div class=row>
                <label for="titre">Titre : </label>
                <input type="text" name="titre" id="titre" autocomplete="off" required>
                </div>
                <div class=row>
                <label for="ISBN13">ISBN13 :</label>
                <input type="text" name="ISBN13" id="ISBN13" autocomplete="off" required>
                </div>
                <div class=row>
                <label for="annee_parution">Année de parution : </label>
                <input type="text" name="annee_parution" id="annee_parution" autocomplete="off" required>
                </div>
                <div class=row>
                <label for="resume">Résumé : </label>
                <textarea name="resume" id="resume" autocomplete="off" rows="10" required></textarea>     
                </div>
                <div class=row>
                <label for="cover">Image : </label>
                <input type="file" id="cover" name="cover" accept="image/png, image/jpeg" autocomplete="off" required/>
                </div>
                <div class=row>
                <input type="submit" value="Ajouter le livre" class="btn btn-primary">
                </div>
                <?php 
                if(isset($livre_ajout)) {// Vérification de l'ajout du nouveau membre
                    if ($livre_ajout) 
                        echo '<p>Livre ajouté avec succès !</p>';
                    else
                        echo '<p>Une erreur est survenue l\'or de l\'ajout du livre : '. $erreur . '</p>';
                }
                ?>
            </from>
        </div>
    
</body>
</html>