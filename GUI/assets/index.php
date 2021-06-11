<?php
header("HTTP/1.0 404 Method not allowed");
$cResponse = array(
	"status"=>"Failed",
	"msg"=> "method not allowed"
);

/*echo response to client*/
echo json_encode($cResponse);
?>