<?php
$stilled = $_GET['s'];
$dbfile = "mcs_database.txt";
if($stilled != '') {
	if(file_exists($dbfile)) {
		$stilled =  str_replace("\n", "", $stilled);
		if($stilled != '') {
			$tmp = explode("|", $stilled);
			$file = fopen($dbfile, "r+t");
			foreach($tmp as $value) {
				$write = true;
				while(!feof($file)) {
					$readed = fgets($file);
					if($readed == $value."\n") {
						$write = false;
						break;
					}
				}
				if($write) {
					fwrite($file, $value."\n");
				}
			}
			fclose($file);
		}
	}
}
?>
