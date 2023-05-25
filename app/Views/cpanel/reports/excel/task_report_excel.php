<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Utility#','Meter Serial','Region','Scenario','GW Serial','By','Remarks','Assign On');
fputcsv($f, $lineData, $delimiter);
//
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
	$lineData = array($value->un_number,$value->meter_number,'region',$value->scenario,$gwSerial,$assignTo,$status,$value->assign_on);
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