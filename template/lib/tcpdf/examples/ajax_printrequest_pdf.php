<?php

session_start();
include_once('../../config.php');

include_once('../../function_connect.php');

include_once('tcpdf_include.php');
extract($_REQUEST);

$html2 = file_get_contents('http://www.tcsportal.com/approval-desk/print_request_testpdf.php?action=view&reqid=8086&year=2019-20&rsrid=1&creid=4&typeid=4');
//$html1=htmlspecialchars($html1);
$html1 = new DOMDocument;
$html1->loadHTML($html2);
/*
$selected_list=json_decode($arraystr);
$current_yr = select_query_json("Select Poryear From Codeinc", "Centra", 'TCS');
$seltrnnumb=select_query_json("select max(trnnumb) trnnumb from fund_transfer_summary where trnyear='".$current_yr[0]['PORYEAR']."'","Centra","TEST");
$execute="";$srexecute="";$audit="";
if($executive!=""){
  $exec=explode('-',$executive);
  $execute=$exec[1];
}
if($sr_executive!=""){
  $sr_exec=explode('-',$sr_executive);
  $sr_execute=$sr_exec[1];
}
if($auditor!=""){
  $aud=explode('-',$auditor);
  $audit=$aud[1];
}

$brnnic=select_query_json("select brnnicn from branch_bank_account where bencode='".$frm_bencode."'","Centra","TEST");
$html='<table width="100%">
                  <tr>
                    <td>
                    <table cellpadding="5" border="1"  style="font-size:10px !important">  
                    <thead>
                     <tr bgcolor="#fcc837" color="#000" valign="center">
                       <td align="center" valign="center" style="border: 1px solid #000;font-weight:bold;" width="5%">S.No</td>
                       <td align="center" style="border: 1px solid #000;font-weight:bold" width="10%">VALUE DT(M)</td>
                       <td align="center" style="border: 1px solid #000;font-weight:bold" width="15%">BENEFICIARY BRANCH IFSC(M)</td>
                       <td align="center" style="border: 1px solid #000;font-weight:bold" width="20%">BENEFICIARY CUSTOMER ACCOUNT NUMBER(M)</td>
                       <td align="center" style="border: 1px solid #000;font-weight:bold" width="20%">BENEFICIARY CUSTOMER ACCOUNT NAME(M)</td>
                       <td align="center" style="border: 1px solid #000;font-weight:bold" width="20%">BENEFICIARY CUSTOMER BANK NAME(M)</td>  
                       <td align="center"style="border: 1px solid #000;font-weight:bold" width="10%">AMOUNT(M)</td> 
                     </tr>
                   </thead>
                   <tbody>';
                    $totalamt=0; $cnt=0; 
                  for($i=0;$i<count($selected_list);$i++){

                 
                  $paycode=explode('-',$selected_list[$i][1]);
                  $bnkcode=explode('-',$selected_list[$i][3]);
              
                  $select_list=select_query_json("select substr(to_char(sysdate,'dd/MM/yyyy'),1,10) Value_date,substr(acc.accname,1,35) BENEFICIARY_NAME,substr(acc.RTGSIFS,1,15) BENEFICIARY_IFSC_CODE,substr(acc.ACCNUMB,1,25) BENEFICIARY_AC_NO,acc.bnkname bene_bank,summ.PAYTAMT AMOUNT,summ.payyear pay_details1,summ.paynumb pay_details2, 
sup.supcode customer_reference,nvl(sup.supadd1,'-') supadd1,nvl(sup.supadd2,'-') supadd2,nvl(sup.supadd3,'-') supadd3,scty.ctyname supadd4,nvl(sup.suppinc,'-') supadd5,nvl(sup.supmail,' ') email_id 
from non_payment_summary summ,non_supplier_account_live acc,supplier_asset_live sup,paytype typ,bank bnk,city cty,city bcty,city scty where summ.deleted='N' and summ.paycode=typ.paycode and summ.bnkcode=bnk.bnkcode and summ.supcode=acc.supcode and summ.ctycode=cty.ctycode and acc.supcode=sup.supcode and sup.ctycode=scty.ctycode and typ.paycode='".$paycode[0]."' and acc.bnkcity=bcty.ctycode and 
summ.brncode='".$brncode."' and bnk.bnkcode='".$bnkcode[0]."' and summ.paylist in (".$selected_list[$i][4].") and trunc(summ.paydate) = to_date('".$selected_list[$i][2]."','dd/MM/yyyy') order by cty.ctyname,summ.paynumb
","Centra","TEST"); 
                  
                  foreach($select_list as $sel){
                 $cnt++;
                $totalamt+=$sel['AMOUNT'];
           
                $html.= '<tr style="border-bottom-right-radius: 10px">
                       <td style="border: 1px solid #000;font-weight:bold" width="5%">'.$cnt.'</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="10%">'.$sel['VALUE_DATE'].'</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="15%">'.$sel['BENEFICIARY_IFSC_CODE'].'</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">'.$sel['BENEFICIARY_AC_NO'].'</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">'.$sel['BENEFICIARY_NAME'].' </td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">'.$sel['BENE_BANK'].'</td>
                       <td style="border: 1px solid #000;font-weight:bold" align="right" width="10%">'.number_format($sel['AMOUNT'],2).'</td>
                     </tr>';
                   }
                   }
                $html.= '<tr>
                       <td style="border: 1px solid #000;" colspan="6" align="right" style="font-weight:bold"><b>TOTAL</b></td>
                       <td style="border: 1px solid #000;" colspan="1" align="right" style="font-weight:bold"><b>'.number_format($totalamt,2).'</b></td>
                     </tr>';

$html.=  '</tbody>
                 </table>
               </td>
             </tr>
              <tr >
              <td style="height:50px"></td>
              </tr>
             <tr style="margin-top:100px">
               <td align="center" style="border:none;font-weight:bold"><h1 style="font-size:25px;font-weight:bold">REF.NO.: HDFC-'.$brnnic[0]['BRNNICN'].'-'.$current_yr[0]['PORYEAR'].' '.$seltrnnumb[0]['TRNNUMB'].'/'.$select_list[0]['VALUE_DATE'].'</h1></td>
             </tr>
             <tr >
              <td style="height:50px"></td>
              </tr>
              <tr>
               <td align="right" style="border:none;font-weight:bold">For THE CHENNAI SILKS</td>
             </tr>
              <tr >
              <td style="height:50px"></td>
              </tr>
             <tr>
              <td style="border:none">
                <table style="width:100%;border:none;">
                  <thead >
                  <tr style="background-color:#fff;color:#000">
                     <td align="center" style="font-weight:bold">'.$execute.'</td>
                     <td align="center" style="font-weight:bold">'.$sr_execute.'</td>
                     <td align="center" style="font-weight:bold">'.$audit.'</td>
                     <td></td>
                   </tr>
                 </thead>
                 <tbody>
                        <tr >
                    <td colspan="4" style="height:10px"></td>
                    </tr>
                    <tr>
                     <td align="center" style="font-weight:bold">Executive</td>
                     <td align="center" style="font-weight:bold">Sr. Executive</td>
                     <td align="center" style="font-weight:bold">Auditor</td>
                     <td align="right" style="font-weight:bold">DIRECTOR</td>
                   </tr>
                 </tbody>
              </table>
            </td>
          </tr>
      </table>';

*/

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// set document information
//$pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 001');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// // set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// $pdf->setFooterData(array(0,64,0), array(0,64,128));

// // set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// // set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// // set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// // set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// // set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// // set some language-dependent strings (optional)
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//   require_once(dirname(__FILE__).'/lang/eng.php');
//   $pdf->setLanguageArray($l);
// }

// // ---------------------------------------------------------

// // set default font subsetting mode
// $pdf->setFontSubsetting(true);

// // Set font
// // dejavusans is a UTF-8 Unicode font, if you only need to
// // print standard ASCII chars, you can use core fonts like
// // helvetica or times to reduce file size.
// $pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('P', 'A4');

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
//var_dump($pdf);
$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->Output('example_0211.pdf', 'I'); //set default 'I' to open in browser, set 'D' to force download

