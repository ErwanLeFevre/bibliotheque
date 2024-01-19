
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bibliodrive - Accueil</title>
</head>
<body>
<?php require_once('connexion.php')?>

<div class="container-xl">
    <div class="mt-1 p-3 bg-dark text-white rounded">
    <?php
        // Initialisation des variables de sessions.
        if(!isset($_SESSION["connected"])){
            $_SESSION["connected"] = FALSE;
            $_SESSION["adminUser"] = FALSE;
        }

        // Vérifier les identifiants renseignés.
        if(isset($_POST["email"])) {
            $requete = $connexion->prepare("SELECT profil FROM utilisateur WHERE mel = :email AND motdepasse = :mdp");
            $requete->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $requete->bindValue(":mdp", $_POST["mdp"], PDO::PARAM_STR);
            $requete->execute();
            $requete->setFetchMode(PDO::FETCH_OBJ);  
            
            $utilisateur = $requete->fetch();

            if($utilisateur) { // Vérifie si l'utilisateur est connecté
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["connected"] = TRUE; 
                $_SESSION["panier"] = array();
                if($utilisateur->profil == "admin") $_SESSION["adminUser"] = TRUE; //Si l'utilisateur est un admin, attribuer le role admin.
            }
            else{ // Sinon, on fait en sorte de lui faire savoir que son mail ou mdp est mauvais.
                $erreur_connexion = TRUE;
                $email_renseigne = $_POST["email"];
            }

        }
        // Déconnection de l'utilisateur
        if(isset($_POST["logoff"])) {
            $_SESSION["connected"] = FALSE;
            unset($_SESSION["email"]);
            unset($_SESSION["panier"]);
            
            if($_SESSION["adminUser"]) { // Si l'utilisateur est un admin, on le redirige dans la page d'accueil pour éviter tout conflit.
                $_SESSION["adminUser"] = FALSE;
                header("Location: accueil.php");
                exit;
            }
                
        }

        // Vérifier si l'utilisateur authentifié.
        echo '<div class="col-md-12">';
        if($_SESSION["connected"]){
            $requete = $connexion->prepare("SELECT mel,nom,prenom,adresse,profil FROM utilisateur WHERE mel = :email");
            $requete->bindValue(":email", $_SESSION["email"], PDO::PARAM_STR);
            $requete->execute();
            $requete->setFetchMode(PDO::FETCH_OBJ);
            $utilisateur = $requete->fetch();
            echo '<div class="mt-1 p-1 bg-danger text-white rounded">';
                echo '<p> Bonjour '.$utilisateur->nom.' '.$utilisateur->prenom.'</p>';
                if($utilisateur->profil == "client"){
                    echo '<p>'.$utilisateur->adresse.'</p>';
                } else {
                    echo '<p>Vous êtes Administrateur</p>';
                }
            echo '</div>';
            echo '<div class=row>';
                echo '
                    <form method="post" class="form-login">
                        <input type="hidden" name = "logoff" value = "true">
                        <input class="submit-login btn btn-primary" type="submit" value="Se déconnecter">
                    </form>';
            echo '</div>';
            
        } else {
            echo '<div class="mt-1 p-1 bg-danger text-white rounded">';
                echo '<p ">Connexion</p>';
                echo '<form method="post" class="form-login">';
                if(isset($email_renseigne)) // Pour éviter que l'utilisateur retape sans cesse son email en cas d'echec
                    echo '<input type="email" name="email" id="email" placeholder="Email" autocomplete="off" value="'.$email_renseigne.'"required>';
                else 
                    echo '<input type="email" name="email" id="email" placeholder="Email" autocomplete="off" required>'; 
                echo '<input type="password" name="mdp" id="mdp" placeholder="Mot de passe" autocomplete="off" required>';
                if(isset($erreur_connexion)) echo '<p class="erreur-connexion">Votre email ou mot de passe est incorrect.</p>';// Renvois un erreuur si le mail est incorrecte
                echo '</div>';  
                echo '<div class=row>'; 
                echo '<input class="submit-login btn btn-primary" type="submit" value="Se connecter">';
                echo '</div>
            </form>';        
        }  
        echo '</div>'; 
    ?>
    </div>
    
</div>    
</body>
</html>
