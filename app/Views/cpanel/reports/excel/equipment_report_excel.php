<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Equipment','User','Qty','UOM','UN#','Status','On Date');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	//
	$key = $key+1;
	$equipInfo = $modelGeneral->get_misc_equipment($value->equip_id)->get()->getRow();
	$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
	$taskDetail = $modelCustomer->get_customer_info($value->task_id)->get()->getRow();
// 
	$lineData = array($equipInfo->name,$userInfo->firstname.' '.$userInfo->lastname,$value->qty,$equipInfo->uom,$taskDetail->un_number,$status,$value->created_on);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='equipment_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>