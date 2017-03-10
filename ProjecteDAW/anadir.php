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
      <nav class="navbar navbar-inverse">
        <div class="navbar-header">
        	<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
    			<span class="sr-only">Toggle navigation</span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    		</button>
    		<a class="navbar-brand" href="indexAdmin.php">Mariona Dalmau</a>
      	</div>

        <div class="collapse navbar-collapse js-navbar-collapse">
      		<ul class="nav navbar-nav">
            <?php
            $funcions->createNavBar(true);
            ?>
      		</ul>
      	</div>
      </nav>
      <div clas="row-fluid" class=""> 
        <form method="get" action="anadirCategoria.php">
          <input type="text" name="categoria" placeholder="Nombre Categoria">
          <input type="submit" value="Añadir Categoria">
        </form>
        <br>
        <form method="post" action="anadirAlbum.php" enctype="multipart/form-data">
          <select name="categoriaPadre">
            <?php
            $funcions->createSelectCategories();
            ?>
          </select>
          <input type="text" name="album" placeholder="Nombre Album">
          <input type="file" name="imgs[]" multiple/>
          <input type="submit" name="submitBtn" value="Añadir Album">
        </form>
        <br>
        <form method="post" action="anadirFotosAlbum.php" enctype="multipart/form-data">
          <select name="albumPadre">
            <?php
            $funcions->createSelectAlbums();
            ?>
          </select>
          <input type="file" name="imgs[]" multiple/>
          <input type="submit" name="submitBtn" value="Añadir fotografias Album">
        </form>
      </div>
    </div>
  </body>
</html>
