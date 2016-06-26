<?php
require_once ("../includes/link.php");
$linkDB = connectToDataBase();

mysqli_set_charset($linkDB, "utf8");

$idUser = urldecode($_POST['idUser']);
$queryQueues = "SELECT * FROM Queues";

if(!$resultQueues = mysqli_query($linkDB, $queryQueues)) die();
$rawdata = array();

while ($rowQueue = mysqli_fetch_array($resultQueues)) {
    $id = $rowQueue[0];
    $idEntity = $rowQueue[1];
    $name = $rowQueue[2];

    $queryUser = "SELECT * FROM UsersQueue WHERE IDUser = '$idUser'" .
                 "AND IDQueue = $id";
    $resultUser = $linkDB->query($queryUser);

    if ($resultUser && ($resultUser->num_rows > 0)) {

      $queryUsers = "SELECT * FROM UsersQueue WHERE IDQueue = $id";

      if(!$resultUsers = mysqli_query($linkDB, $queryUsers)) die();
      $listUsers = array();

      while ($rowUser = mysqli_fetch_array($resultUsers)) {
        $position = $rowUser[0];
        $idQueue= $rowUser[1];
        $idUser = $rowUser[2];
        $attended = $rowUser[3];

        $listUsers[] = array('Position' => $position, 'IDQueue' => $idQueue,
        'IDUser' => $idUser, 'Attended' => $attended);
      }

      $rawdata[] = array('ID' => $id, 'IDEntity' => $idEntity, 'Name' => $name,
      'ListUsers' => $listUsers);
    }
}

$allQueues = array('Queues' => $rawdata);

disconnectDataBase($linkDB);

echo json_encode($allQueues);
?>
