<!DOCTYPE html>
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

      $sql = "SELECT nom FROM Categoria";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              echo "nom: " . $row["nom"];
          }
      } else {
          echo "0 results";
      }
      $conn->close();
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
    		<a class="navbar-brand" href="#">Mariona Dalmau</a>
      	</div>

      	<div class="collapse navbar-collapse js-navbar-collapse">
      		<ul class="nav navbar-nav">
      			<li class="dropdown">
      				<a href="#" class="dropdown-toggle" id="categoria1" data-toggle="dropdown" >Categoría 1</a>
      				<ul class="dropdown-menu">
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 1.1</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 1.2</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 1.3</a></li>
      				</ul>
      			</li>
            <li class="dropdown">
      				<a href="#" class="dropdown-toggle" id="categoria2" data-toggle="dropdown">Categoría 2<span class="caret"></span></a>
              <ul class="dropdown-menu">
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 2.1</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 2.2</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 2.3</a></li>
      				</ul>
      			</li>
            <li class="dropdown">
      				<a href="#" class="dropdown-toggle" id="categoria3" data-toggle="dropdown">Categoría 3<span class="caret"></span></a>
              <ul class="dropdown-menu">
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 3.3</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 3.3</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 3.3</a></li>
      				</ul>
      			</li>
            <li class="dropdown">
      				<a href="#" class="dropdown-toggle" id="categoria4" data-toggle="dropdown">Categoría 4<span class="caret"></span></a>
              <ul class="dropdown-menu">
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 4.1</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 4.2</a></li>
                    <li><a class="dropdown-header" onclick="albumSelected(this.text)">Álbum 4.3</a></li>
      				</ul>
      			</li>
      		</ul>
      	</div>
      </nav>

      <div>
        <h3 id="albumSelected"></h3>
      </div>

      <div class="row" style="display:none" id="galeria">

          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                  <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
          <div class="col-lg-3 col-md-4 col-xs-6 thumb">
              <a class="thumbnail" href="#">
                <img class="img-responsive" src="images/testGaleria.jpg" alt="">
              </a>
          </div>
      </div>

    </div>
  </body>
</html>
