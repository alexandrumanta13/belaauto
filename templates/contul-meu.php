
<?php 
title( 'BelaAuto &#8211; tyres and more'); meta( ''); 

$user = new User();

try{
	$logged_in = $user->loggedIn();
    if (!$logged_in){
		header('Location: /autentificare');
	}
}
catch (Exception $e){
	$errors[] = $e->getMessage();
	$logged_in = false;
}

?>

<div class="page-wrapper">
	<?php include('./templates/header/header.php'); ?>
    <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contul meu</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-last dashboard-content">
                        <h2>Contul meu</h2>

                        <!-- <div class="alert alert-success alert-intro" role="alert">
                            
                        </div>

                        <div class="alert alert-success" role="alert">
                           
                        </div> -->

                        <div class="mb-4"></div><!-- margin -->

                        <h3>Informatii cont</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Informatii contact
                                        <a href="/informatii-contact" class="card-edit">Editeaza</a>
                                    </div><!-- End .card-header -->

                                    <div class="card-body">
                                        <p>
                                            <?= $user->name . ' ' . $user->last_name ?><br>
                                            <?= $user->email ?><br>
                                            <?= $user->phone ?><br>
                                            <a href="/informatii-contact">Schimba parola</a>
                                        </p>
                                    </div><!-- End .card-body -->
                                </div><!-- End .card -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        newsletters
                                        <a href="#" class="card-edit">Editeaza</a>
                                    </div><!-- End .card-header -->

                                    <div class="card-body">
                                        <p>
                                            Momentan nu esti inscris la niciun newsletter
                                        </p>
                                    </div><!-- End .card-body -->
                                </div><!-- End .card -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->

                        <div class="card">
                            <div class="card-header">
                                Adrese
                                <a href="/adrese" class="card-edit">Editeaza</a>
                            </div><!-- End .card-header -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="">Adresa de facturare prestabilita</h4>
                                        <address>
                                            <?php
                                                $invoice_address_conditions[] = ['user_id', '=', $user->id];
                                                $invoice_address_conditions[] = ['invoice', '=', 1];
                                                $invoice_address = Database::table('address')->select()->where($invoice_address_conditions)->get();
                                                if(!empty($invoice_address)) {
                                                    echo $invoice_address[0]->address . 
                                                    ', ' . $invoice_address[0]->town . 
                                                    ', ' . $invoice_address[0]->phone . 
                                                    ', ' . $invoice_address[0]->name . 
                                                    ' ' . $invoice_address[0]->last_name .
                                                    ', ' . $invoice_address[0]->company . '<br>';
                                                } else {
                                                    echo 'Momentan nu ai setata nicio adresa prestabilita<br>';
                                                }

                                            ?>
                                            
                                            <a href="/adrese">Editeaza adrese</a>
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="">Adresa de livrare prestabilita</h4>
                                        <address>
                                            <?php
                                                $delivery_address_conditions[] = ['user_id', '=', $user->id];
                                                $delivery_address_conditions[] = ['delivery', '=', 1];
                                                $delivery_address = Database::table('address')->select()->where($delivery_address_conditions)->get();
                                                if(!empty($delivery_address)) {
                                                    echo $delivery_address[0]->address . 
                                                    ', ' . $delivery_address[0]->town . 
                                                    ', ' . $delivery_address[0]->phone . 
                                                    ', ' . $delivery_address[0]->name . 
                                                    ' ' . $delivery_address[0]->last_name .
                                                    ', ' . $delivery_address[0]->company . '<br>';
                                                } else {
                                                    echo 'Momentan nu ai setata nicio adresa prestabilita<br>';
                                                }

                                            ?>
                                            <a href="/adrese">Editeaza adrese</a>
                                        </address>
                                    </div>
                                </div>
                            </div><!-- End .card-body -->
                        </div><!-- End .card -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar col-lg-3">
                        <div class="widget widget-dashboard">
                            

                            <ul class="list">
                                <li class="active"><a>Contul meu</a></li>
                                <li><a href="/informatii-contact">Informatii contact</a></li>
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