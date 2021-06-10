<?php
/*Include helpher file*/
include "info.php";

/*Process request*/
if($_SERVER["REQUEST_METHOD"] === "GET"){
	header("HTTP/1.0 404 Invalid request");
	$cResponse["msg"] = "invalid bucket";
	
	if(isset($_GET["bucket"]) && $_GET["bucket"] !==""){
		$parent = str_replace("/","-", $_GET["bucket"]). ".DB";
		$parent = str_replace(".DB", "", str_replace("-.DB", "", $parent));
		$dir = $xTinyDB["storage"] . "/" . $parent . ".json";
		if(is_file($dir)){
			/*if tag is present then remove tag else remove bucket*/
			if(isset($_GET['tag'])){
				$cResponse["msg"] = "invalid tag(s)";
				if(count(json_decode($_GET["tag"], true))>0){
					header("HTTP/1.0 200 Data Cleared");
					$cResponse["status"] = "Success";
					$tags = json_decode($_GET["tag"], true);

					/*Handel Errors*/
					$bucketData = json_decode(file_get_contents($dir), true);
					$x = 0;
					foreach($tags as $tag){
						if(array_key_exists($tag, $bucketData)){
							unset($bucketData[$tag]);
							$x++;
						}
					}
					
					$cResponse["msg"] = $x . " tag(s) cleared";
					/*update file*/
					file_put_contents($dir, json_encode($bucketData, JSON_PRETTY_PRINT));
				}
			}else{
				header("HTTP/1.0 200 Data Cleared");
				$cResponse["status"] = "Success";
				/*remove entire bucket & subBuckets & from parent | Get Locator Log*/
				$bucketLocators = json_decode(file_get_contents($xTinyDB["locator"]), true);
				
				$presetArr =  explode('-', $parent);
				if(count($presetArr) > 1){
					/*preset = grand parent*/
					$preset = str_replace("-".$presetArr[count($presetArr) -1], "", $parent);
					
					/*Get Grad Parent*/
					$grandParent = $bucketLocators[$preset];
					
					/*remove parent from the grandparent*/
					$grandParent= array_diff($grandParent, array($presetArr[count($presetArr) -1]));
					$bucketLocators[$preset] = array_values($grandParent);
				}
				
				/*for loop to remove child buckets*/
				$i = 0;
				$pattern = "/".$parent."/i";
				foreach(array_keys($bucketLocators) as $bucket){
					if(preg_match($pattern, $bucket)){
						unset($bucketLocators[$bucket]);
						unlink($xTinyDB["storage"]."/". $bucket . ".json");
						$i++;
					}
				}
				
				$cResponse["msg"] = $i . " bucket(s) cleared";
				/*update bucket locatores*/
				file_put_contents($xTinyDB["locator"], json_encode($bucketLocators, JSON_PRETTY_PRINT));
			}
		}
	}
}

/*echo response to client*/
echo json_encode($cResponse);
?>
