<?php
require_once ("includes/authentication/isAuth.php");
require_once ("includes/authentication/login.php");
require_once ("includes/link.php");

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
      } else {
        echo 'Nombre de usuario o contraseña incorrectos';
      }
    } else {
      echo 'Rellene todos los campos de texto';
    }
  }
  ?>
  <html lang="es">
  <head>
    <title>Queue Manager</title>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php
    include ("/includes/navBar.php");
    ?>
    <h1> Queue Manager </h1>
    <form method="post" action="/">
      Nombre:
      <input type="text" name="name">
      <br>
      Contraseña:
      <input type="text" name="password">
      <br> <br>
      <input type="Submit" name="enviar" value="Acceder">
    </form>
    <a href="/entity/createUser.php"> Nuevo usuario <a>
</body>
</html>
