
<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');

$user = new User();

try{
	$logged_in = $user->loggedIn();
	if ($logged_in){
		header('Location: /contul-meu');
	}
}
catch (Exception $e){
	$errors[] = $e->getMessage();
	$logged_in = false;
}

if(isset($_POST['login'])){
    echo 'asdadsadadasdad';
	
	$data = array(
		'email' => array('email' => 'Invalid email'),
		'password' => array('required' => 'Password field cannot be empty!')
		);
	try{
		$errors = Functions::Validate($data,$_POST);
		if (!$errors){

			if(isset($_POST['persistent'])){
				$persistent = true;
			}else{
				$persistent = false;
			}
			if(!$user->login($_POST['email'], $_POST['password'], $persistent)){
				$_SESSION['error'] = "Date incorecte";
			}else{
				header("Location: /contul-meu");
			}
		}
	}
	catch(Exception $e){
		$errors[] = $e->getMessage();
	}
}
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>
    <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Autentificare</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="page-header">
                <div class="container">
                    <h1>Autentificare sau creare cont nou</h1>
                   
                </div><!-- End .container -->
            </div><!-- End .page-header -->

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2 class="title">Autentificare</h2>
                            <p>Ai deja cont?</p>
                        </div><!-- End .heading -->
                       
                        <div>
                            <input id="login-email" type="email" class="form-control" placeholder="Email" required>
                            <input id="login-password" type="password" class="form-control" placeholder="Parola" required>

                            <div class="form-footer">
                                <button onclick="checkCredentials()" class="btn btn-primary">Autentificare</button>
                                <a href="/am-uitat-parola" class="forget-pass"> Ai uitat parola?</a>
                            </div><!-- End .form-footer -->
                            <input type="hidden" name="login" value="true">
                        </div>
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="heading">
                            <h2 class="title">Creeaza cont nou</h2>
                            <p>Prin crearea unui cont nou, plasarea unei comenzi este mult mai usoara, iti poti stoca mai multe adrese de livrare si vei putea tine mai usor evidenta comenzilor tale din istoricul comenzilor tale. </p>
                        </div><!-- End .heading -->

                        <div>
                       
                            <input type="text" class="form-control" placeholder="Nume" id="register-name" required>
                            <input type="text" class="form-control" placeholder="Prenume" id="register-lastName" required>

                            <h2 style="margin-top: 60px" class="title mb-2">Informatii autentificare</h2>

                            <input type="email" class="form-control" id="register-email" required>
                            <input type="password" class="form-control" id="register-password" required>
                            <input type="password" class="form-control" id="register-repeatPassword" required>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="termsAndConditions">
                                <label class="custom-control-label" style="margin-bottom: 15px" for="termsAndConditions">Prin crearea acestui cont, esti de acord cu <a href="/termeni-si-conditii">termenii si conditiile</a></label>
                        
                            </div><!-- End .custom-checkbox -->

                            <div class="form-footer">
                                <button onclick="register()"class="btn btn-primary register-button">Inregistrare</button>
                            </div><!-- End .form-footer -->
                        </div style="margin-bottom: 15px">
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->
    </div>
        
<?php include('./templates/mobile-menu/mobile-menu.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>