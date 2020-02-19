<?php

session_start();
include_once('../../config.php');

include_once('../../function_connect.php');

include_once('tcpdf_include.php');

extract($_REQUEST);
error_reporting(E_ALL);
$ftp_conn = ftp_connect($ftp_server);
$login = ftp_login($ftp_conn, $ftp_user_name,$ftp_user_pass);
$current_year = select_query_json("Select Poryear From Codeinc", "Centra", 'TCS');
$currentdate = strtoupper(date('d-M-Y h:i:s A'));
if($_REQUEST['action']=='print_pdf')
{ 

$g_tab="MATCHING_COLOR_CHART";  
    $up_fld=array();
    $up_fld['MAILREMK']=strtoupper($remarks);
    $up_fld['EDTUSER']=$_SESSION['tcs_usrcode'];
    $up_fld['EDTDATE']='dd-Mon-yyyy HH:MI:SS AM~~'.$currentdate;
    $where="ENTYEAR='".$entyear."' and ENTNUMB='".$entnumb."' and deleted='N'";  
    $update=update_test_dbquery($up_fld, $g_tab, $where);
	
$filepathname = $nametext;
$filename = "ftp://ituser:S0ft@369@172.16.0.49/matching_color/images/".$filepathname;
//echo $filename;
$handle = fopen($filename, "r");
$contents = file_get_contents($filename);
fclose($handle);
$orderno=explode('-',$order);

  $html= 
  '<html style="border-right: 1px solid black;"><style>html{border-collapse:collapse;border:1px solid black;}</style><body border=1 style="border: 1px solid red;margin-left: 100px;width: 300px;"><div id="wrapper" style="width:900px;height:auto;margin:0 auto;">
 
  
			<table border=1 style="padding-top:10px;margin-top:40px">
	<tr>
	<td align="center"><label style="color:red;font-size:20px;font-family: freehand471,Helvetica Neue,Helvetica,Arial;font-weight:bold;"><i><img src ="../../../img/logo.png" class="img-responsive" style="width:100%;height:100%;padding-top:-10px;padding-left:10px"/>  The Chennai Silks</i></label></td>
	
	</tr>
	<tr>
	<td align="center"><label > 74-c New Market Street, Tirupur-641 604. <br> TNGST No. : 33022324637 CST : 911506 Dt.22.10.07
			   </label></td>
	</tr>
	
	</table>
	<hr>
	 <table  class="table-responsive"  style="padding-top:10px;font-size:10px;">
	<tr>
	<td align="left"><label>Order No   :</label> '.$orderno[0]. ' / ' .$orderno[1].' </td>
	<td align="left"><label>Supplier Name  :</label> '.$supplier.' </td>
	</tr>
	<tr>
	<td align="left"><label>Order Year  :</label> '.$orderno[0].'</td>
	<td align="left"><label>Supplier Mail Id  :</label> '.$mailid.'</td>
	</tr>
	
	</table>
	
<hr>
	
	
			 
	
	<table  class="table-responsive" align="center" style="padding-top:20px;margin-top:60px">
	<tr >
	<td  align="center">'.$contents.'</td>
	</tr>
	</table>
	
	<table  style="padding-top:10px;margin-top:40px">
	<tr>
	<td  align="left"><label style="font-style:oblique;">Remarks   :  </label>'.strtoupper($remarks).'</td>
	</tr>
	
	</table>
	
	</div></body></html>';

	
//echo $html;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



$pdf->AddPage('P', 'A4');

$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$date=date('dmhisa');
$pdf_string = $pdf->Output('pseudo.pdf', 'I');
//file_put_contents('supppdf/myfile_'.$date.'.pdf', $pdf_string);
file_put_contents('ftp://ituser:S0ft@369@172.16.0.49/color_chart_pdf/myfile_'.$date.'.pdf', $pdf_string);
//$url='ftp://ituser:S0ft@369@172.16.0.49/color_chart_pdf/myfile_'.$date.'.pdf';

//include_once('../../config.php');
//include_once('../../function_connect.php');

//$filename = 'myfile';
  //  $path = $url;
 //   $file = $path;
//$content = file_get_contents('ftp://ituser:S0ft@369@172.16.0.49/color_chart_pdf/myfile_'.$date.'.pdf');
//print_r($content);
//$content = chunk_split(base64_encode($content));
$subject1="Color Chart Details Reg";
//echo $html;

//echo $content;
$mail_body1 .= "Good Day Sir, <BR> You Have Received Color Chart Details for the Order No : ".$orderno[0]. ' / ' .$orderno[1]."<BR><BR><label>Remarks : </label>  ".strtoupper($remarks)."<br><br><br>Thanks & Regards,<BR>The Chennai Silks.<BR>";
//$mail_body1 .= $content;
//$mail_body1 = "Good Day Sir, <BR> We have attached the color chart details for the order no <BR> ".preg_replace( '/(\s){2,}/s', '', $html )"";
//echo $mail_body1;
$to_email = "29001@thechennaisilks.com";

$sql_mailsend = store_procedure_query_json("PROC_APP_MAIL_SENDING('".$subject1."','".$mail_body1."','0','".$_SESSION['tcs_usrcode']."','".$to_email."','1','APPDESK')", 'Req', 'TCS'); 

echo $sql_mailsend;



/*require_once('../PHPmailer/class.phpmailer.php');

$mail = new PHPMailer();   
//echo $mail;                 
$mail->From = "20156@thechennaisilks.com";
$mail->FromName = "The Chennai Silks";
$mail->AddAddress("20156@thechennaisilks.com");
$mail->AddReplyTo("29001@thechennaisilks.com", "The Chennai Silks");               
$mail->AddAttachment("supppdf/myfile_".$date.".pdf");      
// attach pdf that was saved in a folder
$mail->Subject = "Color Chart Details Reg";                  
$mail->Body = "You have received the mail for color chart details";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
   echo "Message sent";
} */
//$pdf->Output('supppdf/test.pdf','D');
//$pdf->Output("D", '//172.16.0.49/websites/phpsite/lib_dash/tcpdf\examples\supppdf/' . date("d-m-Y")."-".date("h:ia").".pdf");
//$pdf->Output('doc.pdf', 'D');
//$pdf->Output("../../uploads/supplier_pdf/doc.pdf", "F");

//var_dump($pdf);
}?>