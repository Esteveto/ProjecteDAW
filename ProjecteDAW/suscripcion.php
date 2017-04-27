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
      <p>Suscribirse</p>
      <div clas="row-fluid" class=""> 
        <form method="post" action="suscribirse.php">
          <input type="email" name="email" placeholder="Email">
          <input type="submit" value="Suscribirse">
        </form>
        <br>
        <p>Desuscribirse</p>
        <form method="post" action="desuscribirse.php" enctype="multipart/form-data">
          <input type="text" name="email" placeholder="Email">
          <input type="submit" name="submit" value="Desuscribirse">
        </form>
      </div>
    </div>
  </body>
</html>
