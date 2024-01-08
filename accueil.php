<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Accueil</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body>
        <div class="container-xl">
            <div class=row.bg-danger>
                La Bibliothèque de Moulinsart est fermé au public jusqu'à nouvel ordre. Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !
            </div>
            <div class=row>
                <?php include 'entete.html';?>
            </div>
            <div class=row>
                <div class="col-sm-1"></div>
                <div class="col-sm-6">
                    <div class=row>
                        <h4>Dernière acquisitions</h4>
                    </div>
                    <div class=row>
                        <?php include 'carousel.html';?>
                    </div>
                    <div class=row>
                        <?php include 'detail.php';?>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-4">
                    <?php include 'authentification.php';?>   
                </div>
            </div>
        </div>
    </body>
</html>   
