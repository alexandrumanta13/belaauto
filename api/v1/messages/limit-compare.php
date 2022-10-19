<?php
    require("../../../../config/settings.php");

	$content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    

	if(! is_array($decoded)) {
		echo json_encode(
			array("error" => "Something went wrong.")
		);
	} else {
        $product = new Product($decoded['product']);
        $output = "
        <div class=\"msg-box-container\">
            <div class=\"msg-box\">
                <div class=\"msg\">
                    Maxim 4 produse pot fi adaugate la comparatie!
                </div>
               
            </div> 
            <a href=\"/compara\" class=\"btn btn-primary viewcart\" data-link=\"\">Vezi lista</a> 
            <button class=\"btn btn-primary continue_shopping close-message\" onclick=\"closeMessage()\">Continua</button>
        </div>
        ";

        echo $output;

    }
?>
