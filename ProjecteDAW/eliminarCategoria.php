<?php
	include 'funcions.php';
    $funcions = new funcionsClass();
	$nomCategoria = $_POST['categoria'];

	$funcions->deleteCategoria($nomCategoria);
	header('Location: indexAdmin.php');
?>