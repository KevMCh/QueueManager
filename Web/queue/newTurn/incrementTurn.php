<?php
include ("../../includes/link.php");

$idQueue = $_POST['idQueue'];
$name = $_POST['name'];
$turn = $_POST['turn'] + 1;
$idEntity = $_POST['idEntity'];

header('refresh:0; url=/listOfUser.php/?idQueue='.urlencode($idQueue));

$linkDB = connectToDataBase();

$queryUser = "SELECT * FROM UsersQueue WHERE Position >= $turn AND " .
             "IDQueue = $idQueue";

$resultUser = $linkDB->query($queryUser);

if ($resultUser && $resultUser->num_rows > 0) {

  $queryIncrement = "UPDATE Queues SET Turn = $turn WHERE Name = '$name' AND " .
                    "Turn = ($turn - 1) AND IDEntity = $idEntity";

  $resultIncrement = $linkDB->query($queryIncrement);
}
disconnectDataBase($linkDB);
?>
