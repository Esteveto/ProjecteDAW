<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "projectedaw2";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      echo "Connected successfully";

      //////////////////////////////////////
      //Seleccionar imatge db
      //////////////////////////////////////
      /*$sql = "SELECT img FROM fotografia";
      $result = $conn->query($sql);

      while($row = mysqli_fetch_array($result))
        {
          echo '<img width="175px" height="150px" src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';
        }*/
    ?>
    <div class="container-fluid" style="padding-top:15px">
      <nav class="navbar navbar-inverse">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="testBaseDates.php">Mariona Dalmau</a>
        </div>

        <div class="collapse navbar-collapse js-navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            //NavBar-----------------------------------------------------
            $sql = "SELECT * FROM categoria";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  echo "<li class='dropdown'>
                      <a href='#' class='dropdown-toggle' id='".$row['nom']."' data-toggle='dropdown' >".$row['nom']."</a>
                      <ul class='dropdown-menu'>";
                  $sql2 = "SELECT * FROM album where id_categoria = $row[id]";
                  $categoria = $row['nom'];
                  $categoria2 = "sssssssss";
                  $result2 = $conn->query($sql2);
                  if ($result2->num_rows > 0) {
                      // output data of each row
                      while($row2 = $result2->fetch_assoc()) {
                        echo '<li><a href="galeria.php?album='.$row2['id'].'" class="dropdown-header" onclick="albumSelected(this);categoriaActual(\''.$categoria.'\')">'.$row2['nom'].'</a></li>';
                      }
                }
                echo "</ul></li>";
              }
            } else {
                echo "0 results";
            }
            ?>
          </ul>
        </div>
      </nav>

      <div>
        <?php
        include 'funcions.php';
        $nomAlbum = nomAlbum();
        echo '<h3 id="albumSelected">'.$nomAlbum.'</h3>';
        ?>
      </div>

      <div id="gallery">
        <?php
          //include 'config_open_db.php'; // Database Connection
          $sql = "SELECT * FROM fotografia WHERE id_album = '".$_GET["album"]."'";
          $result = $conn->query($sql);

          while($row = mysqli_fetch_array($result))
            {           
              echo '<a href="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'" rel="lightbox[philippines]" title="Siono">';
                  echo '<img width="175px" height="150px" src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';
              echo "</a> ";
          }
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
