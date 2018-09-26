<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$event = $json->result->parameters->event;
	$from = $json->result->parameters->from;
	$to = $json->result->parameters->to;
	
	if($event == "INBOX") {
		$text = $json->result->parameters->text;
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
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>
