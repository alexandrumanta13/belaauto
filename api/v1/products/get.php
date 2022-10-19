<?php
require("../../../../config/settings.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = isset($_SERVER["REQUEST_METHOD"]) ? trim($_SERVER["REQUEST_METHOD"]) : '';
if($method == 'POST') {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    if(! is_array($decoded)) {
        echo json_encode(
            array("error" => "Something went wrong.")
        );
    } else {
        $result = array();
        $result["body"] = array();
        

        if(isset($decoded["all"])) {
            $page = array_key_exists('pagina', $decoded) ? (int)$decoded['pagina'] : 1;
            $products = new Product();
            $sort = 12;
            $order = "DESC";
            $output = $products->DynamicFiler("id", $order, $sort, $decoded, $page);

            $count = count($output);
            $result["count"] = $count;
            $result["pages"] = ceil(count($output)/$sort);
            if($count > 0) {
                $seasons = new Season();
                $widths = new Width();
                $heights = new Height();
                $diameters = new Diameter();
                $suppliers = new Supplier();
                foreach($output as $product) {
                    $season = $seasons->find($product["season_id"]);
                    $width = $widths->find($product["width_id"]);
                    $height = $heights->find($product["height_id"]);
                    $diameter = $diameters->find($product["diameter_id"]);
                    $supplier = $suppliers->find($product["supplier_id"]);
                    array_push($result["body"], array('product_name' => 'Anvelope ' . $season->season_name . ' ' . $width->width_name . '/' . $height->height_name . '/' . $diameter->diameter_name . ' ' . $supplier->supplier_name . ' ' . $product['model'] .'', 'price' => $product['price'], 'image' => $product['image'], 'id' => $product['id']));
                }
                echo json_encode($result);
            } else {
                echo json_encode(
                    array("body" => array(), "count" => 0)
                );
            }
        } else {
            $page = array_key_exists('pagina', $decoded) ? (int)$decoded['pagina'] : 1;
            $products = new Product();
            $sort = 12;
            $order = "DESC";
            $output = $products->DynamicFiler("id", $order, $sort, $decoded, $page);
            $count = count($output);
            $result["count"] = $count;
            if($count > 0) {
                $seasons = new Season();
                $widths = new Width();
                $heights = new Height();
                $diameters = new Diameter();
                $suppliers = new Supplier();
                foreach($output as $product) {
                    $season = $seasons->find($product["season_id"]);
                    $width = $widths->find($product["width_id"]);
                    $height = $heights->find($product["height_id"]);
                    $diameter = $diameters->find($product["diameter_id"]);
                    $supplier = $suppliers->find($product["supplier_id"]);
                    array_push($result["body"], array('product_name' => 'Anvelope ' . $season->season_name . ' ' . $width->width_name . '/' . $height->height_name . '/R' . $diameter->diameter_name . ' ' . $supplier->supplier_name . ' ' . $product['model'] .'', 'price' => $product['price'], 'image' => $product['image'], 'id' => $product['id']));
                }
                echo json_encode($result);
            } else {
                echo json_encode(
                    array("body" => array(), "count" => 0)
                );
            }
           
        }
        
    }
}

?>