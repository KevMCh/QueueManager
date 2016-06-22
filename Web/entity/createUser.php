<?php
require_once ("../includes/authentication/isAuth.php");
if (isAuth()){
  header('Location: /');
}
?>
<html lang="es">
    <head>
        <title>Queue Manager</title>
        <meta charset="UTF-8">
    </head>
<body>
  <body>
    <h1>Crear usuario </h1>
    <form method="post" action="/entity/accept.php">
      Nombre:
      <input type="text" name="name">
      <br>
      Contraseña:
      <input type="text" name="password">
      <br> <br>
      <input type="Submit" name="enviar" value="Aceptar información">
    </form>
  </body>
</body>
</html>
