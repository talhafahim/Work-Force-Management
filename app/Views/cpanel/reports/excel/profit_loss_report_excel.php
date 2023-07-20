<?php
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'profit_loss_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Date','Profit','Loss');
$xls->addHeader($header);
//
//
foreach($profit as $key => $value){	
// 
	$row = array();
	$row = array($profit[$key]['date'],$profit[$key]['profit'],$profit[$key]['loss']);
	$xls->addRow($row);
}
//
$xls->sendFile($filename);
//
?>