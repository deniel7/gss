<?php
if(!empty($data_o)){
foreach($data_o as $row):
echo $row->export; 
echo "\r\n"; 
echo $row->vat;
echo "\r\n";
endforeach;
}else{
	echo"";
}
if(!empty($data_o_div)){
foreach($data_o_div as $row):
echo $row->export;
echo "\r\n"; 
endforeach;
}else{
	echo"";
}
?>