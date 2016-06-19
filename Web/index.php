<?php
include ("includes/authentication/isAuth.php");
include ("includes/authentication/login.php");
include ("includes/link.php");
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <?php
    include ("includes/navBar.php");
    ?>
    <h1> Queue Manager </h1>
    <?php
    if (isAuth()) {
      $user = $_SESSION['user'];
      echo "<a href='/queueList.php/?idEntity=$user'> Acceder <a>";
      // header('Location: queueList.php');
      exit;
    } else if($_POST) {
      if(!empty($_POST['name']) && !empty($_POST['password'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];

        if(login($name, $password)) {
          echo 'Autentificación correcta';
          header("Location: http://www.facebook.com");
          exit;
        } else {
          echo 'Nombre de usuario o contraseña incorrectos';
        }
      } else {
        echo 'Rellene todos los campos de texto';
      }
    }
    ?>
    <form method="post" action="/">
      Nombre:
      <input type="text" name="name">
      <br>
      Contraseña:
      <input type="text" name="password">
      <br> <br>
      <input type="Submit" name="enviar" value="Acceder">
    </form>
    <a href="/newEntity/createUser.php"> Nuevo usuario <a>
  </body>
</body>
</html>
