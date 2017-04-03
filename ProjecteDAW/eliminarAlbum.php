<?php
	include 'funcions.php';
    $funcions = new funcionsClass();
	$nomAlbum = $_POST['album'];

	$funcions->deleteAlbum($nomAlbum);
	header('Location: indexAdmin.php');

?>