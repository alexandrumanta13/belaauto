
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
$address = new Address();
if(isset($_POST['new-address'])) {

    $data = array(
        'name' => array('required' => '"Numele nu poate fi gol'),
        'last_name' => array('required' => '"Prenumele nu poate fi gol'),
        'phone' => array('required' => '"Numarul de telefon nu poate fi gol', 'numeric' => '"Numarul de telefon este invalid'),
        'town' => array('required' => '"Orasul nu poate fi gol'),
        'address' => array('required' => '"Adresa nu poate fi goala'),
    );
        
    try{
        $errors = Functions::Validate($data, $_POST);
        if (!$errors){
            
            if (isset($_GET['editeaza'])) {
                $address->id = $_GET['editeaza'];
            }    
            $address->user_id = $user->id;
            $address->name = $_POST['name'];
            $address->last_name = $_POST['last_name'];
            $address->phone = $_POST['phone'];
            $address->company = $_POST['company'];
            $address->town = $_POST['town'];
            $address->address = $_POST['address'];
            if($address->save()) {
                $_SESSION['succes'] = "Adresa a fost salvata cu succes!";
                header('Location: /adrese');
            }
        }
    } catch (Exception $e){
        $errors[] = $e->getMessage();
    }
}

if(isset($_POST['delivery'])) {
    $delivery_address = Database::table('address')->select()->where('delivery', '=', 1)->get();
    if(!empty($delivery_address)) {
        $unset_delivery_address = new Address();
        $unset_delivery_address->id = $delivery_address[0]->id;
        $unset_delivery_address->delivery = 0;

        if($unset_delivery_address->save()) {
            $new_delivery_address = new Address();
            $new_delivery_address->id = $_POST['delivery'];
            $new_delivery_address->delivery = 1;
    
            if($new_delivery_address->save()) {
                $_SESSION['succes'] = "Adresa a fost salvata cu succes!";
                header('Location: /adrese');
            }
        }
    } else {
        $new_delivery_address = new Address();
        $new_delivery_address->id = $_POST['delivery'];
        $new_delivery_address->delivery = 1;

        if($new_delivery_address->save()) {
            $_SESSION['succes'] = "Adresa a fost salvata cu succes!";
            header('Location: /adrese');
        }
    }
}

if(isset($_POST['invoice'])) {
    $invoice_address = Database::table('address')->select()->where('invoice', '=', 1)->get();
    if(!empty($invoice_address)) {
        $unset_invoice_address = new Address();
        $unset_invoice_address->id = $invoice_address[0]->id;
        $unset_invoice_address->invoice = 0;

        if($unset_invoice_address->save()) {
            $new_invoice_address = new Address();
            $new_invoice_address->id = $_POST['invoice'];
            $new_invoice_address->invoice = 1;
    
            if($new_invoice_address->save()) {
                $_SESSION['succes'] = "Adresa a fost salvata cu succes!";
                header('Location: /adrese');
            }
        }
    } else {
        $new_invoice_address = new Address();
        $new_invoice_address->id = $_POST['invoice'];
        $new_invoice_address->invoice = 1;

        if($new_invoice_address->save()) {
            $_SESSION['succes'] = "Adresa a fost salvata cu succes!";
            header('Location: /adrese');
        }
    }
}

if(isset($_POST['delete'])) {
    $delete_address = new Address();
    if($delete_address->delete($_POST['delete'])) {
        $_SESSION['succes'] = "Adresa a fost stearsa cu succes!";
        header('Location: /adrese');
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
                    <li class="breadcrumb-item active" aria-current="page">Adrese</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
               
                <?php

                if(isset($_GET['adauga-adresa']) || isset($_GET['editeaza'])) {
                    ?>
                    <div class="col-lg-9 order-lg-last dashboard-content">
                        <?php if ((isset($errors)) and (is_array($errors))) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errors as $error) :
                                echo '<p>' . $error . '</p>';
                                endforeach; ?>
                            </div>
                        <?php 
                            endif; 
                            if (isset($_GET['editeaza'])) {
                                $edit = new Address($_GET['editeaza']);
                            }    
                        ?>
                        <form class="" action="" method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group required-field">
                                                <label for="name">Nume</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?= (isset($_POST['name']) ? $_POST['name'] : (isset($_GET['editeaza']) ? $edit->name : '')) ?>" required>
                                            </div><!-- End .form-group -->
                                        </div><!-- End .col-md-4 -->

                                        <div class="col-md-6">
                                            <div class="form-group required-field">
                                                <label for="last_name">Prenume</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= (isset($_POST['last_name']) ? $_POST['last_name'] : (isset($_GET['editeaza']) ? $edit->last_name : '')) ?>" required>
                                            </div><!-- End .form-group -->
                                        </div><!-- End .col-md-4 -->
                                    </div><!-- End .row -->
                                </div><!-- End .col-sm-11 -->
                            </div><!-- End .row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group required-field">
                                                <label for="phone">Telefon</label>
                                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= (isset($_POST['phone']) ? $_POST['phone'] : (isset($_GET['editeaza']) ? $edit->phone : '')) ?>" required>
                                            </div><!-- End .form-group -->
                                        </div><!-- End .col-md-4 -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company">Companie</label>
                                                <input type="text" class="form-control" id="company" value="<?= (isset($_POST['company']) ? $_POST['company'] : (isset($_GET['editeaza']) ? $edit->company : '')) ?>"  name="company">
                                            </div><!-- End .form-group -->
                                        </div><!-- End .col-md-4 -->
                                    </div><!-- End .row -->
                                </div><!-- End .col-sm-11 -->
                            </div>
                            <div class="form-group required-field">
                                <label for="town">Oras</label>
                                <input type="text" class="form-control" id="town" name="town" value="<?= (isset($_POST['town']) ? $_POST['town'] : (isset($_GET['editeaza']) ? $edit->town : '')) ?>" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label for="address">Adresa</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= (isset($_POST['address']) ? $_POST['address'] : (isset($_GET['editeaza']) ? $edit->address : '')) ?>" required>
                            </div><!-- End .form-group -->

                            <div class="mb-2"></div><!-- margin -->

                            <div class="required text-right">* Campuri obligatorii</div>
                            <div class="form-footer">
                                <div class="form-footer-right">
                                    <input type="hidden" name="new-address" value="true">
                                    <button type="submit" class="btn btn-primary">Salveaza</button>
                                </div>
                            </div><!-- End .form-footer -->
                        </form>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-lg-9 order-lg-last dashboard-content">
                        <?php if (isset($_SESSION['succes'])) : ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['succes']; ?>
                            </div>
                            <?php unset($_SESSION['succes']);
                        endif ; ?>
                        <h2>Adresele mele</h2>
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
                        
                        <div class="shipping-step-addresses">
                            <?php
                            unset($_SESSION['error']);
                            $addresses = Address::AllAddresses($user->id);

                            if(count($addresses) > 0) {
                                ?>
                                
                                <?php
                                $numItems = count($addresses);
                                $i = 0;
                                
                                $active = 'not-active';
                                foreach($addresses as $address) {
                                    if(++$i === $numItems || isset($_GET['adresa'])) {
                                        $active = 'active';
                                    }
                                    ?>
                                        <div class="shipping-address-box mt-2" data-id="<?= $address->id ?>">
                                            <address>
                                                <?= $address->name . ' ' . $address->last_name ?> <br>
                                                <?= $address->address ?> <br>
                                                <?= $address->town ?> <br>
                                                <?= $address->phone ?> <br>
                                            
                                            </address>

                                            <div class="address-box-action clearfix">
                                                <div class="clearfix col-sm-12">
                                                    <div class="row">
                                                        <form action="/adrese?editeaza=<?= $address->id ?>" class="float-left" method="POST" id="form-order">
                                                            <button type="submit" class="btn btn-sm btn-link">
                                                                Editeaza
                                                            </button>
                                                        </form>
                                                        <form action="" method="POST" class="float-right ml-5" id="form-order">
                                                            <button type="submit" class="btn btn-sm btn-link">
                                                                Sterge
                                                            </button>
                                                            <input type="hidden" name="delete" value="<?= $address->id ?>">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="clearfix col-sm-12">
                                                    <div class="row">
                                                        <form action="" method="POST" id="form-order" class="float-left">
                                                            <button <?= ($address->invoice == 1 ? 'disabled' : '') ?> class="btn btn-sm btn-outline-secondary float-right">
                                                                Facturare
                                                            </button>
                                                            <input type="hidden" name="invoice" value="<?= $address->id ?>">
                                                        </form>
                                                        <form action="" method="POST" id="form-order" class="float-right ml-5">
                                                            <button <?= ($address->delivery == 1 ? 'disabled' : '') ?> class="btn btn-sm btn-outline-secondary float-right">
                                                                Livrare
                                                            </button>
                                                            <input type="hidden" name="delivery" value="<?= $address->id ?>">
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                            </div><!-- End .address-box-action -->
                                        </div><!-- End .shipping-address-box -->
                                    <?php
                                }
                                
                            }
                                        
                            ?>
                        </div><!-- End .shipping-step-addresses -->
                        
                        <a href="/adrese?adauga-adresa=1" class="btn btn-sm btn-outline-secondary btn-new-address">+ Adresa noua</a>
                    </div><!-- End .col-lg-9 -->
                    <?php
                }

               ?>
            
                <aside class="sidebar col-lg-3">
                    <div class="widget widget-dashboard">
                        <ul class="list">
                            <li><a href="/contul-meu">Contul meu</a></li>
                            <li><a href="/informatii-contact">Informatii contact</a></li>
                            <li class="active"><a>Adrese</a></li>
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