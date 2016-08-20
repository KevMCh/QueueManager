<?php
require_once ("../includes/link.php");

# Delete a queue and his users.
$idQueue = $_GET['idQueue'];
$idEntity = $_GET['idEntity'];
$linkDB = connectToDataBase();
$sqlQueue = "DELETE FROM Queues WHERE ID = $idQueue";

$file = "temp/" . $idQueue . ".png";
unlink($file);

$resultQueue = mysqli_query($sqlQueue);
$linkDB->query($sqlQueue);

header("Location: /queueList.php/?idEntity=$idEntity");
?>
