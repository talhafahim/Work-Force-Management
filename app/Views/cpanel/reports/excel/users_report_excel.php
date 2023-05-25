<?php
///////////////////////////////////////////////////////////////////////////////////////
$delimiter = ",";
$f = fopen('php://memory', 'w');
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////
$lineData = array('Username','Firstname','Lastname','Email','Mobile#','Password','Status','Staff Cost','Created On');
fputcsv($f, $lineData, $delimiter);
//
foreach($data->get()->getResult() as $key => $value){
	$key = $key+1;
// 
	$lineData = array($value->username,$value->firstname,$value->lastname,$value->email,$value->mobilephone,$value->pass_string,$value->status,$value->staff_cost,$value->created_at);
	fputcsv($f, $lineData, $delimiter);
}				
/////////////////////////////////////////////////////
$filename='users_detail_report.csv';
fseek($f, 0);
//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
//output all remaining data on a file pointer
fpassthru($f);
// }
exit;
?>