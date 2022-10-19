<?php
	require("../../../../config/settings.php");

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    

  
        $favorites = new Favorites();
        if (!empty($favorites->items)){

            $total = 0;
            $result = array();
            $result["body"] = array();
            $result["count"] = $favorites->getTotal();
            
            foreach($favorites->items as $prod_id=>$qty){
                try{
                    $product = new Product($prod_id);
                }
                catch (Exception $e){
                    die("Eroare necunoscuta");
                }


                array_push(
                    $result["body"], 
                    array(
                        'id' => $product->id, 
                        'model' => $product->model, 
                        'price' => $product->price,
                        'image' => $product->image
                    ));
            }
            echo json_encode($result);

        }else{
            echo json_encode(
                array("body" => array(), "count" => 0)
            );
        }
    
    
?>