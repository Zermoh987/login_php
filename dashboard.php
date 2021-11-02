<?php
  // Initialiser la session
  session_start();
  if(!isset($_SESSION['email'])){
    header("Location: login.php");
  }
  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
      label{
        display: block;
      }
    </style>
</head>
<body>
    <?php

    $nom_err = $prenom_err = $emailErr = $error_mdp = $enregis = $enregs = "";
    $nom = $email = $prenom =  $password = "";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

        //include('config.php');
        require('config.php');
        //afichage
        $sql = ("SELECT * FROM utilisateu");
        $statement = $dbco->prepare($sql);
        $statement->execute();
        $people = $statement->fetchAll(PDO::FETCH_OBJ);      
        

        if (isset($_POST['valider'])) {

          if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["passe"])) {
            
            $nom = (test_input($_POST["nom"]));
            $prenom = (test_input($_POST["prenom"]));
            $email = (test_input($_POST["email"]));
            $password = (test_input($_POST["passe"]));
          
          }else {
            $enregis="veuillez renseigner tous les champs";
          } 

          if (preg_match("/^[a-zA-Z-' ]*$/",$nom) && preg_match("/^[a-zA-Z-' ]*$/",$prenom) && filter_var($email, FILTER_VALIDATE_EMAIL)  ) {
            $sql = "SELECT * FROM utilisateu where email = '$email'";
            $result = $dbco->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            if ($data) {
                $enregis = "Cette adresse email est déjà utilisé";
            }else{
              try{
                  $req = $dbco->prepare("INSERT INTO utilisateu(nom,prenom,email,passe)
                  VALUES(:nom,:prenom,:email,:passe)");
                  $req->bindParam(':nom',$nom);
                  $req->bindParam(':prenom',$prenom);
                  $req->bindParam(':email',$email);
                  $req->bindParam(':passe',$password);

                $req->execute();
                //On renvoie l'utilisateur vers la page de remerciement
                header('location:dashboard.php');
              }catch(PDOException $e){
                $enregis="erreur";
              }
            }  
          }
        }
    ?>

<div class="wrapper">

    <!--menu de navigation-->
        
    <!--shadow-->
    <div class="shadow-sm p-3 mb-5 bg-white rounded dashboard-title">
        <span>Dashboard</span>
        <a href="logout.php" class="float-right">Déconnexion</a>
    </div>
    <?php if(!empty($enregis)): ?>
                <div class="alert alert-danger">
                    <?= $enregis; ?>
                </div>
                <?php endif; ?>
<button class="btn"><a href="#ajoutereleves" data-toggle="modal">Ajouter un utilisateur</a></button>
    <div class="container-fluid">
        <!--tableau eleves inscrit-->
        <div class="table-responsive text-center">
            <table class="table table-striped">
                <tr >
                    <th scope="col">Nom</th>
                    <th scope="col">Prénoms</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mot de passe</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>

                <?php foreach($people as $person): ?>

                <tr>
                    <td><?= $person->nom; ?></td>
                    <td><?= $person->prenom; ?></td>
                    <td><?= $person->email; ?></td>
                    <td><?= $person->passe; ?></td>
                    <td><?= $person->date; ?></td>
                    <td>
                    <a href="editer.php?id=<?= $person->id ?>" class="btn btn-info">Modifier</a>
                        <a onclick="return confirm('Êtes vous sûr de vouloir supprimer ?')" href="delete.php?id=<?= $person->id ?>" class='btn btn-danger'>Supprimer</a>
                    </td>
                </tr>

                <?php endforeach; ?>
            </table>
               
        </div>
    </div>

    <!-- ajouter Modal HTML -->
	<div id="ajoutereleves" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
          <div class="row">
            <div class="col-lg-6 m-auto">
              <form action="" method="POST">
                  <div class="form-group">
                      <label>Nom</label>
                      <input type="text" class="form-control" placeholder="Entrer votre nom" name="nom">
                      <span class="error"><?php echo $nom_err;?></span>
                  </div>
                  <div class="form-group">
                      <label>Prénoms</label>
                      <input type="text" class="form-control" placeholder="Entrer votre prénoms" name="prenom">
                      <span class="error"><?php echo $prenom_err;?></span>
                  </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" placeholder="Entrer votre Email" name="email">
                      <span class="error"><?php echo $emailErr;?></span>
                  </div>
                  <div class="form-group">
                      <label>Mot de passe</label>
                      <input type="password" class="form-control" placeholder="Entrer le mot de passe" name="passe">
                      <span class="error"><?php echo $error_mdp;?></span>
                  </div>
                  <button type="submit" name="valider" class="form-control btn-info mb-3">valider</button>
                </form>
            </div>
          </div>
			</div>
		</div>
	</div>

</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>