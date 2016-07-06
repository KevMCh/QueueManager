<?
include ("../includes/authentication/isAuth.php");
if (!isAuth()){
  header('Location: /index.php');
}
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = '/queue/temp/';

include "phpqrcode.php";

if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);

$filename = $PNG_TEMP_DIR.'test.png';
$defaultCorrectionLevel = 'H';
$matrixPointSize = 10;


if ($idEntity) {
    $filename = $PNG_TEMP_DIR.$idQueue.'.png';
    QRcode::png($idQueue, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
} else {
    echo '<h4>Error, we can´t create a QR code </h4>';
}

echo '<img class="qrImage" src="'.$PNG_WEB_DIR.basename($filename).'"/><br><br>';
echo "<h4>Nombre:</h4> <p>$nameQueue</p>";
echo "<h4>Identificador:</h4> <p>$idQueue</p>";
?>
