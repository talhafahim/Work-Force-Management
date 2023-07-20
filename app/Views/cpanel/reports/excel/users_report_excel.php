<?php
///////////////////////////////////////////////////////////////////////////////////////
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'user_detail_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Username','Firstname','Lastname','Email','Mobile#','Password','Status','Staff Cost','Created On');
$xls->addHeader($header);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
// 
	$row = array();
	$row = array($value->username,$value->firstname,$value->lastname,$value->email,$value->mobilephone,$value->pass_string,$value->status,$value->staff_cost,$value->created_at);
	$xls->addRow($row);
}	
//
$xls->sendFile($filename);
?>