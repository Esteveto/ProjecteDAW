<?php
class funcionsClass{

  private $user = "root";
  private $pass = "";
  private $db = "projectedaw2";
  public $conn;

  public function connect(){

    $this->conn = new PDO('mysql:host=localhost;dbname='.$this->db, $this->user, $this->pass);

  }

  private function close(){
    $this->conn = null;
    return null;
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
      $stmt = $this->close();
    }
    return $result;
  }

  public function createNavBar($admin, $categoriaActive){
    if($categoriaActive == ""){
      echo '<nav class="navbar">';
    }else{
      echo '<nav class="navbar navbarNoIndex">';
    }
    echo '<div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          <a class="navbar-brand" href="indexPublic.php">Mariona Dalmau</a>
        </div>

        <div class="collapse navbar-collapse js-navbar-collapse">
          <ul class="nav navbar-nav navbar-right">';
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM categoria");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result) {
        foreach ($result as $key => $value) {
            if($categoriaActive == $value['id']){
              echo "<li class='dropdown active'>
                <a href='#' class='dropdown-toggle' id='".$value['nom']."' data-toggle='dropdown' >".$value['nom']."</a>
                ";
            }
          else{
            echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' id='".$value['nom']."' data-toggle='dropdown' >".$value['nom']."</a>
                ";
          }
          if($categoriaActive != ""){
            echo "<ul class='dropdown-menu '>";
          }else{
            echo "<ul class='dropdown-menu dropdownMenuIndex'>";
          }
          

          $stmt2 = $this->conn->prepare("SELECT * FROM album where id_categoria = ?");
          $bindPos = 0;
          $stmt2->bindParam(++$bindPos, $value['id'], PDO::PARAM_INT);
          $stmt2->execute();
          $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
          
          if ($result2) {
            foreach ($result2 as $key => $value) {
              if($categoriaActive != ""){
                if($admin){
                  echo '<li><a href="galeriaAdmin.php?album='.$value['id'].'" class="dropdown-header">'.$value['nom'].'</a></li>';
                }else{
                  echo '<li><a href="galeria.php?album='.$value['id'].'" class="dropdown-header">'.$value['nom'].'</a></li>';
                }
            }else{
              if($admin){
                  echo '<li><a href="galeriaAdmin.php?album='.$value['id'].'" class="dropdown-header dropdownIndex">'.$value['nom'].'</a></li>';
                }else{
                  echo '<li><a href="galeria.php?album='.$value['id'].'" class="dropdown-header dropdownIndex">'.$value['nom'].'</a></li>';
                }
            }
            }
          }
          echo "</ul></li>";
        }
        if($categoriaActive == "suscripcion"){
          echo "<li class='active'><a href='suscripcion.php'>Suscribirse</a></li>";
        }else{
          echo "<li><a href='suscripcion.php'>Suscribirse</a></li>";
        }
        
        if($admin){
        echo "<li><a href='anadir.php'>Añadir</a></li>";
        
        }
      }else {
          echo "0 results";
      }
      echo '</ul>
        </div>
      </nav>';

    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
    }
    return $result;
  }

  public function getCategoriaAlbum($idAlbum){
    $idCategoria;
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT id_categoria FROM album WHERE id = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $idAlbum, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $idCategoria = $result[0]['id_categoria'];
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
    }
    return $idCategoria;
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
      $stmt = $this->close();
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
              }
          }
        }
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
    }
  }

  public function deleteAlbum($nomAlbum){
    try{
    $idAlbum = $this->getIDAlbum($nomAlbum);
    $this->deleteALlImages($idAlbum);
    $this->connect();
    $stmt = $this->conn->prepare("DELETE FROM album WHERE id = ?");
    $bindPos = 0;
    $stmt->bindParam(++$bindPos, $idAlbum, PDO::PARAM_INT);
    $stmt->execute();
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
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
      $stmt = $this->close();
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

        echo '<div class="containerImg">';
        echo '<a class="aContainerImg" href="'.$value['url'].'" rel="lightbox[philippines]" title="'.$nomAlbum.'">';
        echo '<img class="fadeIn animated imgs" width="'.$widthOK.'" height="'.$defaultHeight.'" src="'.$value['url'].'"/>';
        echo "</a>";

        if(!$admin){
          $cookie_name = 'cookie'.$value['id'];
          if(isset($_COOKIE[$cookie_name])){
            if($_COOKIE[$cookie_name] == "false"){
              echo "<img id='cookie".$value['id']."' class='imgLike likeimgs' src ='images/corazon3.png'></img>";
            }else{
              echo "<img id='cookie".$value['id']."' class='imgLiked likeimgs' src ='images/corazon4.png'></img>";
            }
          }else{
            echo "<img id='cookie".$value['id']."' class='imgLike likeimgs' src ='images/corazon3.png'></img>";
          }
          echo '<a class="numLikes" id="numLikes'.$value["id"].'">'.$value['num_likes'].'</a>';
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
      $stmt = $this->close();
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
      $stmt = $this->close();
    }
    return intval($result2);
  }

  private function setLikePhoto($id,$like){
    $result;
    try{
      $idPhoto = substr($id, 6);
      //echo $idPhoto;
      //echo $like;
      $numLikes = $this->getLikesPhoto($idPhoto);
      //echo "<br>Likes Actuals: ".$numLikes;
      if($like == true){
        $numLikes = $numLikes+1;
        //echo "<br>Num Likes".$numLikes;
      }else if ($like == false){
        $numLikes = $numLikes-1;
        //echo "<br>Num Likes".$numLikes;
      }
      $this->connect();
      $stmt = $this->conn->prepare("UPDATE fotografia SET num_likes = ? WHERE id = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $numLikes, PDO::PARAM_INT);
      $stmt->bindParam(++$bindPos, $idPhoto, PDO::PARAM_INT);
      $stmt->execute();

    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
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

  private function getEmails(){
    $result;
    try{
      $this->connect();
      $stmt = $this->conn->prepare("SELECT email FROM emails");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
    }
    return $result;
  }

  public function sendMail($subject,$body){

    require_once("Swiftmailer/Swift-5.1.0/lib/swift_required.php");

    $emails = $this->getEmails();
    $emails_to_send = array();
    foreach ($emails as $key => $value) {
      $emails_to_send[$value['email']] = "receiver";
      //array_push($emails_to_send,$value['email']);
    }

    try{
      $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('estevedalmau1@gmail.com')->setPassword('esteve06');

      $mailer = \Swift_Mailer::newInstance($transport);
      $message = \Swift_Message::newInstance($subject)
         ->setFrom(array('estevedalmau1@gmail.com' => 'Mariona Dalmau Info'))
         ->setTo($emails_to_send)
         ->setBody($body, 'text/html');
      //$result = $mailer->send($message);
    }catch(Exception $ex){
        //die($ex->getMessage()); //Això no funciona per algun motiu....
    }
  }

  ### Funciones Suscribirse/Desuscribirse ###

  public function suscribirse($email){
    $result;
    try{
      $exist = $this->getEmail($email);
      if($exist == ""){
        $this->connect();
        $stmt = $this->conn->prepare("INSERT INTO emails (email) VALUES (?)");
        $bindPos = 0;
        $stmt->bindParam(++$bindPos, $email, PDO::PARAM_STR);
        $stmt->execute();
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
    }
  }

  public function getEmail($email){
    $id = "";
    try{ 
      $this->connect();
      $stmt = $this->conn->prepare("SELECT id FROM emails WHERE email = ?");
      $bindPos = 0;
      $stmt->bindParam(++$bindPos, $email, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($result){
        $id = $result[0]['id'];
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
    }
    return $id;
  }

  public function desuscribirse($email){
    $result;
    try{
      $idEmail = $this->getEmail($email);
      if($idEmail != ""){
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM emails WHERE id = ?");
        $bindPos = 0;
        $stmt->bindParam(++$bindPos, $idEmail, PDO::PARAM_INT);
        $stmt->execute();
      }
    }catch(Exception $e){
      var_dump($e);
    }finally{
      $stmt = $this->close();
    }
  }

}

?>