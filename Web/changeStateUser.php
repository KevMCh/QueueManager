<?php
include ("includes/link.php");
include ("includes/authentication/isAuth.php");

if (!isAuth()){
  header('Location: /');
}

$idQueue = $_POST['idQueue'];
header('refresh:1; url=/listOfUser.php/?idQueue='.urlencode($idQueue));

$idUser = $_POST['idUser'];
$attended = $_POST['attended'];

$newState = !($attended);

$linkDB = connectToDataBase();
$query = "UPDATE UsersQueue SET Attended = '$newState'
          WHERE IDQueue = '$idQueue' AND IDUser = '$idUser'
          AND Attended = '$attended'";
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
  <img src="/includes/logo.png" alt="logo" height="500" width="500">
  <?php
  if ($linkDB->query($query) === TRUE) {
  ?>
  <h2>Cambio realizado correctamente </h2>
  <p>Redireccionando.. </p>
  <?php
  } else {
  ?>
  <h2>Uppss.. ¡Que vergüenza!</h2>
  <p>Nos hemos encontrado con errores en nuestro servidor,
    por favor contacta con tu administrador.</p>
  <br>
  <h4>Error:</h4>
  <br>
  <?php
  echo $linkDB -> error;
  }
  include ("includes/footer.php");
  ?>
</body>
</html>
