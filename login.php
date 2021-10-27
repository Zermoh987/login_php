<?php
    session_start();
    require('config.php');
    require('function.php');

    if (isset($_POST['valide'])) {
        $email = ($_POST['email']);
        $password = ($_POST['passe']);

        $sql = "SELECT * FROM utilisateu where email = '$email'";
        $result = $dbco->prepare($sql);
        $result->execute();

        if ($result->rowcount() > 0) {
            $data = $result->fetchAll();
            if (password_verify($password, $data[0]['passe'])) {
                echo "connextion effectuée avce succès";
                $_SESSION['email'] = $email;
            }
        }else {
            echo "imposible de se connecter";
        }
    }
?>