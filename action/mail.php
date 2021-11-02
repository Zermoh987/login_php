<?php
    $email = "";
    $to = $email;
    $subject = "validation";
    $message = "veuillez valider vortre inscription";
    $from = "zermoh987@gmail.com";
    $header = "From:" . $from;
    if($_POST['valide']) {
        $email = $_POST['email'];
        mail($to, $subject, $message, $header,);
        echo "message envoyer"; 
    }  
?>