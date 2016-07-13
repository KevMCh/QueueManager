<?php
include_once ("../../includes/link.php");
include_once ("../../includes/notifyUser.php");

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
    $attendedClient = $linkDB -> query($queryAttendedClient);
  }

  while ($client = $resultUser -> fetch_row()) {
    if(!$client[4]){

      $idClient = $client[2];
      $queryToken = "SELECT * FROM Users WHERE ID = '$idClient'";
      $resultUserToken = $linkDB -> query($queryToken);

      if ($resultUserToken && $resultUserToken->num_rows > 0) {
        $rowDetailsUser = $resultUserToken -> fetch_row();

        if($turn == ($client[0] - ($client[5] + 1)) ){
          $tokens = array();
          $tokens[] = $rowDetailsUser[1];
          $message = $name . ": Queda(n) " . $client[5] .
                     " turnos para que le atiendan.";

          $message_status = sendNotification($tokens, $message);
          echo $message_status;
        }
      }
    }
  }
}
disconnectDataBase($linkDB);
?>
