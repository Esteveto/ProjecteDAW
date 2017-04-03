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
                    echo '<li><a href="galeriaAdmin.php?album='.$row2['id'].'" class="dropdown-header">'.$row2['nom'].'</a></li>';
                  }else{
                    echo '<li><a href="galeria.php?album='.$row2['id'].'" class="dropdown-header">'.$row2['nom'].'</a></li>';
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
            //$newFilePath = "images/" . $imgs['name'][$i];
            $img = $imgs['name'][$i];
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $name = md5(uniqid(rand(), true)).".".$ext;
            $newFilePath = "images/" .$name;

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
    
    
    try{
      $id_album = $this->getIDAlbum($nomAlbum);
      $conn = $this->DBConnection();
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
            //$newFilePath = "images/" . $imgs['name'][$i];
            $img = $imgs['name'][$i];
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $name = md5(uniqid(rand(), true)).".".$ext;
            $newFilePath = "images/" .$name;

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

  public function createSelectCategories(){
    try{
       $conn = $this->DBConnection();
       $sql = "SELECT nom FROM categoria";
       $result = $conn->query($sql);
       while($row = mysqli_fetch_array($result)){
          echo "<option value='".$row["nom"]."'>".$row["nom"]."</option>";
       }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function createSelectAlbums(){
    try{
       $conn = $this->DBConnection();
       $sql = "SELECT nom FROM album";
       $result = $conn->query($sql);
       while($row = mysqli_fetch_array($result)){
          echo "<option value='".$row["nom"]."'>".$row["nom"]."</option>";
       }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  private function deleteALlImages($idAlbum){
    try{
      $conn = $this->DBConnection();
      $sql = "DELETE FROM fotografia WHERE id_album = '".$idAlbum."'";
      $conn->query($sql);
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function deleteAlbum($nomAlbum){
    try{
    $id_album = $this->getIDAlbum($nomAlbum);
    $this->deleteALlImages($id_album);
    $conn = $this->DBConnection();
    $sql = "DELETE FROM album WHERE id = '".$id_album."'";
    $conn->query($sql);
    //header('Location: http://localhost/projectedaw/anadir.php');
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }

  }

  private function deleteAllAlbums($idCategoria){
    try{
      $conn = $this->DBConnection();
      $sql = "SELECT * FROM album WHERE id_categoria = '".$idCategoria."'";
      $result = $conn->query($sql);
      while($row = mysqli_fetch_array($result)){
        $this->deleteAlbum($row['nom']);
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function deleteCategoria($nomCategoria){
    try{
      $idCategoria = $this->getIDCategoria($nomCategoria);
      $this->deleteAllAlbums($idCategoria);
      $conn = $this->DBConnection();
      //echo $idCategoria;
      $sql = "DELETE FROM categoria WHERE id = '".$idCategoria."'";
      $conn->query($sql);
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  private function deleteImage($url){
    try{
      $conn = $this->DBConnection();
      $sql = "DELETE FROM fotografia WHERE url = '".$url."'";
      $conn->query($sql);
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function createGaleria($id_album,$admin,$nomAlbum){
    try{
      $conn = $this->DBConnection();
      $sql = "SELECT * FROM fotografia WHERE id_album = '".$id_album."'";
          $result = $conn->query($sql);

          while($row = mysqli_fetch_array($result)){
            //$size = getimagesize($row['url']);
            list($width, $height) = getimagesize($row['url']);
            //echo $width.$height;
            $defaultHeight = 350;
            //echo $height;
            $proporcion = $height/$defaultHeight;
            //echo $proporcion;
            if($width > 285){
              $widthOK = $width/$proporcion;
            }else{
              $widthOK = $width/3.5;
            }           
            $heightOK = $height/3.5;
            $heightDelete = $height/15.7;
          /*<div class="personaje-item">
                <div class="personaje-item-image">
                    <a href="#"><img src="assets/images/shop/3.png" alt=""/></a>
                    <div class="personaje-item-hidden">
                      <a href="#" style="font-size: 15px; color: white; text-align: center;"><img src="assets/images/shop/3.png" alt=""/></a>
                    </div>
                </div>
            </div>
            .personaje-item {
                margin: 0 0 35px;
                 border: 2px solid;
                 border-color: white;
                 border-radius: 4px;
            }
            .personaje-item:hover {
                margin: 0 0 35px;
                border: 2px solid;
                 border-color: grey;
                 border-radius: 6px;
            }
            .personaje-item-image {
                position: relative;
                overflow: hidden;
                margin: 0 0 20px;
            }
            .personaje-item-image img {
                width: 100%;
            }
            .personaje-item-image:hover .personaje-item-hidden {
                -webkit-transform: translateY(-100%);
                        transform: translateY(-100%);

            }
            .personaje-item-hidden {
                position: absolute;
                width: 100%;
                top: 100%;
                -webkit-transition: all 0.7s ease-in-out 0s;
                        transition: all 0.7s ease-in-out 0s;
            }*/

            //print_r($size[3]);

            echo '<div style="display:inline">';
            echo '<a href="'.$row['url'].'" rel="lightbox[philippines]" title="'.$nomAlbum.'">';
            echo '<img style="padding:5px;" class="fadeIn animated img" width="'.$widthOK.'" height="'.$defaultHeight.'" src="'.$row['url'].'"/>';
            echo "</a>";
            if(!$admin){
              /*echo '<div>';
              echo "<a><img id='imgLike' style='width:40px;height:40px;' src ='images/like.png'></img>  ".$row['num_likes']."</a>";
              echo '</div>';*/
              $cookie_name = 'cookie'.$row['id'];
              //echo $cookie_name;
              if(isset($_COOKIE[$cookie_name])){
                if($_COOKIE[$cookie_name] == "false"){
                  echo "<a style='position:relative; left: -80px; top:125px'>
                <img id='cookie".$row['id']."' class='imgLike likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
                </a>";
                }else{
                  echo "<a style='position:relative; left: -80px; top:125px'>
                <img id='cookie".$row['id']."' class='imgLiked likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
                </a>";
                }
              }else{
                echo "<a style='position:relative; left: -80px; top:125px'>
                <img id='cookie".$row['id']."' class='imgLike likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
                </a>";
              }
              echo '</div>'; 
            }
            
            if($admin){
              echo "<a class='deleteImageButton' style='position:relative; left: -65px; top:-125px' href='?album=".$id_album."&imageUrl=".$row['url']."'>
              <img style='width:30px;height:30px;' src ='images/close.svg'></img>
              </a>";
              
              echo '</div>';
              if(isset($_GET['imageUrl']))
              {
                unlink($_GET['imageUrl']);
                $this->deleteImage($_GET['imageUrl']);
                header('Location: http://localhost/projectedaw/galeriaAdmin.php?album='.$id_album.'');
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

  public function testInfo(){
    $cookie_name = "user2";
      $cookie_value = "John Doe";
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

      if(!isset($_COOKIE[$cookie_name])) {
           echo "Cookie named '" . $cookie_name . "' is not set!";
      } else {
           echo "Cookie '" . $cookie_name . "' is set!<br>";
           echo "Value is: " . $_COOKIE[$cookie_name];
      }
  }

  private function getLikesPhoto($idPhoto){
    $result2;
    try{
      
      $conn = $this->DBConnection();
      $sql = "SELECT num_likes FROM fotografia WHERE id = ".$idPhoto."";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $result2 = $row['num_likes'];
      
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
    return $result2;
  }

  private function setLikePhoto($id,$like){
    $result;
    try{
      $idPhoto = substr($id, 6);
      //echo $idPhoto;
      $numLikes = $this->getLikesPhoto($idPhoto);
      if($like == true){
        $numLikes = $numLikes+1;
      }else if ($like == false){
        $numLikes = $numLikes-1;
      }
      
      $conn = $this->DBConnection();
      $sql = "UPDATE fotografia SET num_likes = ".$numLikes." WHERE id = ".$idPhoto."";
      $result = $conn->query($sql);
    }catch(Exception $e){
      var_dump($e);
    }finally{
      //$this->close();
      $conn->close();
    }
  }

  public function setLike($id){
    $cookie_name = $id;
    $result;
    if(!isset($_COOKIE[$cookie_name])) {
      $cookie_value = "true";
      setcookie($cookie_name, $cookie_value, time() + 10, "/"); 
      //$result = "Cookie named '" . $cookie_name . "' set!";
      $result = $cookie_value;
      $this->setLikePhoto($id,true);
    }else{
      if($_COOKIE[$cookie_name] == "true"){
      $cookie_value = "false";
      setcookie($cookie_name, $cookie_value, time() + 10, "/"); 
         //echo "Cookie '" . $cookie_name . "' is set!<br>";
      $result = $cookie_value;
      $this->setLikePhoto($id,false);
      }else{
      $cookie_value = "true";
      setcookie($cookie_name, $cookie_value, time() + 10, "/"); 
         //echo "Cookie '" . $cookie_name . "' is set!<br>";
      $result = $cookie_value;
      $this->setLikePhoto($id,true);
      }
    }

    return $result;
  }

  
}

?>