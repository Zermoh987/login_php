<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMILAIRE</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<?php
    require_once('config.php');
    if (isset($_SESSION['email'])) 
    {
       echo "vous être connectée en tant que : " . $_SESSION['email'];
    }else {
        ?>
        <div class="container">
        <div class="row">
            <div class="col-lg-4 m-auto"> 
                <form action="login.php" method="POST" class=" mt-2" name="connecter">
                    <div class="form-group border border-1 rounded p-3 mb-4">
                        <h2>S'identifier</h2>
                        <div class="mb-2 mt-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" name="email" class="form-control" placeholder="Entrer votre email">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="passe" class="form-control" placeholder="Entrer votre mot de passe ">
                        </div>
                        <button class="btn btn-primary form-control mb-3" name = "valide">Se connecter</button>
                        <small>
                            <p>En continuant, vous acceptez les <a href="">Conditions
                            d'utilisation</a> et l' <a href="">Avis de confidentialité</a> de Moz .</p>
                        </small>
                    </div>
        
                    <small><p class="text-center">Nouveau sur Moz ?</p></small>
                    <a href="formulaire.php" class="btn  form-control" style="background-color: rgb(235, 231, 231);">Cr&eacute;er un compte moz</a>
                </form>
            </div>
        </div>
    </div>
    <?php
    }
?>
</body>
</html>