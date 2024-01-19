<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../tarteaucitron/tarteaucitron.js"></script>
    <script>
        tarteaucitron.init({
            "privacyUrl": "", /* URL de la page de la politique de vie privée */
            "hashtag": "#tarteaucitron", /* Ouvrir le panneau contenant ce hashtag */
            "cookieName": "tarteaucitron", /* Nom du Cookie */
            "orientation": "middle", /* Position de la bannière (top - bottom) */
            "showAlertSmall": true, /* Voir la bannière réduite en bas à droite */
            "cookieslist": true, /* Voir la liste des cookies */
            "adblocker": false, /* Voir une alerte si un bloqueur de publicités est détecté */
            "AcceptAllCta": true, /* Voir le bouton accepter tout (quand highPrivacy est à true) */
            "highPrivacy": true, /* Désactiver le consentement automatique : OBLIGATOIRE DANS l'UE */
            "handleBrowserDNTRequest": false, /* Si la protection du suivi du navigateur est activée, tout interdire */
            "removeCredit": false, /* Retirer le lien vers tarteaucitron.js */
            "moreInfoLink": true, /* Afficher le lien "voir plus d'infos" */
            "useExternalCss": false, /* Si false, tarteaucitron.css sera chargé */
            //"cookieDomain": ".my-multisite-domaine.fr", /* Cookie multisite - cas où SOUS DOMAINE */
            "readmoreLink": "/cookiespolicy" /* Lien vers la page "Lire plus" A FAIRE OU PAS  */
        });
        (tarteaucitron.job = tarteaucitron.job || []).push('youtube');
    </script>
    <title>Bibliodrive - Accueil</title>
</head>
<body>
    <div class="container-xl">
        <div class="col-md-12">
            <div class=row>
                <?php 
                if($_SESSION["adminUser"]) include("entete-admin.html");
                else include("entete.html");
                ?>
            </div>
            <div class=row>
                <div class="col-sm-1"></div>
                <div class="col-sm-6">
                    <?php
                    if($_SESSION["adminUser"]){
                        echo '<div class=row>';
                            echo '<h2>Version Administrateur</h2>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class=row>';
                            echo '<h1>Dernier acquisition</h1>';
                        echo '</div>';
                        echo '<div class=row>';
                            require("carousel.html");
                        echo '</div>';
                    }
                    ?>
                    
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-4">
                    <?php 
                    require("authentification.php");
                    ?>   
                    </div>
                </div>
            </div>
    </div>


</body>
</html>
