<!DOCTYPE html>
<?php
      include 'funcions.php';
      $funcions = new funcionsClass();
    
      $nomAlbum = $_POST['album'];
      $nomCategoria = $_POST["categoriaPadre"];
      $idCategoria = $funcions->getIDCategoria($nomCategoria);
      $imgs = $_FILES['imgs'];
      $funcions->insertAlbum($nomAlbum,$idCategoria,$imgs);
      $body = "<h1 style='color:red'>Nueva Álbum</h1><p>Mariona Dalmau ha añadido el álbum $nomAlbum a la categoria $nomCategoria en su página web</p>";
      $funcions->sendMail("Nuevo Álbum!",$body);
      header('Location: indexAdmin.php');
?>
