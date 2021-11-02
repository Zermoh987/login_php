<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FORMULAIRE</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
        <?php
            require('config.php');
            require_once('function.php');

            $nomErr = $emailErr = $prenomErr =  $passwordErr = "";
            $nom = $email = $prenom =  $password = "";

            if(isset($_POST['valider'])){
                
                if (empty($_POST["nom"]) && empty($_POST["prenom"]) && empty($_POST["email"]) && empty($_POST["passe"])) {
                    $nomErr = "* veuillez entrer votre nom";
                    $prenomErr = "* veuillez entrer votre prénom";
                    $emailErr = "* veuillez entrer votre e-mail";
                    $passwordErr  = "* veuillez entrer votre mot de passe";
                } else { 
                    $nom = test_input($_POST["nom"]);
                    $prenom = test_input($_POST["prenom"]);
                    $email = test_input($_POST["email"]);
                    $password = test_input($_POST["passe"]);

                //On insère les données reçues
                    if(preg_match("/[a-zA-Z0-9]/", $password) && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[a-zA-Z-' ]*$/",$prenom) && preg_match("/^[a-zA-Z-' ]*$/",$nom)){
                        
                        $sql = "SELECT * FROM utilisateu WHERE email = '$email'";
                        $result = $dbco->prepare($sql);
                        $result->execute();
                        $data = $result->fetchAll();

                        $sqls = "SELECT * FROM administrateur WHERE email = '$email'";
                        $result = $dbco->prepare($sqls);
                        $result->execute();
                        $data = $result->fetchAll();

                        if ($data) {
                            $emailErr = "Cette adresse email est déjà utilisé";
                        }else {
                            try{
                                $sth = $dbco->prepare("INSERT INTO utilisateu(nom,prenom,email,passe) VALUES(:nom,:prenom,:email,:passe)");
                                $sth->bindParam(':nom',$nom);
                                $sth->bindParam(':prenom',$prenom);
                                $sth->bindParam(':email',$email);
                                $sth->bindParam(':passe',$password);
                                $sth->execute();
                            }catch(PDOException $e){
                                $e="erreur";
                            }
                            header('location:login.php'); 
                        }
                    }else {
                        $nomErr = "Seules les lettres et les espaces blancs sont autorisés";
                        $prenomErr = "Seules les lettres et les espaces blancs sont autorisés";
                        $emailErr = "Format d'email invalide";
                        $passwordErr  = "* veuillez entrer";
                    }
                }     
            }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 m-auto mt-4 mb-4 rounded p-3 mt-2 border border-1">
                    
                    <form action="" method="post">
                        <h2>Cr&eacute;er un compte</h2>
                        <div class="form-group ">
                        <div class="mb-2">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" placeholder="Entrer votre nom">
                                <span class="error"><?php echo $nomErr;?></span>
                            </div>

                            <div class="mb-2">
                                <label for="prenom" class="form-label">Prenom</label>
                                <input type="text" name="prenom" class="form-control" placeholder="Entrer votre prenom" require>
                                <span class="error"><?php echo $prenomErr;?></span>
                            </div>

                            <div class="mb-2">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" name="email" class="form-control" placeholder="Entrer votre email" require>
                                <span class="error"><?php echo $emailErr;?></span>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" name="passe" class="form-control" placeholder="Entrer votre mot de passe " require>
                                <small>Les mots de passe doivent comporter au moins 8 caractères</small><br>
                                <span class="error"><?php echo $passwordErr;?></span>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox" class="form-check-input" name="afficher">
                                <label for="" class="ms-2">Afficher le mot de passe</label>
                            </div>
                            <input type="submit" class="btn btn-primary form-control mb-3" value="Cr&eacute;er un compte moz" name="valider" href='mail.php'>
                        </div>
                        <small>
                            <p>En créant un compte, vous acceptez les <a href="">Conditions
                            d'utilisation</a> et l' <a href="">Avis de confidentialité</a> de Moz .</p>

                            <p>Vous avez déjà un compte? <a href="login.php">S'identifier</a></p>
                        </small>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>