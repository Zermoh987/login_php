<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php

    require('config.php');
    //update
    $id = $_GET['id'];
    $sql = 'SELECT * FROM utilisateu WHERE id=:id';
    $statement = $dbco->prepare($sql);
    $statement->execute([':id' => $id ]);
    $person = $statement->fetch(PDO::FETCH_OBJ);
    $succes = "";
    
    if(isset($_POST['modifier'])){
        if (isset ($_POST['nom'])  && isset($_POST['prenom'])  && isset($_POST['email'])  && isset($_POST['passe']) ) 
        {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['passe'];
            $sql = 'UPDATE utilisateu SET nom=:nom, prenom=:prenom, email=:email, passe=:passe WHERE id=:id';
            $statement = $dbco->prepare($sql);
            if ($statement->execute([':nom' => $nom,':prenom' => $prenom,':email' => $email,':passe' => $password,':id' => $id])) 
            {
              $succes = 'modifier avec succes';
            }
            else{
                echo('probleme lors de lajout');
            }
        }
    }
 ?>

<div class="container-fluid mt-4">
    <div class="shadow-sm p-3 mb-5 bg-ligth rounded dashboard-title">
        <span><a href="Dashboard.php">Dashboard</a></span>
    </div>
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form method="POST">
              <?php 
                if (!empty($succes)) { ?>
                  <p class="alert alert-success"><?php echo $succes; ?></p>
              <?php  }?>
              <div class="form-group">
                <label for="name">Nom</label>
                <input value="<?= $person->nom; ?>" type="text" name="nom" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Prénoms</label>
                <input type="text" value="<?= $person->prenom; ?>" name="prenom" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="<?= $person->email; ?>" name="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Mot de passe</label>
                <input type="text" value="<?= $person->passe; ?>" name="passe"  class="form-control">
              </div>       
              <div class="form-group">
                <button type="submit" class="btn btn-info" name="modifier">Mettre à jour</button>
                <button class="btn btn-secondary"><a href="dashboard.php">Annuler</a></button>
              </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>