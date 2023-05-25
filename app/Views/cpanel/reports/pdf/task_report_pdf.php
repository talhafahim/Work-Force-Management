<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
date_default_timezone_set("Asia/Karachi");
// 
require_once(APPPATH.'/Libraries/TCPDF-master/tcpdf.php');
$today=date('Y-m-d');
//
$html = '';
//

$html .='<style>
body{
	font-family: arial, sans-serif;
}
table {
	border-collapse: collapse;
	width: 100%;
}

input,td,
th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 2px;

}
.right{
	float:right;
}
.text-right{
	text-align:right;
}
.container{     	
	font-size: 10px;
}
.grey{
	background-color:#e6e6e6;
}
	.borderless{
border: none;
}
</style>';
//
$html .= '<table>
			<thead>
				<tr class="grey">
					<th width="6%"><b>#</b></th>
					<th width="16%"><b>Utility#</b></th>
					<th width="12%"><b>Meter Serial</b></th>
					<th width="12%"><b>Region</b></th>
					<th width="10%"><b>Scenario</b></th>
					<th width="12%"><b>GW Serial</b></th>
					<th width="12%"><b>By</b></th>
					<th width="8%"><b>Remarks</b></th>
					<th width="12%"><b>Assign On</b></th>
				</tr>
			</thead><tbody>';

foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$assignTo = $gwSerial = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
	//
	if($value->status == 'complete' || $value->status == 'comission'){
	$taskDetail = $modelTask->get_task_detail(null,$value->id)->get()->getRow();
	$gateway = $modelGeneral->get_task_gateway(null,$taskDetail->task_id,null,$taskDetail->id)->get()->getRow();
	if($gateway){
		$gwSerial = $gateway->gateway_serial;
	}}
	// 
$html .= '<tr>
			<td width="6%">'.$key.'</td>
			<td width="16%">'.$value->un_number.'</td>
			<td width="12%">'.$value->meter_number.'</td>
			<td width="12%">region</td>
			<td width="10%">'.$value->scenario.'</td>
			<td width="12%">'.$gwSerial.'</td>
			<td width="12%">'.$assignTo.'</td>
			<td width="8%">'.$status.'</td>
			<td width="12%">'.$value->assign_on.'</td>
		</tr>';
}
$html .= '<tbody></table>';
//
// $pdf = new TCPDF;
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
        //
		// $this->Image('assets/images/logo.png',17,10,30);	
	}
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
// Call before the addPage() method
$pdf->SetPrintHeader(true);
$pdf->SetPrintFooter(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// Start First Page Group
// $pdf->startPageGroup();
$pdf->AddPage('L', 'A4');
// print an ending header line
$pdf->SetFont('', '', 14);
// MultiCell(width, height, 'Cell text', border 1/0, 'text-align', blackout, linebreak, '', '', true);
// $pdf->MultiCell(0, 5, 'LOGON BROADBAND (Pvt.) Ltd', 0, 'C', 0, 1, '', '', true);
$pdf->SetFont('', 'B', 10);
$pdf->MultiCell(0, 5, ucwords(session()->get('appTitle')), 0, 'C', 0, 1, '', '', true);
//
$pdf->SetFont('', 'B', 12);
$pdf->MultiCell(0, 5, 'TASK REPORT', 0, 'C', 0, 1, '', '', true);
//
$pdf->SetFont('', '', 8); 
// 
$pdf->MultiCell(90, 5, "", 0, 'L', 0, 1, '', '', true);
//
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
//
$pdf->Output("task-report.pdf");

exit();
?>