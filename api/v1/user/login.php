<?php
	require("../../../../config/settings.php");

	$content = trim(file_get_contents("php://input"));
	$decoded = json_decode($content, true);
	header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
	if(! is_array($decoded)) {
		echo json_encode(
			array("error" => "Something went wrong.")
		);
	} else {
        
		$user = new User();
		
        if(!$user->login($decoded['email'], $decoded['password'], $decoded['persistent'])){
			echo json_encode(array("success" => false, "message" => "Datele de autentificare sunt gresite. Va rugam incercati din nou."));
		} else {
			echo json_encode(array("success" => true, "message" => "APASA PE C"));
		}	
	}
?>