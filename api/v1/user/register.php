<?php
	require("../../../../config/settings.php");

	$content = trim(file_get_contents("php://input"));
	$decoded = json_decode($content, true);
    
	if(! is_array($decoded)) {
		echo json_encode(
			array("error" => "Something went wrong.")
		);
	} else {
            $user = new User();
            $checkEmail = $user->checkEmail($decoded['email']);

           
           if ($checkEmail == 1){
                echo json_encode(array("duplicate" => true, "message" => "Emailul exista deja in baza de date"));
                //$_SESSION['success-register'] = 'Contul a fost creat!';
           }else{
                
                $user->date_created = date('Y-m-d H:i:s');
                $user->date_last_visit = date('Y-m-d H:i:s');
                $user->access = 0;
                $user->name = $decoded['name'];
                $user->last_name = $decoded['lastName'];
                $user->email = (!$decoded['email'] ? NULL : $decoded['email']);
                $user->phone = (!$decoded['phone'] ? NULL : $decoded['phone']);
                $user->password = password_hash($decoded['password'],PASSWORD_DEFAULT);
                if($user->save()) {
                    $user->login($decoded['email'], $decoded['password']);
                    $_SESSION['success-register'] = 'Contul a fost creat!';
                    echo json_encode(array("success" => true, "message" => "Contul a fost creat"));
                }
            
            }
        
		
	}
?>