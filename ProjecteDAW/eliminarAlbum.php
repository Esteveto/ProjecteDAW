<?php
	include 'funcions.php';
    $funcions = new funcionsClass();
	$nomAlbum = $_POST['album'];
	//echo $nomAlbum;

	$funcions->deleteAlbum($nomAlbum);
	header('Location: indexAdmin.php');

?>