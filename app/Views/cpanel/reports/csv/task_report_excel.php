<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Utility#','Meter Serial','Region','Scenario','GW Serial','SIM ICC ID','By','Remarks','Assign On','Return Reason');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$reason = null;
	$assignTo = $gwSerial = $simiccid = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
	//
	if($value->status == 'complete' || $value->status == 'commission'){
	// $taskDetail = $modelTask->get_task_detail(null,$value->id)->get()->getRow();
	$gateway = $modelGeneral->get_task_gateway(null,$value->id,null)->get();
	if($gateway){
		// $gwSerial = $gateway->gateway_serial;
		foreach($gateway->getResult() as $gValue){
				$gwSerial .= $gValue->gateway_serial.' '; 
			}
	}
	//
	$sim = $modelGeneral->get_task_sim(null,$value->id,null)->get();
	if($sim){
		// 
		foreach($sim->getResult() as $sValue){
				$simiccid .= $sValue->sim_icc_id.' '; 
			}
	}}
	//
	if($status == 'return'){
		$reason_id = $modelTask->get_task_detail(null,$value->id)->get()->getRow()->reject_reason;
		if($reason_id){
			$reason = $modelGeneral->get_return_reason($reason_id)->get()->getRow()->reason;
		}
	}
	// 
	$lineData = array($value->un_number,$value->meter_number,'region',$value->scenario,$gwSerial,$simiccid,$assignTo,$status,$value->assign_on,$reason);
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