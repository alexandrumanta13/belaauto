
<?php 
title( 'BelaAuto &#8211; tyres and more'); meta( ''); 

$user = new User();

try{
	$logged_in = $user->loggedIn();
    if (!$logged_in){
		header('Location: /');
	}
}
catch (Exception $e){
	$errors[] = $e->getMessage();
	$logged_in = false;
}

if(isset($_POST['info'])) {

    $data = array(
        'name' => array('required' => '"Numele nu poate fi gol'),
        'last_name' => array('required' => '"Prenumele nu poate fi gol'),
        'email' => 
            (isset($_POST['email']) && $_POST['email'] != $user->email ?
            array('email' => 'Email invalid', 'check_db' => array('users', 'email','Emailul exista deja in baza de date')) : array('email' => '')),
        );
        if(isset($_POST['change-password'])) {
            $data['password']  = array('required' => 'Completati parola','match' => array('repeat','Parolele nu se potrivesc'));
            $data['repeat'] = array('required' => 'Repeta parola');
        }
        
    try{
        $errors = Functions::Validate($data, $_POST);
        if (!$errors){
            $user->id = $user->id;
            $user->name = $_POST['name'];
            $user->last_name = $_POST['last_name'];
            if($_POST['email'] != $user->email) {
                $user->email = $_POST['email'];
            }
            
            $user->phone = $_POST['phone'];

            if(isset($_POST['change-password']) == true) {
                $user->password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            } 
            if($user->save()) {
                header('Location: /informatii-contact');
            }
        }
    } catch (Exception $e){
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
                    <li class="breadcrumb-item active" aria-current="page">Informatii contact</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last dashboard-content">
                    <h2>Editeaza informatii contact</h2>
                    <?php
                    if ((isset($errors)) and (is_array($errors))) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $error) :
                            echo '<p>' . $error . '</p>';
                            endforeach; ?>
                        </div>
                    <?php 
                        endif; 
                    ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label for="name">Nume</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?= $user->name ?>" required>
                                        </div><!-- End .form-group -->
                                    </div><!-- End .col-md-4 -->

                                    <div class="col-md-6">
                                        <div class="form-group required-field">
                                            <label for="last_name">Prenume</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->last_name ?>" required>
                                        </div><!-- End .form-group -->
                                    </div><!-- End .col-md-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .col-sm-11 -->
                        </div><!-- End .row -->

                        <div class="form-group required-field">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" required>
                        </div><!-- End .form-group -->

                        <div class="form-group required-field">
                            <label for="phone">Telefon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= $user->phone ?>" required>
                        </div><!-- End .form-group -->

                        <div class="mb-2"></div><!-- margin -->

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="change-pass-checkbox" name="change-password" value="true">
                            <label class="custom-control-label" for="change-pass-checkbox">Schimba parola</label>
                        </div><!-- End .custom-checkbox -->

                        <div id="account-chage-pass">
                            <h3 class="mb-2">Schimba parola</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label for="acc-pass2">Parola</label>
                                        <input type="password" class="form-control" id="acc-pass2" name="password">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-6 -->

                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label for="acc-pass3">Repeta parola</label>
                                        <input type="password" class="form-control" id="acc-pass3" name="repeat">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-6 -->
                            </div><!-- End .row -->
                        </div><!-- End #account-chage-pass -->

                        <div class="required text-right">* Campuri obligatorii</div>
                        <div class="form-footer">
                          
                            <div class="form-footer-right">
                                <input type="hidden" name="info" value="true">
                                <button type="submit" class="btn btn-primary">Salveaza</button>
                            </div>
                        </div><!-- End .form-footer -->
                    </form>
                </div><!-- End .col-lg-9 -->

                <aside class="sidebar col-lg-3">
                    <div class="widget widget-dashboard">
                        <ul class="list">
                            <li><a href="/contul-meu">Contul meu</a></li>
                            <li class="active"><a>Informatii contact</a></li>
                            <li><a href="/adrese">Adrese</a></li>
                            <li><a href="/comenzile-mele">Comenzile mele</a></li>
                        </ul>
                    </div><!-- End .widget -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->
    <?php include('./templates/footer/footer.php'); ?>
</div>
<?php include('./templates/success-message/success-message.php'); ?>
<?php include('./templates/mobile-menu/mobile-menu.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>