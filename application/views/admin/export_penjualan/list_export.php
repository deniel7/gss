<?php
	if(!empty($data_e)){
		echo "|\r\n";
		foreach($data_e as $row):
			echo $row->export;
			echo "\r\n"; 
		endforeach;
	}
	else{
		echo "";	
	}

?>