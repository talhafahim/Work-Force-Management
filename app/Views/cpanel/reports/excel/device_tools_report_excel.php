<?php
///////////////////////////////////////////////////////////////////////////////////////
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'device_tools_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Device','Serial','Model','Status','User');
$xls->addHeader($header);
//
foreach($data->get()->getResult() as $key => $value){
	$username = null;
	$deviceInfo = $modelGeneral->get_devices_n_tools($value->device_id)->get()->getRow();
	$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();

	if(!empty($value->user_id)){
		$username = $userInfo->firstname.' '.$userInfo->lastname;
	}
// 
	$row = array();
	$row = array($deviceInfo->name,$value->serial,$value->model,$value->status,$username);
	$xls->addRow($row);
}
//
$xls->sendFile($filename);

?>