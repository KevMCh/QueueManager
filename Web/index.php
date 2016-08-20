<?php
require_once ("includes/authentication/isAuth.php");
require_once ("includes/authentication/login.php");
require_once ("includes/link.php");

include ("/includes/navBar.php");
if (isAuth()) {
  $user = $_SESSION['user'];
  header("Location: /queueList.php/");
} else if($_POST) {
  if(!empty($_POST['name']) && !empty($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    if(login($name, $password)) {
      $user = $_SESSION['user'];
      header("Location: /queueList.php/");
    }
  }
}
?>
<html lang="es">
<head>
  <title>Turn - Time</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/includes/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body class="text-center">
  <main>
    <img src="/includes/logo.png" alt="logo" height="500" width="500">

    <?php
    if (!isAuth() && ($_POST)) {
      if(!empty($_POST['name']) && !empty($_POST['password'])) {

        if(!login($name, $password)) {
          echo '<h3 class="error">Nombre de usuario o contraseña incorrectos</h3>';
        }
      } else {
        echo '<h3 class="error">Rellene todos los campos de texto</h3>';
      }
    }
    ?>
    <form class="login" method="post" action="/" id="login">
      Nombre:
      <br>
      <input type="text" name="name">
      <br>
      Contraseña:
      <br>
      <input type="password" name="password">
      <br> <br>
      <input type="Submit" class='button btn btn-default' name="enviar"
      value="Acceder">
      <a href="/entity/createUser.php" class="textGold"> Nuevo usuario <a>
    </form>

    <a href="/listQueueClient.php" class="button btn btn-default textGold">
      Entrar como cliente
    <a>
    </main>
    <?php
    include ("includes/footer.php");
    ?>
  </body>
</html>
