<?php
include ("../includes/link.php");
include ("includes/navBar.php");

$idQueue = rand();
$idEntity = $_POST['idEntity'];
$nameQueue = $_POST['nameQueue'];

$sql = "INSERT INTO Queues (ID, IDEntity, Name)" .
 "VALUES ('$idQueue', '$idEntity', '$nameQueue')";

$result = mysqli_query($sql);

$linkDB = connectToDataBase();

if ($linkDB->query($sql) === TRUE) {
  echo "<h2> Cola creada con exito </h2>";
  include ("createQRCode.php");

} else {
  echo "<h3>Error:</3> " . $sql . "\n" . $linkDB->error;
}

echo "<a href='/queueList.php/?idEntity=$idEntity'><button> Volver </button></a>"
?>
