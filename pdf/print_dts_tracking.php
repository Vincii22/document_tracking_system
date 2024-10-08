<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
//Include dts important files
require_once("../includes/initialize.php");

$doc=Document::find_by_tracking($_GET['trackingnum']);
$user=User::find_by_id($doc->personnel_id);
//document variables
$dts_timestamp=$doc->date_started;
$dts_tracking=$doc->doc_trackingnum;
$dts_docname=$doc->doc_name;
$dts_docowner=$doc->doc_owner;
$dts_docownermobile='0'.substr($doc->doc_mobilenum,2);
$dts_docreceiver=$user->full_name();
$dts_barcode=$doc->barcode_path; // Barcode path

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Juray Qui');
$pdf->SetTitle('DTS-Print Tracking Number');
$pdf->SetSubject('Print Tracking Number');
$pdf->SetKeywords('print, tracking, dts');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 5, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// Barcode Image - Option 1: Use TCPDF's Image() function
// $pdf->Image($dts_barcode, 10, 10, 40, 20, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

// Or you can include the barcode image as part of the HTML content (Option 2):
$html = '
<table border="1" cellspacing="3" cellpadding="4">
<tr>
<th style="width:48%" colspan="2"><h3 align="center">Divine Word College of Legazpi <br> Document Tracking System</h3></th>
<th style="width:4%"></th>
<th style="width:48%" colspan="2"><h3 align="center">Divine Word College of Legazpi <br> Document Tracking System</h3></th>
</tr>

<tr>
    <td style="width:18%;height:30px">Date Received:</td><td style="width:30%">'.$dts_timestamp.'</td>
    <td style="width:4%"></td>
    <td style="width:18%">Date Received:</td><td style="width:30%">'.$dts_timestamp.'</td>
</tr>
<tr>
    <td style="height:30px">Tracking Number:</td><td>'.$dts_tracking.'</td>
    <td></td>
    <td>Tracking Number:</td><td>'.$dts_tracking.'</td>
</tr>     
<tr>
    <td style="height:30px">Document Name:</td><td>'.$dts_docname.'</td>
    <td></td>
    <td>Document Name:</td><td>'.$dts_docname.'</td>
</tr> 
<tr>
    <td style="height:30px">Document Owner:</td><td>'.$dts_docowner.'</td>
    <td></td>
    <td>Document Owner:</td><td>'.$dts_docowner.'</td>
</tr>  
<tr>
    <td style="height:60px">Added By:</td><td>'.$dts_docreceiver.'</td>
    <td></td>
    <td>Added By:</td><td>'.$dts_docreceiver.'</td>
</tr>    
<tr>
    <td style="height:60px">Barcode:</td><td colspan="4"><img src="'.$dts_barcode.'" width="150" height="50" /></td>
</tr> 
<tr>
    <td style="height:60px">Remarks:</td><td></td>
    <td></td>
    <td>Remarks:</td><td></td>
</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('dts-print-tracking.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
