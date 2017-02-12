<?php
	function DBConnection(){
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

	function nomAlbum(){
		$conn = DBConnection();
		$sql = "SELECT * FROM album WHERE id = '".$_GET["album"]."'";
	    $result = $conn->query($sql);

	    $row = mysqli_fetch_array($result);
	    return $row['nom'];
	}
	/* $sql = "SELECT * FROM album WHERE id = '".$_GET["album"]."'";
          $result = $conn->query($sql);

          while($row = mysqli_fetch_array($result)){
            echo '<h3 id="albumSelected">'.$row['nom'].'</h3>';
          }
*/



?>