<?php
require_once ('fpdf/fpdf.php');
require_once ("../includes/link.php");
$linkDB = connectToDataBase();

$idQueue = $_GET['idQueue'];
$idEntity = $_GET['idEntity'];

$ticket = new FPDF('P', 'mm', array(100, 100));
$ticket -> AddPage();
$ticket -> setTitle("Turn-Time");

$queryQueue = "SELECT * FROM Queues WHERE ID = $idQueue";
$resultQueue = $linkDB->query($queryQueue);

if ($resultQueue && ($resultQueue->num_rows > 0)) {
  $rowQueue = $resultQueue -> fetch_row();
  $nameQueue = $rowQueue[2];

  $queryNumUser = "SELECT * FROM UsersQueue WHERE IDQueue = $idQueue";
  $resultNumUser = $linkDB->query($queryNumUser);
  $position = $resultNumUser->num_rows;
  $objDateTime = new DateTime('NOW');
  $time = $objDateTime -> format('c');

  $sqlUserQueue = "INSERT INTO UsersQueue (Position, IDQueue, HasBeenCreated, Attended, PositionNotification) " .
                  "VALUES ('$position', '$idQueue', '$time', '0', '$position')";

  $resultUserQueue = mysqli_query($sqlUserQueue);
  $linkDB -> query($sqlUserQueue);
}

#Header
$ticket -> SetFont('Arial', 'B', 30);
$ticket -> Cell(15);
$ticket -> Cell(60, 18, 'Turn-Time', 1, 0, 'C');
$ticket -> Ln(20);
$ticket -> Image('../includes/logo.png', 1, 2, 25);
$ticket -> Ln();
$ticket -> Line(0, 40, 300, 40);

#Details
$ticket -> SetFont('Arial', 'B', 12);
$ticket -> Write(7, 'Position: ');
$ticket -> SetFont('Arial', '', 12);
$ticket -> Write(7, "$position");
$ticket -> Ln();

$ticket -> SetFont('Arial', 'B', 12);
$ticket -> Write(8, 'Nombre de la cola: ');
$ticket -> SetFont('Arial', '', 12);
$ticket -> Write(8, "$nameQueue");
$ticket -> Ln();

$ticket -> SetFont('Arial', 'B', 12);
$ticket -> Write(8, 'Identificador de la cola: ');
$ticket -> SetFont('Arial', '', 12);
$ticket -> Write(8, "$idQueue");
$ticket -> Ln();

$ticket -> SetFont('Arial', 'B', 12);
$ticket -> Write(8, 'Fecha: ');
$ticket -> SetFont('Arial', '', 12);
$ticket -> Write(8, "$time");

$ticket -> Line(0, 80, 300, 80);

$ticket -> Output();
exit;
?>
