<!DOCTYPE html>
<?php
	include 'funcions.php';
	$funcions = new funcionsClass();

	$nomAlbum = $_POST['albumPadre'];
	$imgs = $_FILES['imgs'];
	$funcions->addImgsAlbum($imgs,$nomAlbum);
	$body = "<h1 style='color:red'>Nuevas fotografias</h1><p>Mariona Dalmau ha añadido nuevas fotografias al álbum $nomAlbum de su página web</p>";
	$funcions->sendMail("Nuevas Fotografias!",$body);
	header('Location: indexAdmin.php');
?>

