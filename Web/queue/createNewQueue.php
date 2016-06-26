<?php
include ("../includes/link.php");
include ("includes/navBar.php");

$exist = True;
$linkDB = connectToDataBase();
do {
  $idQueue = rand();

  $queryIDQueue = "SELECT * FROM Queue WHERE ID = '$idQueue'";
  $resultIDQueue = $linkDB->query($queryIDQueue);

  if (!$resultIDQueue && !($resultIDQueue->num_rows > 0)) {
    $exist = False;
  }
} while ($exist);


$idEntity = $_POST['idEntity'];
$nameQueue = $_POST['nameQueue'];

$sql = "INSERT INTO Queues (ID, IDEntity, Name)" .
 "VALUES ('$idQueue', '$idEntity', '$nameQueue')";

$result = mysqli_query($sql);

if ($linkDB->query($sql) === TRUE) {
  echo "<h2> Cola creada con exito </h2>";
  include ("createQRCode.php");

} else {
  echo "<h3>Error:</3> " . $sql . "\n" . $linkDB->error;
}

echo "<a href='/queueList.php/?idEntity=$idEntity'><button> Volver </button></a>"
?>
