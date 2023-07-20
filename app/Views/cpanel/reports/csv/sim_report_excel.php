<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('ICC ID','Assigned To','Assigned On','Status','UN#');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$assignTo = null;
	if($value->status == 'assigned' || $value->status == 'utilized'){
		$assignTo = $modelUsers->get_users($value->user_id)->get()->getRow()->username;
	}
	$un = null;
	if($value->status == 'utilized'){
		$task_id = $modelGeneral->get_task_sim(null,null,$value->icc_id)->get()->getRow();
		$task_info = $modelCustomer->get_customer_info($task_id->task_id)->get()->getRow();
		if($task_info){
			$un = $task_info->un_number;
		}
	}
	//
	$lineData = array($value->icc_id,$assignTo,$value->assign_on,$value->status,$un);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='sims_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>