<html lang="es">
<head>
  <title>Queue Manager</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/includes/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body class="text-center">
  <img src="/includes/logo.png" alt="logo" height="500" width="500">
  <?php
  require_once ("isAuth.php");
  if (isAuth()) {
    if (!isset($_SESSION)){
      session_start();
    }

    unset($_SESSION['user']);
    session_destroy();
  ?>
  <h2> Gracias por elegirnos para gestionar tus turnos </h2>
  <p> Hemos cerrado correctamente su sesión, esperamos verte de vuelta pronto.</p>
  <p> En el caso de que desee iniciar su cuenta de nuevo cliquee en el siguiente enlace.
    <a href="/" class="textGold"> Iniciar nueva sesión.</a>
  </p>
  <?php
} else {
  ?>
  <h2>Uppss.. ¡Que vergüenza!</h2>
  <p>No hemos encontrado ninguna cuenta activa </p>
  <?php
}
?>
</body>
</html>
