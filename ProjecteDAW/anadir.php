<!DOCTYPE html>
<?php
      include 'funcions.php';
      $funcions = new funcionsClass();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type ="text/javascript" src="funcions.js">
    </script>
  </head>
  <body>
    
    <div class="container-fluid" style="padding-top:15px">
      <?php
        //NavBar-----------------------------------------------------
        $funcions->createNavBar(true,"añadir");
      ?>
      
      <div clas="row-fluid" class="">
        <div class="col-md-6 forms">
          <h3>Añadir Categoria</h3>
          <?php 
            $funcions->createCategoria();
          ?>
          
          <br>
          <h3>Añadir Álbum</h3>
          <form method="post" action="anadirAlbum.php" enctype="multipart/form-data">
            <a style="color: black !important; text-decoration: none !important;">Categoria:</a>
            <select name="categoriaPadre" required>
              <?php
              $funcions->createSelectCategories();
              ?>
            </select>
            <br><br>
            <input class="inputForms" type="text" name="album" placeholder="Nombre Album" required>
            <br><br>
            <input type="file" name="imgs[]" multiple required/>
            <br>
            <input class="buttonForms" type="submit" name="submitBtn" value="Añadir" required>
          </form>
          <br>
          <h3>Añadir imágenes a álbum</h3>
          <form method="post" action="anadirFotosAlbum.php" enctype="multipart/form-data" required>
            <select name="albumPadre">
              <?php
              $funcions->createSelectAlbums();
              ?>
            </select>
            <br><br>
            <input type="file" name="imgs[]" multiple required/>
            <br>
            <input class="buttonForms" type="submit" name="submitBtn" value="Añadir">
          </form>
          <br>
        </div>
        <div class="col-md-6 forms">
          <h3>Eliminar Álbum</h3>
          <form method="post" action="eliminarAlbum.php" enctype="multipart/form-data">
            <select name="album" required>
              <?php
              $funcions->createSelectAlbums();
              ?>
            </select>
            <br><br>
            <input class="buttonForms" type="submit" name="submitBtn" value="Eliminar">
          </form>
          <br>
          <h3>Eliminar Categoria</h3>
          <form method="post" action="eliminarCategoria.php" enctype="multipart/form-data">
            <select name="categoria" required>
              <?php
              $funcions->createSelectCategories();
              ?>
            </select>
            <br><br>
            <input class="buttonForms" type="submit" name="submitBtn" value="Eliminar">
          </form>
        </div>
      </div>
    </div>
  </body>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="textosFooter">Contacta con nosotros</p>
                <p class="textosFooter">Quiénes somos</p>
                <p class="textosFooter">Políticas de privacidad</p>
                

            </div>
            <div class="col-md-6">
                <p class="textosFooter">Redes sociales</p>
                <a href="https://www.youtube.com"><img class="logoSocial" src="assets/youtube.png"></a>
                <a style="padding-left:10px; padding-right:10px" href="https://www.facebook.com"><img class="logoSocial" src="assets/facebook.png"></a>
                <a href="https://www.twitter.com"><img class="logoSocial" src="assets/instagram.png"></a>

            </div>
        </div>
    </div>
</footer>
</html>
