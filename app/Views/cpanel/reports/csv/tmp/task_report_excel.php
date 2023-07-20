<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Utility#','Meter Serial','Scenario','Meter Type','Protocal','Meter Model','Premise Type','Status','Assign To','Assign On');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$assignTo = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
// 
	$lineData = array($value->un_number,$value->meter_number,$value->scenario,$value->meter_type,$value->protocol,$value->meter_model,$value->prem_type,$status,$assignTo,$value->assign_on);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='task_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>