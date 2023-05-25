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
					<th width="25%"><b>Device/Tool Name</b></th>
					<th width="25%"><b>User</b></th>
					<th width="25%"><b>Serial#</b></th>
					<th width="25%"><b>Assign On</b></th>
				</tr>
			</thead><tbody>';

foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$deviceInfo = $modelGeneral->get_devices_n_tools($value->tool_id)->get()->getRow();
	$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();
$html .= '<tr>
			<td width="25%">'.$deviceInfo->name.'</td>
			<td width="25%">'.$userInfo->firstname.' '.$userInfo->lastname.'</td>
			<td width="25%">'.$value->serial.'</td>
			<td width="25%">'.$value->updated_on.'</td>
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
$pdf->AddPage('P', 'A4');
// print an ending header line
$pdf->SetFont('', '', 14);
// MultiCell(width, height, 'Cell text', border 1/0, 'text-align', blackout, linebreak, '', '', true);
// $pdf->MultiCell(0, 5, 'LOGON BROADBAND (Pvt.) Ltd', 0, 'C', 0, 1, '', '', true);
$pdf->SetFont('', 'B', 10);
$pdf->MultiCell(0, 5, ucwords(session()->get('appTitle')), 0, 'C', 0, 1, '', '', true);
//
$pdf->SetFont('', 'B', 12);
$pdf->MultiCell(0, 5, 'DEVICES & TOOLS REPORT', 0, 'C', 0, 1, '', '', true);
//
$pdf->SetFont('', '', 8); 
// 
$pdf->MultiCell(90, 5, "", 0, 'L', 0, 1, '', '', true);
//
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
//
$pdf->Output("device-n-tools-report.pdf");

exit();
?>