<?php
require_once ("../includes/link.php");
$linkDB = connectToDataBase();

$idQueue = urldecode($_POST['idQueue']);
$idUser = urldecode($_POST['idUser']);

$queryQueue = "SELECT * FROM Queues WHERE ID = $idQueue";
$resultQueue = $linkDB->query($queryQueue);

if ($resultQueue && ($resultQueue->num_rows > 0)) {
  $queryNumUser = "SELECT * FROM UsersQueue WHERE IDQueue = $idQueue";
  $resultNumUser = $linkDB->query($queryNumUser);
  $position = $resultNumUser->num_rows;

  $sql = "INSERT INTO UsersQueue (Position, IDQueue, IDUser, Attended)" .
         "VALUES ('$position', '$idQueue', '$idUser', '0')";

  $result = mysqli_query($sql);
  $linkDB->query($sql);

  $resultQueue -> close();
  $resultQueue -> close();
  $result -> close();

  echo 200;
} else {
  echo 404;
}

disconnectDataBase($linkDB);
?>
