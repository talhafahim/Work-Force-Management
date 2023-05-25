<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('#','Serial','Vendor','Model','Scenario','Assigned To','Assigned On','Status','UN#');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$assignTo = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'used') ? 'Utilized' : ( ($value->status == 'free') ? 'In Stock' : ucfirst($value->status));
	//
	$un = null;
	if($status == 'Utilized'){
		$task_id = $modelGeneral->get_task_gateway(null,null,$value->serial)->get()->getRow();
		$un = $modelCustomer->get_customer_info($task_id->task_id)->get()->getRow()->un_number;
	}
// 
	$lineData = array($key,$value->serial,$value->vendor,$value->model,$value->scenario,$assignTo,$value->assign_on,$status,$un);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='gateway_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>