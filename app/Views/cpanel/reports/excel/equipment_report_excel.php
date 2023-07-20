<?php
///////////////////////////////////////////////////////////////////////////////////////
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'equipment_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Equipment','User','Qty','UOM','UN#','Status','On Date');
$xls->addHeader($header);
//
foreach($data->get()->getResult() as $key => $value){
	//
	$key = $key+1;
	$equipInfo = $modelGeneral->get_misc_equipment($value->equip_id)->get()->getRow();
	$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
	$taskDetail = $modelCustomer->get_customer_info($value->task_id)->get()->getRow();
// 
	$row = array();
	$row = array($equipInfo->name,$userInfo->firstname.' '.$userInfo->lastname,$value->qty,$equipInfo->uom,$taskDetail->un_number,$status,$value->created_on);
	$xls->addRow($row);
}

//
$xls->sendFile($filename);

?>