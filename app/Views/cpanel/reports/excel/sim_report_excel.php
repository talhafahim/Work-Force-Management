<?php
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'gateway.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('ICC ID','Assigned To','Assigned On','Status','UN#');
$xls->addHeader($header);
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
	$row = array();
	$row = array($value->icc_id,$assignTo,$value->assign_on,$value->status,$un);
	$xls->addRow($row);
}
//
$xls->sendFile($filename);

?>