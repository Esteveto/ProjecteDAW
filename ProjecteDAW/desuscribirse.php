<?php
    include 'funcions.php';
    $funcions = new funcionsClass();
    $email = $_POST["email"];
    $funcions->desuscribirse($email);

    header('Location: suscripcion.php?data=KO');
?>

