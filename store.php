<?php
/*Store - Update Data*/
include "info.php";

/*Process request*/
if($_SERVER["REQUEST_METHOD"] === "POST"){
	$cResponse["msg"] = "invalid bucket";
	if(isset($_POST["bucket"]) && $_POST["bucket"] !==""){
		$cResponse["msg"] = "invalid tag";
		if(isset($_POST["tag"]) && count(json_decode($_POST["tag"], true))>0){
			$tags = json_decode($_POST["tag"], true);
			/*if value is not defined or invalid then set it to blank*/
			$value = ((isset($_POST['value']) && count(json_decode($_POST["value"], true)) > 0 )? $_POST['value'] : '[""]');
			$value = json_decode($_POST["value"], true);
			
			/*chnage bucket path to array*/
			$bucArr = explode("/", clean($_POST['bucket']));
			
			/*Get bucket Locator*/
			$bucketLocators = array();
			if(is_file($xTinyDB["locator"])){
				$bucketLocators = json_decode(file_get_contents($xTinyDB["locator"]), true);
			}
			
			/*populate data if there are sub buckets*/
			$parent = "";
			foreach($bucArr as $bucket){
				$temp_bucket = $parent;
				$parent.= (($parent !=="")? "-".$bucket : $bucket);

				/*craete array only of the bucket is not available*/
				if(!array_key_exists($parent, $bucketLocators)){
					$bucketLocators[$parent] = array();
					/*include empty file if the bucket is unavailable*/
					file_put_contents($xTinyDB["storage"] . "/" . $parent .".json", "");
				}

				/*push current bucket as subbucket of parent*/
				if($temp_bucket !==""){
					if(!in_array($bucket, $bucketLocators[$temp_bucket])){
						array_push($bucketLocators[$temp_bucket], $bucket);
					}
				}
			}
			
			/*update bucket locatores*/
			file_put_contents($xTinyDB["locator"], json_encode($bucketLocators, JSON_PRETTY_PRINT));
			
			/*populate bucket data*/
			$bucketData = array();
			$dir = $xTinyDB["storage"] . "/" . $parent . ".json";
			if(is_file($dir)){
				$bucketData = json_decode(file_get_contents($dir), true);
			}
			
			$i = 0;
			foreach($tags as $tag){
				$tag = clean($tag);
				$bucketData[$tag] = ((count($value) > $i)? $value[$i] : "");
				$i++;
			}
			
			/*update bucket data*/
			file_put_contents($dir, json_encode($bucketData, JSON_PRETTY_PRINT));
			header("HTTP/1.0 200 Stored successfully");
			$cResponse["status"] = "Success";
			$cResponse["msg"] = count($tags). " tag(s) stored successfully";
		}
	}
}


/*echo response to client*/
echo json_encode($cResponse);
?>
