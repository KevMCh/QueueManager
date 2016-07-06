<?php
require_once ("../includes/link.php");

$idQueue = $_GET['idQueue'];
$idEntity = $_GET['idEntity'];
$linkDB = connectToDataBase();
$sqlQueue = "DELETE FROM Queues WHERE ID = $idQueue";
$sqlUser = "DELETE FROM UsersQueue WHERE IDQueue = $idQueue";

$file = "temp/" . $idQueue . ".png";
unlink($file);

$resultQueue = mysqli_query($sqlQueue);
$resultUser = mysqli_query($sqlUser);
$linkDB->query($sqlQueue);
$linkDB->query($sqlUser);

header("Location: /queueList.php/?idEntity=$idEntity");
?>
