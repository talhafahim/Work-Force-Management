<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Device','Serial','Model','Status','User');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$username = null;
	$deviceInfo = $modelGeneral->get_devices_n_tools($value->device_id)->get()->getRow();
	$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();

	if(!empty($value->user_id)){
		$username = $userInfo->firstname.' '.$userInfo->lastname;
	}
// 
	$lineData = array($deviceInfo->name,$value->serial,$value->model,$value->status,$username);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='device_tools_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>