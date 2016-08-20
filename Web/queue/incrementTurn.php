<?php
include_once ("../includes/link.php");
include_once ("../includes/notifyUser.php");

$idQueue = $_POST['idQueue'];
$name = $_POST['name'];
$turn = $_POST['turn'];
$idEntity = $_POST['idEntity'];
$userAttended = $_POST['userAttended'];

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
  if(($rowUser[0] == $turn) && ($userAttended == 'True')) {
    $queryAttendedClient = "UPDATE UsersQueue SET Attended = '1' " .
                           "WHERE IDQueue = '$idQueue' AND Attended = '0' " .
                           " AND Position = '$turn'";
    $attendedClient = $linkDB -> query($queryAttendedClient);
  }
  $queryEntity = "SELECT * FROM Entitys WHERE ID = $idEntity";
  $resultEntity = $linkDB->query($queryEntity);
  $rowDetailsEntity = $resultEntity -> fetch_row();

  while ($client = $resultUser -> fetch_row()) {
    if(!$client[4]){

      $idClient = $client[2];
      $queryToken = "SELECT * FROM Users WHERE ID = '$idClient'";
      $resultUserToken = $linkDB -> query($queryToken);

      if ($resultUserToken && $resultUserToken->num_rows > 0) {
        $rowDetailsUser = $resultUserToken -> fetch_row();

        if(($turn + 1) == $client[5]){
          $tokens = array();
          $tokens[] = $rowDetailsUser[1];
          $message = $name . ": Queda(n) " . ($client[0] - $client[5]) .
                     " turnos para que le atiendan.";

          $message_status = sendNotification($tokens, $message, $rowDetailsEntity[1],
                                  $name, ($turn + 1), $client[0], $client[3]);
          echo $message_status;
        }
      }
    }
  }
}
disconnectDataBase($linkDB);
?>
