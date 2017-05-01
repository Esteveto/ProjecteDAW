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
        $funcions->createNavBar(false,"suscripcion");
      ?>
      <p>Suscribirse</p>
      <div clas="row-fluid" class=""> 
        <form method="post" action="suscribirse.php">
          <input type="email" name="email" placeholder="Email" required>
          <input type="submit" value="Suscribirse">
        </form>
        <br>
        <p>Desuscribirse</p>
        <form method="post" action="desuscribirse.php" enctype="multipart/form-data">
          <input type="text" name="email" placeholder="Email" required>
          <input type="submit" name="submit" value="Desuscribirse">
        </form>
      </div>
    </div>
  </body>
</html>
