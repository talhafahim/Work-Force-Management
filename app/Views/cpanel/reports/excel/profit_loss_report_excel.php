<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Date','Profit','Loss');
fputcsv($f, $lineData, $delimiter);
//
foreach($profit as $key => $value){
	
// 
	$lineData = array($profit[$key]['date'],$profit[$key]['profit'],$profit[$key]['loss']);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='profit_loss_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>