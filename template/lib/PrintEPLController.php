<?php

include_once('WebClientPrint.php');

use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\ClientPrintJob;
 
extract($_REQUEST);



$urlParts = parse_url($_SERVER['REQUEST_URI']);

if (isset($urlParts['query'])) 
{
	
	$rawQuery = $urlParts['query'];
    parse_str($rawQuery, $qs);
	
	
    if (isset($qs[WebClientPrint::CLIENT_PRINT_JOB])) 
	
	{
			$useDefaultPrinter = ($qs['useDefaultPrinter'] === 'checked');
        	$printerName = urldecode($qs['printerName']);
			$barcodedet=$entyear.'-'.$entno;		
				
			$mechCmds .= chr(2)."m".chr(13);
			$mechCmds .= chr(2)."L".chr(13);										
			$mechCmds .= "D11".chr(13);
			$mechCmds .= "PK".chr(13);
			$mechCmds .= "SK".chr(13);
			$mechCmds .= "ySW1".chr(13);
			$mechCmds .= "A2".chr(13);
			
			$mechCmds .= "191100302500030Product:'".$prdname.chr(13);
			$mechCmds .= "191100301800180STYLE NO:'".$styleno.chr(13);
			
			if($DP=="E"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}else if($DP=="D"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}else if($DP=="I"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}else if($DP=="M"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}else if($DP=="C"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}else if($DP=="W"){
				$mechCmds .= "1W1D4400000400050L'".$barcodedet.chr(13);
			}
			
			
			$mechCmds .= "191100301000180DATE   :'".$addate.chr(13);
		
			$mechCmds .="E".chr(13);

			$cmds = $mechCmds;
			
			echo $cmds;
				
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
	}
	
}

?>
