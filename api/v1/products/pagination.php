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
        
        if(isset($decoded["all"])) {
            $currentDate = date("F");
            $seasons = ['Winter' => ['September', 'October', 'November', 'December', 'January'], 'Summer' => ['February', 'March', 'April', 'May', 'June', 'July', 'August']];
            $currentSeason = in_array($currentDate, $seasons['Winter']) ? 2 : 1;
            //$products = Product::All();
            // $products = Database::table('products')->select()->where('season_id', $currentSeason)->where('price', '>=', 100)->order('price', 'ASC')->get();
            $products = Database::table('products')->select()->where('price', '>=', 100)->orderField("season_id", $currentSeason, ['price', 'ASC'])->get();
            $count = count($products);
            $result["page"] = 1;
            $result["step"] = 3;
            
            if($count > 0) {
                $result["size"] = ceil(count($products)/12);
                echo json_encode($result);
            } else {
                echo json_encode(
                    array("body" => array(), "count" => 0)
                );
            }
        } else {
            $page = array_key_exists('pagina', $decoded) ? (int)$decoded['pagina'] : -1;
           
            $products = new Product();
            $sort = 12;
            $order = "DESC";
            $result["page"] = 1;
            $result["step"] = 3;
            $output = $products->DynamicFiler("id", $order, $sort, $decoded, $page);
            $count = count($output);
        
            if($count > 0) {
                $result["size"] = ceil(count($output)/12);
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