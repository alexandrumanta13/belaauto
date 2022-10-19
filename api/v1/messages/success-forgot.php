<?php
    require("../../../../config/settings.php");

	$content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    

	if(! is_array($decoded)) {
		echo json_encode(
			array("error" => "Something went wrong.")
		);
	} else {
        $output = "
        <div class=\"msg-box-container\">
            <div class=\"msg-box\">
                <div class=\"msg\">
                    <p class=\"product-name text-color-primary\">" . $decoded['message'] . "</p>
                </div>
            </div> 
            <button class=\"btn btn-primary continue_shopping close-message\" onclick=\"closeMessage()\">Inchide</button>
        </div>
        ";

        echo $output;

    }
?>
