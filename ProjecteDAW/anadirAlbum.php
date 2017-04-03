<!DOCTYPE html>
<?php
      include 'funcions.php';
      $funcions = new funcionsClass();
    
      $nomAlbum = $_POST['album'];
      $nomCategoria = $_POST["categoriaPadre"];
      $idCategoria = $funcions->getIDCategoria($nomCategoria);
      $imgs = $_FILES['imgs'];
      $funcions->insertAlbum($nomAlbum,$idCategoria,$imgs);
      header('Location: indexAdmin.php');
?>
