<?php
#include the export-xls.class.php file
require_once(APPPATH.'/Libraries/ExportXLS.php');
$filename = 'task_report.xls'; // The file name you want any resulting file to be called.

#create an instance of the class
$xls = new ExportXLS($filename);
//
$header = array('Utility#','Meter Serial','Region','Scenario','GW Serial','SIM ICC ID','By','Remarks','Assign On','Return Reason');
//
$xls->addHeader($header);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
	$reason = '';
	$assignTo = $gwSerial = $simiccid = null;
	if(!empty($value->assign_to)){
		$assignTo = $modelUsers->get_users($value->assign_to)->get()->getRow()->username;
	}
	$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : $value->status);
	//
	if($value->status == 'complete' || $value->status == 'commission'){
	// $taskDetail = $modelTask->get_task_detail(null,$value->id)->get()->getRow();
	$gateway = $modelGeneral->get_task_gateway(null,$value->id,null)->get();
	if($gateway){
		// $gwSerial = $gateway->gateway_serial;
		foreach($gateway->getResult() as $gValue){
				$gwSerial .= $gValue->gateway_serial.' '; 
			}
	}
	//
	$sim = $modelGeneral->get_task_sim(null,$value->id,null)->get();
	if($sim){
		// 
		foreach($sim->getResult() as $sValue){
				$simiccid .= $sValue->sim_icc_id.' '; 
			}
	}}
	//
	if($status == 'return'){
		$reason_id = $modelTask->get_task_detail(null,$value->id)->get()->getRow()->reject_reason;
		if($reason_id){
			$reason = $modelGeneral->get_return_reason($reason_id)->get()->getRow()->reason;
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////// 
	//////////////////////////////////////////////////////////////////////////////////////////////// 
	//////////////////////////////////////////////////////////////////////////////////////////////// 
	$row = array();
	$row = array($value->un_number,$value->meter_number,'region',$value->scenario,$gwSerial,$simiccid,$assignTo,$status,$value->assign_on,$reason);
	
	//
	$xls->addRow($row);
}
//
$xls->sendFile($filename);
//

?>