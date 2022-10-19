<?php
	require("../../../../config/settings.php");

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    

  
        $compare = new Compare();
        if (!empty($compare->items)){

            $total = 0;
            $result = array();
            $result["body"] = array();
            $result["count"] = $compare->getTotal();
            
            foreach($compare->items as $prod_id=>$qty){
                try{
                    $product = new Product($prod_id);
                    $seasons = new Season();
                    $season = $seasons->find($product->season_id);

                    $widths = new Width();
                    $width = $widths->find($product->width_id);
                    
                    $heights = new Height();
                    $height = $heights->find($product->height_id);
                
                    $diameters = new Diameter();
                    $diameter = $diameters->find($product->diameter_id);

                    $suppliers = new Supplier();
                    $supplier = $suppliers->find($product->supplier_id);

                    $categories = new Subcategory();
                    $category = $categories->find($product->category_id);
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
                        'image' => $product->image,
                        'supplier' => $supplier->supplier_name,
                        'diameter' => $diameter->diameter_name,
                        'width' => $width->width_name,
                        'height' => $height->height_name,
                        'season' => $season->season_name,
                        'category' => $category->name,
                        'speed_index' => $product->speed_index,
                        'weight_index' => $product->weight_index,
                        'consumption_class' => $product->consumption_class,
                        'adhesion' => $product->adhesion,
                        'noise' => $product->noise,
                        'stoc' => $product->stoc
                    ));
            }
            echo json_encode($result);

        }else{
            echo json_encode(
                array("body" => array(), "count" => 0)
            );
        }
    
    
?>