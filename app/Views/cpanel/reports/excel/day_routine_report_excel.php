<?php
///////////////////////////////////////////////////////////////////////////////////////
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'day_routine_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Name','Status','Date','Time','Location Coordinates');
$xls->addHeader($header);
//
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	if(!empty($value->user_id)){
		$user = $modelUsers->get_users($value->user_id)->get()->getRow()->username;
	}
	//
	$coord = '';
	if(!empty($value->latitude) && !empty($value->longitude)){
		$coord = number_format((float)$value->latitude, 4, '.', '').' '.number_format((float)$value->longitude, 4, '.', '');
	}
// 
	$row = array();
	$row = array($user,$value->status,$value->date,$value->time,$coord);
	$xls->addRow($row);
}

//
$xls->sendFile($filename);

?>