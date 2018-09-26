<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$event = $json->event;
	$from = $json->from;
	$to = $json->to;
	$text = $json->text;
	
	if($event == "INBOX") {
		
		$speech = "From: " . $from . ", Msg: " . $text . ".";
	}
	else if($event == "MESSAGEPROCESSED") {
		$custom_data = "process-1";
		$speech = "From: " . $from . ", To: " . $to . ", Status: Processed.";
	}
	else if($event == "MESSAGEFAILED") {
		$custom_data = "failed-1";
		$speech = "From: " . $from . ", To: " . $to . ", Status: Failed.";
	}
	else{
		$speech = "Parameter not complete";
	}

	$response = new \stdClass();
	$response->apiwha_autoreply = $speech;

	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>
