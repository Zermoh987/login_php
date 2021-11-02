<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMILAIRE</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>

    </style>
</head>
<body>
<?php
   
    // session_start();
    require_once('config.php');
    require_once('function.php');

    if (isset($_POST['valide'])) {
        $email =test_input($_POST['email']);
        $password =test_input($_POST['passe']);

        $req = "SELECT * FROM administrateur where email = '$email' AND passe = '$password'";
        $result = $dbco->query($req);
        $data = $result->fetch();
        if($data){
            $_SESSION['email'] = $data['email'];
            header('location:dashboard.php');
        }else{
            $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        }

        $sql = "SELECT * FROM utilisateu where email = '$email' AND passe = '$password'";
        $result = $dbco->query($sql);
        $data = $result->fetch();
        if($data){
            $_SESSION['email'] = $data['email'];
            header('location:dashboard1.php');
        }else{
            $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        }
    } 
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 m-auto"> 
                <form action="" method="post" class=" mt-2" name="connecter">
                    <div class="form-group border border-1 rounded p-3 mb-4">
                        <h2>S'identifier</h2>
                        <?php if (!empty($message)) { ?>
                            <p class="alert alert-danger"><?php echo $message; ?></p>
                        <?php } ?>
                        <div class="mb-2 mt-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" name="email" class="form-control" placeholder="Entrer votre email">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="passe" class="form-control" placeholder="Entrer votre mot de passe ">
                        </div>
                        <button type="submit" class="btn btn-primary form-control mb-3" name="valide">Se connecter</button>
                        <small>
                            <p>En continuant, vous acceptez les <a href="">Conditions
                            d'utilisation</a> et l' <a href="">Avis de confidentialité</a> de Moz .</p>
                        </small>
                    </div>
        
                    <small><p class="text-center">Nouveau sur Moz ?</p></small>
                    <a href="register.php" class="btn form-control" style="background-color: rgb(235, 231, 231);">Cr&eacute;er un compte moz</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>