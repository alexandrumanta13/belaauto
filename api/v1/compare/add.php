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

		try{
            $compare = new Compare();
            $compare->getTotal();

            if($compare->getTotal() == 4) {
                echo json_encode(array("limit" => true, "message" => "Maxim 4 produse pot fi adaugate la lista de comparatie! "));
            } else {
                $item = new Product($decoded['product']);
                $qty = 1;
                $compare->addItem($item);
                $compare->fillCompare();
                echo json_encode(array("success" => true, "message" => "Produsul a fost adaugat cu succes! "));
            }
		}
		catch (Exception $e){
			echo json_encode(array("success" => false, "message" => "" . $e->getMessage() . ""));
		}
        
	}
?>