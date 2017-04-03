<!DOCTYPE html>
<?php
      include 'funcions.php';
      $funcions = new funcionsClass();
    
      $nomAlbum = $_POST['albumPadre'];
      $imgs = $_FILES['imgs'];
      $funcions->addImgsAlbum($imgs,$nomAlbum);
      header('Location: indexAdmin.php');
      ?>

