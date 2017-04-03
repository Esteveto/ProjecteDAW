<!DOCTYPE html>
  <?php
    include 'funcions.php';
    $funcions = new funcionsClass();
    $nomCategoria = $_GET["categoria"];
    $funcions->insertCategoria($nomCategoria);

    header('Location: indexAdmin.php');
?>

