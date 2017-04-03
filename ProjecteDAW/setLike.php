<?php
include 'funcions.php';
$funcions = new funcionsClass();
$id = $_POST['id'];
//$id = 3;

$result = $funcions->setLike($id);
echo $result;

?>