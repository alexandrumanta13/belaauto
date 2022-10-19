<?php
require "../../../../config/settings.php";

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (!is_array($decoded)) {
    echo json_encode(
        array("error" => "Something went wrong.")
    );
} else {

    try {
        $user = new User();
        $getUser = $user->getUserByEmail($decoded['email']);

        $to = $decoded['email'];
        $subject = "Resetare parola";

        $message = "
            <p>Copiati sau accesati linkul de mai jos pentru resetarea parolei</p>
            <a target='_blank' href='https://belaauto.ro/am-uitat-parola?token={$getUser[0]->token}'>https://belaauto.ro/am-uitat-parola?token={$getUser[0]->token}</a>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <webmaster@belaauto.ro>' . "\r\n";

        mail($to,$subject,$message,$headers);

        echo json_encode(array("success" => true, "message" => "Email-ul a fost trimis cu succes catre <a href='" . $decoded['email'] . "'>" . $decoded['email'] . "</a>. Daca emailul exista in baza de date, vei primi indicatii de resetare a parolei. Te rugam sa verifici si casuta de spam. Multumim!"));
       

    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "" . $e->getMessage() . ""));
    }
    
}
