<?php
class funcionsClass{

	public function DBConnection(){
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
      //echo "Connected successfully";

      return $conn;
	}

	public function nomAlbum(){
		$conn = $this->DBConnection();
    try{
      $sql = "SELECT * FROM album WHERE id = '".$_GET["album"]."'";
      $result = $conn->query($sql);

      $row = mysqli_fetch_array($result);
      
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
		return $row['nom'];
	}

  public function createNavBar($admin){
    try{
      $conn = $this->DBConnection();
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
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                // output data of each row
                while($row2 = $result2->fetch_assoc()) {
                  if($admin){
                    echo '<li><a href="galeriaAdmin.php?album='.$row2['id'].'" class="dropdown-header" onclick="albumSelected(this);categoriaActual(\''.$categoria.'\')">'.$row2['nom'].'</a></li>';
                  }else{
                    echo '<li><a href="galeria.php?album='.$row2['id'].'" class="dropdown-header" onclick="albumSelected(this);categoriaActual(\''.$categoria.'\')">'.$row2['nom'].'</a></li>';
                  }
                }
          }
          echo "</ul></li>";
        }
        if($admin){
        echo "<li><a href='anadir.php'>Añadir</a></li>";
        }
      }else {
          echo "0 results";
      }

    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function insertCategoria($nomCategoria){
    try{
      $conn = $this->DBConnection();
      $sql = 'INSERT INTO categoria(nom) values ("'.$nomCategoria.'")';
      if ($conn->query($sql) === TRUE) {
          echo "Categoria añadida correctamente";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function getIDAlbum($nomAlbum){
    $conn = $this->DBConnection();
    try{
      $sql=("SELECT id FROM album WHERE nom = '".$nomAlbum."'");
      $result = $conn->query($sql);

      $row = mysqli_fetch_array($result);
      return $row['id'];
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function getIDCategoria($nomCategoria){
    $idCategoria;
    try{
      $conn = $this->DBConnection();
      $sql1 = 'SELECT id from categoria as c where c.nom="'.$nomCategoria.'"';
      $result = $conn->query($sql1);
      $row = $result->fetch_assoc();
      $idCategoria = $row['id']; 
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $conn->close();
    }
    return $idCategoria;
  }

  public function insertAlbum($nomAlbum,$id_categoria,$imgs){
    
    echo $id_categoria;
    try{
      $conn = $this->DBConnection();
      $sql=("INSERT INTO album(nom,id_categoria) VALUES ('".$nomAlbum."',".$id_categoria.")");
      if ($conn->query($sql) === TRUE) {
        echo "album añadido correctamente";
        $total = count($imgs['name']); 
        for($i=0; $i<$total; $i++) {
          //Get the temp file path
          $tmpFilePath = $imgs['tmp_name'][$i];

          //Make sure we have a filepath
          if ($tmpFilePath != ""){
          //Setup our new file path
          $newFilePath = "images/" . $imgs['name'][$i];

          //Upload the file into the temp dir
          if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            $this->insertURLImgs($newFilePath,$nomAlbum);
            $conn = $this->DBConnection();
            }
          }
        }
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  private function insertURLImgs($path,$nomAlbum){
    $id_album = $this->getIDAlbum($nomAlbum);
    $conn = $this->DBConnection();
    try{
      $sql=("INSERT INTO fotografia(url,id_album) VALUES ('".$path."',".$id_album.")");
      /*$stmt->bind_param(1, $nom, $id_categoria);
      $stmt->execute();
      $result = $stmt->fetch_assoc();*/
      if ($conn->query($sql) === TRUE) {
              echo "imagen insertada correctamente";
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function addImgsAlbum($imgs,$nomAlbum){
    try{
      $conn=$this->DBConnection();
      $total = count($imgs['name']); 
      for($i=0; $i<$total; $i++) {
          //Get the temp file path
          $tmpFilePath = $imgs['tmp_name'][$i];

          //Make sure we have a filepath
          if ($tmpFilePath != ""){
          //Setup our new file path
          $newFilePath = "images/" . $imgs['name'][$i];

          //Upload the file into the temp dir
          if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            $this->insertURLImgs($newFilePath,$nomAlbum);
            $conn = $this->DBConnection();
            }
          }
        }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function createGaleria($id_album,$admin){
    try{
      $conn = $this->DBConnection();
      $sql = "SELECT * FROM fotografia WHERE id_album = '".$id_album."'";
          $result = $conn->query($sql);

          while($row = mysqli_fetch_array($result)){
            echo '<a href="'.$row['url'].'" rel="lightbox[philippines]" title="title">';
              echo '<img width="175px" height="150px" src="'.$row['url'].'"/>';
              echo "</a> ";
              if($admin){
                echo "<a style='position:relative; left: -25px; top: -55px' onclick='borrar(".$row['id'].")'>X</a>";
              }
              
          }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  
}

?>