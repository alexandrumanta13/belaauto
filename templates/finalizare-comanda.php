<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
$user = new User();

try{
	$logged_in = $user->loggedIn();
}
catch (Exception $e){
	$errors[] = $e->getMessage();
	$logged_in = false;
}

if (isset($_POST['login'])){

    $persistent = false;
    if(!$user->login($_POST['email'], $_POST['password'], $persistent)){
        $_SESSION['error'] = "Datele de autentificare sunt incorecte!";
    } 
    header("Location: /finalizare-comanda");
}

if (isset($_GET['salveaza'])){
    $address = new Address();
    $address->user_id = $user->id;
    $address->address = $_GET['adresa'];
    $address->town = $_GET['oras'];
    $address->company = $_GET['companie'];
    $address->phone = $_GET['telefon'];
    $address->name = $_GET['nume'];
    $address->last_name = $_GET['prenume'];

    if(!$address->save()){
        $_SESSION['error'] = "Adresa nu a fost salvata!";
    } 

    header("Location: /finalizare-comanda");
    
}



$cart = new Cart();

if (isset($_POST['checkout'])){
    
    if (!empty($cart->items)){
        $order = new Orders();
        if ($logged_in){
            $order->user_id = $user->id;
        } else {
            $order->user_id = 0;
        }


        $address = new Address($_POST['address-selected']);
        $order->date_added = date('Y-m-d H:i:s');

        if($_POST['address-selected'] == 0) {
            $order->name = $_GET['nume'] . ' ' . $_GET['prenume'];
            $order->phone = $_GET['telefon'];
            $order->address = $_GET['adresa'] . ' ' . $_GET['oras'];
            $order->comapny = $_GET['companie'];
        } else {
            $order->name = $address->name . ' ' . $address->last_name;
            $order->phone = $address->phone;
            $order->address = $address->address . ' ' . $address->town;
            $order->company = $address->company;
        }
        

        try{
            if (($order->save()) and ($order->saveItems($cart->items))){
                $cart->deleteCart();
                $_SESSION['success-order'] = 'Comanda a fost trimisa cu succes! Multumim!';
                header("Location: /");
            }
            else{
                echo "<p>Comanda nu a fost efectuata</p>";
            }
        }
        catch(Exception $e){
            echo "<p>" . $e->getMessage() . "</p>";
        }
    }

}
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Acasa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Finalizare comanda</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">

            <div class="row">
                <div class="col-lg-8">
                    <ul class="checkout-steps">
                        <li>
                            <h2 class="step-title">Adresa de livrare</h2>
                            <?php 
                            if (!$logged_in) {
                                ?>
                                <form action="" method="POST">
                                    <div class="form-group required-field">
                                        <label>Email </label>
                                        <div class="form-control-tooltip">
                                            <input type="email" name="email" class="form-control" required>
    
                                        </div><!-- End .form-control-tooltip -->
                                    </div><!-- End .form-group -->

                                    <div class="form-group required-field">
                                        <label>Parola </label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div><!-- End .form-group -->
                                    
                                    <p>Daca ai deja cont, te poti autentifica sau poti continua comanda</p>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary">AUTENTIFICARE</button>
                                        <input type="hidden" name="login" value="true">
                                        <a href="forgot-password.html" class="forget-pass"> Ai uitat parola?</a>
                                    </div><!-- End .form-footer -->
                                </form>
                                <form action="#">
                                    <div class="form-group required-field">
                                        <label>Nume </label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group required-field">
                                        <label>Prenume </label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label>Companie </label>
                                        <input type="text" class="form-control">
                                    </div><!-- End .form-group -->

                                    <div class="form-group required-field">
                                        <label>Adresa </label>
                                        <input type="text" class="form-control" required>
                                    
                                    </div><!-- End .form-group -->

                                    <div class="form-group required-field">
                                        <label>Oras  </label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group required-field">
                                        <label>Telefon </label>
                                        <input type="tel" class="form-control" required>
                                    </div><!-- End .form-group -->
                                </form>
                                <?php
                            } else {
                                ?>
                                <form action="" method="POST" id="form-order">
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
                                                    <!-- <a href="#" class="btn btn-sm btn-link">
                                                        Edit
                                                    </a> -->

                                                    <a class="btn btn-sm btn-outline-secondary float-right">
                                                        Alege
                                                    </a>
                                                </div><!-- End .address-box-action -->
                                            </div><!-- End .shipping-address-box -->
                                        <?php
                                    }
                                    ?>
                                   
                                    <?php
                                    if (isset($_GET['adresa'])) {
                                    ?>
                                        <div class="shipping-address-box mt-2" data-id="0">
                                            <address>
                                                <?= $_GET['nume']  . ' ' . $_GET['prenume'] ?> <br>
                                                <?= $_GET['adresa'] ?> <br>
                                                <?= $_GET['oras'] ?> <br>
                                                <?= $_GET['telefon'] ?> <br>
                                            
                                            </address>

                                            <div class="address-box-action clearfix">
                                               

                                                <button class="btn btn-sm btn-outline-secondary float-right">
                                                    Alege
                                                </button>
                                            </div><!-- End .address-box-action -->
                                        </div><!-- End .shipping-address-box -->
                                    <?php
                                    } else {
                                        ?>
                                        <p class="mt-2">Nu aveti adrese introduse</p>
                                        <?php
                                    }
                                }
                                        
                               ?>
                                </div><!-- End .shipping-step-addresses -->
                                <input type="hidden" name="checkout" value="true">
                                </form>
                                <a href="#" class="btn btn-sm btn-outline-secondary btn-new-address" data-toggle="modal" data-target="#addressModal">+ Adresa noua</a>
                                <?php
                            }
                            ?>
                        </li>

                        <li>
                            <div class="checkout-step-shipping">
                                <h2 class="step-title">Metoda de ivrare</h2>

                                <table class="table table-step-shipping">
                                    <tbody>
                                        <tr>
                                            <td><input checked disabled type="radio" name="shipping-method" value="flat"></td>
                                            <td><strong>20 Lei</strong></td>
                                            <td>Ramburs</td>
                                 
                                        </tr>

                                      
                                    </tbody>
                                </table>
                            </div><!-- End .checkout-step-shipping -->
                        </li>
                    </ul>
                </div><!-- End .col-lg-8 -->

                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3>Sumar</h3>
                        <?php
                            $cart = new Cart();
                        ?>
                        <h4>
                            <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section"><?= count($cart->items) ?> produse in cos</a>
                        </h4>

                        <div class="collapse" id="order-cart-section">
                            <table class="table table-mini-cart">
                                <tbody>
                                    <?php

                                   
                                    if (!empty($cart->items)) {
                                        $total = 0;
                                        foreach($cart->items as $prod_id=>$qty){
                                            try{
                                                $product = new Product($prod_id);
                                            }
                                            catch (Exception $e){
                                                die("Eroare necunoscuta");
                                            }
                                            ?>
                                            <tr>
                                                <td class="product-col">
                                                    <figure class="product-image-container">
                                                        <a class="product-image">
                                                            <img src="<?= $product->image ?>">
                                                        </a>
                                                    </figure>
                                                    <div>
                                                        <h2 class="product-title">
                                                            <a href="product.html"><?= $product->model ?></a>
                                                        </h2>

                                                        <span class="product-qty">Cnt: <?= $qty ?></span>
                                                    </div>
                                                </td>
                                                <td class="price-col"><?= $product->price ?></td>
                                            </tr>
                                            <?php
                                            
                                        }

                                    }
                                    ?>
                                   
                                </tbody>    
                            </table>
                        </div><!-- End #order-cart-section -->
                    </div><!-- End .order-summary -->
                </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->

            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-steps-action">
                        <button onclick="submit()" class="btn btn-primary float-right">COMANDA</button>
                    </div><!-- End .checkout-steps-action -->
                </div><!-- End .col-lg-8 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-6"></div><!-- margin -->
    </main><!-- End .main -->

    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>

 <!-- Modal -->
 <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h3 class="modal-title" id="addressModalLabel">Adresa de livrare</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- End .modal-header -->
                    <form action="" method="GET">
                        <div class="modal-body">
                            <div class="form-group required-field">
                                <label>Nume </label>
                                <input type="text" name="nume" class="form-control form-control-sm" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Prenume </label>
                                <input type="text" name="prenume" class="form-control form-control-sm" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label>Companie </label>
                                <input type="text" name="companie" class="form-control form-control-sm">
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Adresa </label>
                                <input type="text" name="adresa" class="form-control form-control-sm" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Oras  </label>
                                <input type="text" name="oras" class="form-control form-control-sm" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Telefon</label>
                                <input type="tel" name="telefon" class="form-control form-control-sm" required>
                            </div><!-- End .form-group -->
                            <?php
                            if ($logged_in) {
                                ?>
                            
                                <div class="form-group-custom-control">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="salveaza" class="custom-control-input" id="address-save">
                                        <label class="custom-control-label" for="address-save">Salveaza in "Adresele mele"</label>
                                    </div><!-- End .custom-checkbox -->
                                </div><!-- End .form-group -->
                                <input type="hidden" name="user" value="<?= $user->id ?>">
                                <?php
                            }
                            ?>
                
                        </div><!-- End .modal-body -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link btn-sm" data-dismiss="modal">Inchide</button>
                            <button type="submit" class="btn btn-primary btn-sm">Salveaza</button>
                        </div><!-- End .modal-footer -->
                </form>
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

<script>
    const box = document.querySelectorAll('.shipping-address-box');
    const boxArr = [...box];
    const lastBox = boxArr[boxArr.length - 1];

    lastBox.classList.add('active');
    const input = document.createElement('input');
    input.setAttribute('value', lastBox.dataset.id);
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'address-selected');
    lastBox.append(input);

    boxArr.map((item, idx) => {
        item.addEventListener('click', function () {
            boxArr.map(box => {
                const input = document.querySelector('.active input');
                if(input){
                    input.remove();
                }
                
                box.classList.remove('active');
                
            });
            this.classList.add('active');
            input.setAttribute('value', this.dataset.id);
            this.append(input);
        });
    });

    
    const submit = () => {
        const form = document.getElementById("form-order");
        form.submit();
    }
    
   
</script>