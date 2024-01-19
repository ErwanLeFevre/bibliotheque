<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Ajouter un membre</title>
</head>
<body>
    <?php
        if(!$_SESSION["adminUser"] || !isset($_SESSION["adminUser"])) {
            echo "Accès non autorisé."; // Refuse l'accès un utilisateur si il n'est pas autorisé
            exit;
        }
        require("entete-admin.html");// Appel la page entete-admin.html
        ?>

        <div class="container-sm "><!-- Ouverture du contenaire -->
        <?php
        require("authentification.php");// Appel la page authentification.php
        if(isset($_POST["email"])){// Affectation des valeur pour ajouter un livre à des variables
            $email = $_POST["email"];
            $mdp = $_POST["mdp"];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $adresse = $_POST["adresse"];
            $ville = $_POST["ville"];
            $codepostal = $_POST["codePostal"];

           try {
                $req = $connexion->prepare("INSERT INTO utilisateur(mel,motdepasse,nom,prenom,adresse,ville,codepostal,profil) VALUES(:email, :mdp, :nom, :prenom, :adresse, :ville, :codepostal, 'client')");

                $req->bindValue(":email", $email);
                $req->bindValue(":mdp", $mdp);
                $req->bindValue(":nom", $nom);
                $req->bindValue(":prenom", $prenom);
                $req->bindValue(":adresse", $adresse);
                $req->bindValue(":ville", $ville);
                $req->bindValue(":codepostal", $codepostal, PDO::PARAM_INT);

                $req->execute();
                $ajout_membre = TRUE;
           } catch(Exception $e) {
                $erreur = $e;
                $ajout_membre = FALSE;
           }          
        }
    ?>
        <h1>Ajouter un membre</h1>

        <form method="post" action="ajouter_membre.php"><!-- Formulaire d'entrée -->
            <div class=row>
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" autocomplete="off" required>
            </div>
            <div class=row>
            <label for="mdp">Mot de passe : </label>
            <input type="password" name="mdp" id="mdp" autocomplete="off" required>
            </div>
            <div class=row>            
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" autocomplete="off" required>
            </div>
            <div class=row>            
            <label for="prenom">Prenom : </label>
            <input type="text" name="prenom" id="prenom" autocomplete="off" required>
            </div>
            <div class=row>
            <label for="adresse">Adresse : </label>
            <input type="text" name="adresse" id="adresse" autocomplete="off" required>
            </div>
            <div class=row>
            <label for="ville">Ville : </label>
            <input type="text" name="ville" id="ville" autocomplete="off" required>
            </div>
            <div class=row>
            <label for="codePostal">Code Postal : </label>
            <input type="number" name="codePostal" id="codePostal" min="1" max="100000" autocomplete="off" required>
            </div>
            <div class=row>
            <input type="submit" value="Créer un membre" class="btn btn-primary">
            </div>
            <?php 
                if(isset($ajout_membre)) { // Vérification de l'ajout du nouveau membre
                    if ($ajout_membre) 
                        echo '<p class="ajout_succes">Membre ajouté avec succès !</p>';
                }
            ?>

        </form>
        </div>
        

</body>
</html>