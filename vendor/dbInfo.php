<?php
/*Secured credentials*/
$xTinyDB = array(
	"storage" => "storage-area"
	"accessKey" => "sampleaccesskey01"
);

$xTinyDB["locator"] = $xTinyDB["storage"] ."/bucket-locators.json";

/*Default response*/
header("HTTP/1.0 404 Method not allowed");
$cResponse = array("status"=>"Failed", "msg"=> "method not allowed");

/*Check storage Area*/
if(!is_dir($xTinyDB["storage"])){
	mkdir($xTinyDB["storage"]);
	/*Create Locator JSON*/
	file_put_contents($xTinyDB["locator"], json_encode(array(), JSON_PRETTY_PRINT));
}

/*Verify Token*/
$headers = getallheaders();
if($xTinyDB["accessKey"] !== str_replace("Basic ","", $headers["Authorization"])){
	$cResponse['msg'] = "invalid access key";
	die(json_encode($cResponse));
}

/*Remove Special Chars from the Tags/Bucket Name*/
function clean($string) {
   $string = str_replace(' ', '_', $string); 
   return preg_replace('/[^A-Za-z0-9\/_]/', '', $string);
}

?>
