<?php
include 'WebClientPrint.php';
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\ClientPrintJob;
$barcodedet='2019-20';
//...
$mechCmds .= chr(2)."m".chr(13);
$mechCmds .= chr(2)."L".chr(13);										
$mechCmds .= "D11".chr(13);
$mechCmds .= "PK".chr(13);
$mechCmds .= "SK".chr(13);
$mechCmds .= "ySW1".chr(13);
$mechCmds .= "A2".chr(13);

$mechCmds .= "191100302500030Product:'".'TEST PRODUCT'.chr(13);
$mechCmds .= "191100301800180STYLE NO:'".'TEST STYLE'.chr(13);

$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);



$mechCmds .= "191100301000180DATE   :'".'24-01-2020'.chr(13);
$cmds=$mechCmds;
/*Dynacmic Barcode End */
			//Create a ClientPrintJob obj that will be processed at the client side by the WCPP
$cpj = new ClientPrintJob();
//set EPL commands to print...
$cpj->printerCommands = $cmds;
$cpj->formatHexValues = true;
// if ($useDefaultPrinter || $printerName === 'null') {
// 	$cpj->clientPrinter = new DefaultPrinter();
// } else {
// 	$cpj->clientPrinter = new InstalledPrinter($printerName);
// }
$cpj->clientPrinter = new DefaultPrinter();
ob_start();
ob_clean();
header('Content-type: application/octet-stream');
echo $cpj->sendToClient();
ob_end_flush();
exit();

//...
?>
