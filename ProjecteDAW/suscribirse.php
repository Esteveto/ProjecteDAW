<!DOCTYPE html>
  <?php
    include 'funcions.php';
    $funcions = new funcionsClass();
    $email = $_POST["email"];
    $funcions->suscribirse($email);

    header('Location: indexAdmin.php');
?>

