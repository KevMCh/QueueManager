<?php
require_once ("../includes/link.php");
$linkDB = connectToDataBase();

$idQueue = urldecode($_POST['idQueue']);
$idUser = urldecode($_POST['idUser']);
$tokenFCM = urldecode($_POST['tokenFCM']);
$selectedPositionNotification = urldecode($_POST['positionNotification']);

$queryQueue = "SELECT * FROM Queues WHERE ID = $idQueue";
$resultQueue = $linkDB->query($queryQueue);

if ($resultQueue && ($resultQueue->num_rows > 0)) {
  # Obtains the data for the turn
  $queryNumUser = "SELECT * FROM UsersQueue WHERE IDQueue = $idQueue";
  $resultNumUser = $linkDB->query($queryNumUser);
  $position = $resultNumUser->num_rows;
  $objDateTime = new DateTime('NOW');
  $time = $objDateTime -> format('c');

  # Checking the notification position
  $queueDatas = $resultQueue->fetch_row();
  $positionNotification = $position - $selectedPositionNotification;
  if($queueDatas[3] > $positionNotification){
    $positionNotification = $queueDatas[3] + 1;
  }

  # Insert the user
  $sqlUserQueue = "INSERT INTO UsersQueue (Position, IDQueue, IDUser, HasBeenCreated, Attended, PositionNotification) " .
                  "VALUES ('$position', '$idQueue', '$idUser', '$time', '0', '$positionNotification')";

  $resultUserQueue = mysqli_query($sqlUserQueue);
  $linkDB -> query($sqlUserQueue);

  # Create or update the token for the notification.
  $result = $linkDB -> query("SELECT * FROM Users
                              WHERE ID = '$idUser'");
  if ($result && $result->num_rows > 0){
    $sqlUserQueueUpdate = "UPDATE Users SET TokenFCM = '$tokenFCM' " .
                          "WHERE ID = '$idUser'";

    $resultUserQueueUpdate = mysqli_query($sqlUserQueueUpdate);
    $linkDB -> query($sqlUserQueueUpdate);

  } else {
    $sqlUsersDetails = "INSERT INTO Users (ID, TokenFCM) " .
                       "VALUES ('$idUser', '$tokenFCM')";

    $resultUsersDetails = mysqli_query($sqlUsersDetails);
    $linkDB -> query($sqlUsersDetails);
  }

  echo 200;
} else {
  echo 404;
}

disconnectDataBase($linkDB);
?>
