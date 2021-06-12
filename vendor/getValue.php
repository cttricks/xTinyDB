<?php
/*Clear tag/bucket*/
include "dbInfo.php";

/*Process request*/
if($_SERVER["REQUEST_METHOD"] === "GET"){
	header("HTTP/1.0 404 Invalid request");
	$cResponse["msg"] = "invalid bucket";
	
	if(isset($_GET["bucket"])){
		if($_GET["bucket"] !==""){
			$parent = str_replace("/","-", $_GET["bucket"]). ".DB";
			$parent = str_replace(".DB", "", str_replace("-.DB", "", $parent));
			$dir = $xTinyDB["storage"] . "/" . $parent . ".json";
			if(is_file($dir)){
				/*if tag is present then remove tag else remove bucket*/
				if(isset($_GET['tag'])){
					$defaultValue = ((isset($_GET["def"]))? $_GET["def"]: "");
					$cResponse["msg"] = "invalid tag(s)";
					if(count(json_decode($_GET["tag"], true))>0){
						header("HTTP/1.0 200 Got Data");
						$cResponse["status"] = "Success";
						$tags = json_decode($_GET["tag"], true);

						/*Handel Errors*/
						$bucketData = json_decode(file_get_contents($dir), true);
						$values = array();
						foreach($tags as $tag){
							if(array_key_exists($tag, $bucketData)){
								array_push($values, $bucketData[$tag]);
							}else{
								array_push($values, $defaultValue);
							}
						}

						$cResponse["msg"] = "got value(s) of ". count($values) . " tag(s)";
						$cResponse["data"] = $values;
						/*Update file*/
						file_put_contents($dir, json_encode($bucketData, JSON_PRETTY_PRINT));
					}
				}else{
					header("HTTP/1.0 200 Got Data");
					$cResponse["status"] = "Success";
					/*Get data from location and sub buckets from locator*/
					$bucketData = json_decode(file_get_contents($dir), true);
					$bucketLocators = json_decode(file_get_contents($xTinyDB["locator"]), true);
					$cResponse["msg"] = "got bucket data";
					$cResponse["sub_buckets"] = $bucketLocators[$parent];
					$cResponse["tags"] = array(); 
					$cResponse["values"] = array();
					if(!empty($bucketData)){
						$cResponse["tags"] = array_keys($bucketData);
						$cResponse["values"] = array_values($bucketData);
					}
					$cResponse["msg"] = "got bucket data";
					$cResponse["sub_buckets"] = $bucketLocators[$parent];
				}
			}
		}else{
			$bucketLocators = json_decode(file_get_contents($xTinyDB["locator"]), true);
			$buckets = array_keys($bucketLocators);
			$parentbucets= array();
			foreach($buckets as $bucket){
				if(count(explode('-', $bucket))<2){
					array_push($parentbucets, $bucket);
				}
			}
			
			header("HTTP/1.0 200 Got Data");
			$cResponse["status"] = "Success";
			$cResponse["msg"] = "Got main bucket";
			$cResponse["tags"] = array(); 
			$cResponse["values"] = array();
			$cResponse['sub_buckets'] = $parentbucets;
		}
	}
}

/*echo response to client*/
echo json_encode($cResponse);
?>
