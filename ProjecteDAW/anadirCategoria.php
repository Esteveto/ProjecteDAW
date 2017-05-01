<!DOCTYPE html>
  <?php
    include 'funcions.php';
    $funcions = new funcionsClass();
    $nomCategoria = $_GET["categoria"];
    $funcions->insertCategoria($nomCategoria);

    $body = "<h1 style='color:red'>Nueva Categoria</h1><p>Mariona Dalmau ha añadido una nueva categoria($nomCategoria) a su pagina</p>";
    $funcions->sendMail("Nueva Categoria!",$body);

    header('Location: indexAdmin.php');
?>

