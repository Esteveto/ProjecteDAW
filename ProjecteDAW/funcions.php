<?php
class funcionsClass{

  private $user = "root";
  private $pass = "";
  private $db = "projectedaw2";
  public $conn;

  public function connect(){

    $this->conn = new PDO('mysql:host=localhost;dbname='.$this->db, $this->user, $this->pass);

  }

  private function close($stmt){
    $stmt = null;
    $this->conn = null;
  }

  public function nomAlbum(){
    $result;
    try{
      $album = intval($_GET["album"]);
      $this->connect();
      $stmt = $this->conn->prepare("SELECT nom FROM album WHERE id = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $album, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      //var_dump($result);
      $result = $result[0]['nom'];      
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
    return $result;
  }

  public function createNavBar($admin){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM categoria");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result) {
        foreach ($result as $key => $value) {
          echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' id='".$value['nom']."' data-toggle='dropdown' >".$value['nom']."</a>
                <ul class='dropdown-menu'>";

          $stmt2 = $this->conn->prepare("SELECT * FROM album where id_categoria = ?");
          $bindPos = 0;
          $stmt2->bindParam(++$bindPos, $value['id'], PDO::PARAM_INT);
          $stmt2->execute();
          $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
          
          if ($result2) {
            foreach ($result2 as $key => $value) {
              if($admin){
                echo '<li><a href="galeriaAdmin.php?album='.$value['id'].'" class="dropdown-header">'.$value['nom'].'</a></li>';
              }else{
                echo '<li><a href="galeria.php?album='.$value['id'].'" class="dropdown-header">'.$value['nom'].'</a></li>';
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
      $this->close($stmt);
    }
  }

  public function insertCategoria($nomCategoria){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("INSERT INTO categoria(nom) VALUES (?)");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $nomCategoria, PDO::PARAM_STR);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function getIDAlbum($nomAlbum){
    $result;
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT id FROM album WHERE nom = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $nomAlbum, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result = $result[0]['id'];
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
    return $result;
  }

  public function getIDCategoria($nomCategoria){
    $result;
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT id FROM categoria WHERE nom = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $nomCategoria, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result = $result[0]['id'];
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
    return $result;
  }

  public function insertAlbum($nomAlbum,$id_categoria,$imgs){
    
    //echo $id_categoria;
    $id_categoria = intval($id_categoria);
    try{
      $this->connect();
      $stmt = $this->conn->prepare("INSERT INTO album(nom,id_categoria) VALUES (?,?)");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $nomAlbum, PDO::PARAM_STR);
      $stmt->bindParam(++$bindPos, $id_categoria, PDO::PARAM_INT);
      $rows = $stmt->execute();
      if($rows > 0){
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
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  private function insertURLImgs($path,$nomAlbum){
    try{
      $id_album = $this->getIDAlbum($nomAlbum);
      $this->connect();
      $stmt = $this->conn->prepare("INSERT INTO fotografia(url,id_album) VALUES (?,?)");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $path, PDO::PARAM_STR);
      $stmt->bindParam(++$bindPos, $id_album, PDO::PARAM_INT);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function addImgsAlbum($imgs,$nomAlbum){
    try{
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
              }
          }
        }
    }catch(Exception $e){
      var_dump($e);
    }finally{
    }
  }

  public function createSelectCategories(){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT nom FROM categoria");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $key => $value) {
        echo "<option value='".$value["nom"]."'>".$value["nom"]."</option>";
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function createSelectAlbums(){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT nom FROM album");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $key => $value) {
        echo "<option value='".$value["nom"]."'>".$value["nom"]."</option>";
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  private function deleteALlImages($idAlbum){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("DELETE FROM fotografia WHERE id_album = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $idAlbum, PDO::PARAM_INT);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function deleteAlbum($nomAlbum){
    try{
    $id_album = $this->getIDAlbum($nomAlbum);
    $this->deleteALlImages($id_album);
    $this->connect();
    $stmt = $this->conn->prepare("DELETE FROM album WHERE id = ?");
    $bindPos = 0;
    $stmt->bindParam(++$bindPos, $idAlbum, PDO::PARAM_INT);
    $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }

  }

  private function deleteAllAlbums($idCategoria){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM album WHERE id_categoria = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $idCategoria, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $key => $value) {
        $this->deleteAlbum($value['nom']);
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function deleteCategoria($nomCategoria){
    try{
      $idCategoria = $this->getIDCategoria($nomCategoria);
      $this->deleteAllAlbums($idCategoria);
      $this->connect();
      $stmt = $this->conn->prepare("DELETE FROM categoria WHERE id = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $idCategoria, PDO::PARAM_INT);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  private function deleteImage($url){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("DELETE FROM fotografia WHERE url = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $url, PDO::PARAM_STR);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
    }
  }

  public function createGaleria($id_album,$admin,$nomAlbum){
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM fotografia WHERE id_album = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $id_album, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $key => $value) {
        //$size = getimagesize($row['url']);
        list($width, $height) = getimagesize($value['url']);
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

        echo '<div style="display:inline">';
        echo '<a href="'.$value['url'].'" rel="lightbox[philippines]" title="'.$nomAlbum.'">';
        echo '<img style="padding:5px;" class="fadeIn animated img" width="'.$widthOK.'" height="'.$defaultHeight.'" src="'.$value['url'].'"/>';
        echo "</a>";
        if(!$admin){
          /*echo '<div>';
          echo "<a><img id='imgLike' style='width:40px;height:40px;' src ='images/like.png'></img>  ".$row['num_likes']."</a>";
          echo '</div>';*/
          $cookie_name = 'cookie'.$value['id'];
          //echo $cookie_name;
          if(isset($_COOKIE[$cookie_name])){
            if($_COOKIE[$cookie_name] == "false"){
              echo "<a style='position:relative; left: -80px; top:125px'>
            <img id='cookie".$value['id']."' class='imgLike likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
            </a>";
            }else{
              echo "<a style='position:relative; left: -80px; top:125px'>
            <img id='cookie".$value['id']."' class='imgLiked likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
            </a>";
            }
          }else{
            echo "<a style='position:relative; left: -80px; top:125px'>
            <img id='cookie".$value['id']."' class='imgLike likeimgs' style='width:40px;height:40px;margin-left:-10px;margin-right:-10px;' src ='images/like.png'></img>
            </a>";
          }
          echo '</div>'; 
        }
        
        if($admin){
          echo "<a class='deleteImageButton' style='position:relative; left: -65px; top:-125px' href='?album=".$id_album."&imageUrl=".$value['url']."'>
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
      $this->close($stmt);
    }
  }

  private function getLikesPhoto($idPhoto){
    $result2;
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT num_likes FROM fotografia WHERE id = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $idPhoto, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result2 = $result[0]['num_likes'];      
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
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
      $this->connect();
      $stmt = $this->conn->prepare("UPDATE fotografia SET num_likes = ? WHERE id = ? ");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $numLikes, PDO::PARAM_INT);
      $stmt->bindParam(++$bindPos, $id, PDO::PARAM_INT);
      $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $this->close($stmt);
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