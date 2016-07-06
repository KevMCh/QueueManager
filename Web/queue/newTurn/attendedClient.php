<?php
include ("../../includes/link.php");

$idQueue = $_POST['idQueue'];
$name = $_POST['name'];
$turn = $_POST['turn'];
$idEntity = $_POST['idEntity'];

header('refresh:0; url=/listOfUser.php/?idQueue='.urlencode($idQueue));

$linkDB = connectToDataBase();

$queryUser = "SELECT * FROM UsersQueue WHERE Position >= $turn AND " .
             "IDQueue = $idQueue";

$resultUser = $linkDB->query($queryUser);

if ($resultUser && $resultUser->num_rows > 0) {

  $queryIncrement = "UPDATE Queues SET Turn = ($turn + 1) WHERE Name = '$name' AND " .
                    "Turn = $turn AND IDEntity = $idEntity";

  $resultIncrement = $linkDB->query($queryIncrement);

  $rowUser = $resultUser -> fetch_row();
  if($rowUser[0] == $turn) {
    $queryAttendedClient = "UPDATE UsersQueue SET Attended = '1' " .
                           "WHERE IDQueue = '$idQueue' AND IDUser = '$rowUser[2]' " .
                           "AND Attended = '0'";
    $attendedClient = $linkDB->query($queryAttendedClient);
  }
}
disconnectDataBase($linkDB);
?>
