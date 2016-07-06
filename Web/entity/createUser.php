<?php
require_once ("../includes/authentication/isAuth.php");
if (isAuth()){
  header('Location: /');
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
<body>
  <body>
    <h1 class="text-center">Crear usuario </h1>
    <form class="login" method="post" action="/entity/accept.php">
      Nombre:
      <br>
      <input type="text" name="name">
      <br>
      Contraseña:
      <br>
      <input type="password" name="password">
      <br> <br>
      <input type="Submit" class='button btn btn-default' name="enviar"
      value="Aceptar información">
    </form>
    <?php
    include ("../includes/footer.php");
    ?>
  </body>
</body>
</html>
