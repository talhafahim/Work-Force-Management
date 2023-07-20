<?php

#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'gateway.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('#','Serial','Vendor','Model','Scenario','Assigned To','Assigned On','Status','UN#');
//
$xls->addHeader($header);
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
		$task_info = $modelCustomer->get_customer_info($task_id->task_id)->get()->getRow();
		if($task_info){
			$un = $task_info->un_number;
		}
	}
// 
	$row = array();
	$row = array($key,$value->serial,$value->vendor,$value->model,$value->scenario,$assignTo,$value->assign_on,$status,$un);
	$xls->addRow($row);
}
//
$xls->sendFile($filename);
//
?>