<?php
require('config.php');
$id = $_GET['id'];
$sql = 'DELETE FROM utilisateu WHERE id=:id';
$statement = $dbco->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header('location:dashboard.php');
}
else{
    echo("probleme lors de la suppression");
}