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
					<th width="5%"><b>#</b></th>
					<th width="10%"><b>Serial</b></th>
					<th width="10%"><b>Vendor</b></th>
					<th width="15%"><b>Model</b></th>
					<th width="7%"><b>CTN/Box#</b></th>
					<th width="7%"><b>Received Date</b></th>
					<th width="8%"><b>DN#</b></th>
					<th width="8%"><b>Assigned To</b></th>
					<th width="10%"><b>Assigned On</b></th>
					<th width="8%"><b>Status</b></th>
					<th width="12%"><b>UN#</b></th>
				</tr>
			</thead><tbody>';

foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$assignTo = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'used') ? 'Utilized' : ( ($value->status == 'free') ? 'In Stock' : ucfirst($value->status));
	$un = null;
	if($status == 'Utilized'){
		$task_id = $modelGeneral->get_task_gateway(null,null,$value->serial)->get()->getRow();
		$un = $modelCustomer->get_customer_info($task_id->task_id)->get()->getRow()->un_number;
	}
$html .= '<tr>
			<td width="5%">'.$key.'</td>
			<td width="10%">'.$value->serial.'</td>
			<td width="10%">'.$value->vendor.'</td>
			<td width="15%">'.$value->model.'</td>
			<td width="7%">'.$value->ctn.'</td>
			<td width="7%">'.$value->received_date.'</td>
			<td width="8%">'.$value->dn.'</td>
			<td width="8%">'.$assignTo.'</td>
			<td width="10%">'.$value->assign_on.'</td>
			<td width="8%">'.$status.'</td>
			<td width="12%">'.$un.'</td>
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
$pdf->MultiCell(0, 5, 'GATEWAY REPORT', 0, 'C', 0, 1, '', '', true);
//
$pdf->SetFont('', '', 8); 
// 
$pdf->MultiCell(90, 5, "", 0, 'L', 0, 1, '', '', true);
//
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
//
$pdf->Output("gateway-report.pdf");

exit();
?>