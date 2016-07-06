<?php
require_once ("../includes/link.php");
header('refresh:5; url=/');

$name = $_POST['name'];
$password = $_POST['password'];
$linkDB = connectToDataBase();
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
  $queryUser = "SELECT * FROM Entitys WHERE Name = '$name'";
  $resultUser = $linkDB->query($queryUser);

  if (!$resultUser || $resultUser->num_rows == 0) {
    $sql = "INSERT INTO Entitys (Name, Password)" .
           "VALUES ('$name', '$password')";

    $result = mysqli_query($sql);
    if ($linkDB->query($sql) === TRUE) {
      ?>
        <h1>Bienvenido </h1>
        <h5>¡Ya tienes tú cuenta!<h5>
        <p>En breve serás redirigido a la página principal.</p>
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
  } else {
  ?>
    <h2>Uppss.. ¡Que vergüenza!</h2>
    <p>Lo sentimos, el nombre de usuario que ha escogido ya esta ocupado</p>
  <?php
  }
  disconnectDataBase($linkDB);
  include ("../includes/footer.php");
  ?>
</body>
</html>
