<?php

include_once('tcpdf_include.php');

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
                   <tbody>
                     <tr style="border-bottom-right-radius: 10px">
                       <td style="border: 1px solid #000;font-weight:bold" width="5%">1</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="10%">15/05/2019</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="15%">BKID0008215</td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">821510110006860 </td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">VINOD KUMAR K </td>
                       <td style="border: 1px solid #000;font-weight:bold" width="20%">BANK OF INDIA</td>
                       <td style="border: 1px solid #000;font-weight:bold" align="right" width="10%">23,197.00</td>
                     </tr>
                     <tr>
                       <td style="border: 1px solid #000;" colspan="6" align="right" style="font-weight:bold"><b>TOTAL</b></td>
                       <td style="border: 1px solid #000;" colspan="1" align="right" style="font-weight:bold"><b>23,197.00</b></td>
                     </tr>
                   </tbody>
                 </table>
               </td>
             </tr>
              <tr >
              <td style="height:50px"></td>
              </tr>
             <tr style="margin-top:100px">
               <td align="center" style="border:none;font-weight:bold"><h1 style="font-size:25px;font-weight:bold">REF.NO.: HDFC-SUP-2019-20 863/02/05/2019</h1></td>
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
                     <td align="center" style="font-weight:bold">12271-AYYAPPAN A</td>
                     <td align="center" style="font-weight:bold">1344-S MULLAI NATHAN</td>
                     <td align="center" style="font-weight:bold">INTERNAL AUDITOR</td>
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
                     <td align="right" style="font-weight:bold">PARTNER</td>
                   </tr>
                 </tbody>
              </table>
            </td>
          </tr>
      </table>';



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
$pdf->AddPage('L', 'A4');

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
//var_dump($pdf);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_0211.pdf', 'I'); //set default 'I' to open in browser, set 'D' to force download

