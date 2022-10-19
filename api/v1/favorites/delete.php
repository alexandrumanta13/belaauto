<?php
	require("../../../../config/settings.php");
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	$content = trim(file_get_contents("php://input"));
	$decoded = json_decode($content, true);
    
	if(! is_array($decoded)) {
		echo json_encode(
			array("error" => "Something went wrong.")
		);
	} else {
		$favorite = new Favorites();
        if(isset($decoded['product'])) {
			try{
				$favorite->delete($decoded['product']);
			}
			catch (Exception $e){
				echo json_encode(array("success" => false, "message" => "" . $e->getMessage() . ""));
			}
			echo json_encode(array("success" => true, "message" => "Produsul a fost sters cu succes!"));
		}else {
			$favorite->deleteFavorites();
			echo json_encode(array("success" => true, "message" => "Lista de produse favorite a fost golita!"));
		}
		
	}
?>