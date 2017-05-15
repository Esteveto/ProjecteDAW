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
      
      <div clas="row-fluid" >
        <div class="col-md-6 forms">
          <h3>Suscribirse</h3>
          <form method="post" action="suscribirse.php">
            <br>
            <input class="inputForms" type="email" name="email" placeholder="Email" required >
            <br><br>
            <input class="buttonForms" type="submit" value="Suscribirse">

          </form>
        </div>
        <div class="col-md-6 forms">
          <h3>Anular suscripción</h3>
          <form method="post" action="desuscribirse.php" enctype="multipart/form-data">
            <br>
            <input class="inputForms" type="email" name="email" placeholder="Email" required>
            <br><br>
            <input class="buttonForms" type="submit" name="submit" value="Anular">
          </form>
        </div>        
      </div>
      <div class="forms">
        <?php 
        if(isset($_GET['data'])){
          if($_GET['data'] == "OK"){
            echo '<h1>Suscrito correctamente!</h1>';
          }else if($_GET['data'] == "KO"){
            echo '<h1>Suscripción anulada!</h1>';
          }
          
        }
        ?>
      </div>
    </div>
  </body>

  <footer style="margin-top:245px;">
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
