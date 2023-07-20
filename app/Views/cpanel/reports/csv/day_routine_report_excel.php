<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Name','Status','Date','Time','Location Coordinates');
fputcsv($f, $lineData, $delimiter);
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
	$lineData = array($user,$value->status,$value->date,$value->time,$coord);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='day_routine_detail_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>