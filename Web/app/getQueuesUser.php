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
    $turn = $rowQueue[3];

    # Get the name of the entity
    $queryNameEntity = "SELECT * FROM Entitys WHERE ID = '$idEntity'";
    $resultEntity = mysqli_query($linkDB, $queryNameEntity);
    $rowEntity = mysqli_fetch_array($resultEntity);
    $nameEntity = $rowEntity[1];

    # Create the array of data
    $queryUser = "SELECT * FROM UsersQueue WHERE IDUser = '$idUser' " .
                 "AND IDQueue = $id ORDER BY HasBeenCreated DESC";
    $resultUser = $linkDB->query($queryUser);

    if ($resultUser && ($resultUser->num_rows > 0)) {

      while ($rowUser = mysqli_fetch_array($resultUser)) {
        $position = $rowUser[0];
        $idUser = $rowUser[2];
        $hasBeenCreated = $rowUser[3];

        $rawdata[] = array('NameEntity' => $nameEntity, 'NameQueue' => $name,
        'Turn' => $turn, 'Position' => $position, 'Date' => $hasBeenCreated);
      }
    }
}

$allQueues = array('Queues' => $rawdata);

disconnectDataBase($linkDB);

echo json_encode($allQueues);
?>
