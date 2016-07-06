<?php
include ("../includes/link.php");

$exist = True;
$linkDB = connectToDataBase();

$queryIDQueue = "SELECT * FROM Queue WHERE ID = '$idQueue'";
do {
  $idQueue = rand();
  $resultIDQueue = $linkDB->query($queryIDQueue);

  if (!($resultIDQueue->num_rows > 0)) {
    $exist = False;
  }
} while ($exist);


$idEntity = $_POST['idEntity'];
$nameQueue = $_POST['nameQueue'];

$sql = "INSERT INTO Queues (ID, IDEntity, Name)" .
 "VALUES ('$idQueue', '$idEntity', '$nameQueue')";

$result = mysqli_query($sql);
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
  <?php include ("../includes/navBar.php");

  if (($linkDB->query($sql) === TRUE)) {

    echo "<h2> Cola creada con éxito </h2>";
    include ("createQRCode.php");

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

  echo "<a href='/queueList.php/?idEntity=$idEntity'>
        <button class='button btn btn-default'> Volver </button></a>";

  include ("../includes/footer.php");
  ?>
</body>
</html>
