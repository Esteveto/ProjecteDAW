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
    <link rel="stylesheet" type="text/css" href="animate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--LightBox-->
    <link rel="stylesheet" type="text/css" href="LightBox/lightbox2-master/dist/css/lightbox.min.css" media="screen" />
    <!--JS meu-->
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
        <a class="navbar-brand" href="indexPublic.php">Mariona Dalmau</a>
        </div>

        <div class="collapse navbar-collapse js-navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            //NavBar-----------------------------------------------------
             $funcions->createNavBar(false);
            ?>
          </ul>
        </div>
      </nav>

      <div style="text-align:center">
        <?php
        $conn = $funcions->DBConnection();
        $nomAlbum = $funcions->nomAlbum();
        echo '<h3 id="albumSelected">'.$nomAlbum.'</h3>';
        ?>
      </div>

      <div id="gallery" style="text-align:center">
        <?php
          $idAlbum = $_GET["album"];
          $funcions->createGaleria($idAlbum,false,$nomAlbum);
          /*$sql = "SELECT * FROM fotografia WHERE id_album = '".$_GET["album"]."'";
          $result = $conn->query($sql);

          while($row = mysqli_fetch_array($result))
            {           
              echo '<a href="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'" rel="lightbox[philippines]" title="title">';
              echo '<img width="175px" height="150px" src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';
              echo "</a> ";
          }*/
        ?>
        <script type="text/javascript" src="LightBox/lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>
        <!--
        <script type="text/javascript">
        // script to activate lightbox
        $(function() {
            $('#gallery a').lightBox();
        });
        </script>
        -->

    </div>
  </body>
</html>
