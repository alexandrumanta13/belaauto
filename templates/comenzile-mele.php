
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

if ((isset($_GET['filtrare'])) and (in_array($_GET['filtrare'],array("asteptare","preluata","finalizata","anulata")))){
    $show = $_GET['filtrare'];
}
else{
    $show = "asteptare";
}

if(isset($_GET['comanda'])) {
    $orders = new Orders($_GET['comanda']);
} else {
    $orders = Orders::All($show);
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
                <div class="col-lg-9 order-lg-last dashboard-content">
                    <h2><?= (isset($_GET['comanda']) ? 'Comanda plasata pe data de: ' . $orders->date_added  : 'Comenzile mele') ?></h2>
                    <?php
                        if(!isset($_GET['comanda'])) {
                    ?>
                    <form class="row" action="" method="get">
                        <div class="form-group col-md-3 col-sm-12">
                            <div class="select-custom">
                                
                                <select class="form-control" name="filtrare" onchange="this.form.submit()">
                                    <option value="" selected disabled>Filtreaza</option>
                                    <option value="asteptare" <?php echo ((isset($_GET['filtrare'])) and ($_GET['filtrare']=='asteptare')) ? "selected=\"selected\"" : "";?>>In asteptare</option>
                                    <option value="preluata" <?php echo ((isset($_GET['filtrare'])) and ($_GET['filtrare']=='preluata')) ? "selected=\"selected\"" : "";?>>Preluate</option>
                                    <option value="finalizata" <?php echo ((isset($_GET['filtrare'])) and ($_GET['filtrare']=='finalizata')) ? "selected=\"selected\"" : "";?>>Finalizate</option>
                                    <option value="anulata" <?php echo ((isset($_GET['filtrare'])) and ($_GET['filtrare']=='anulata')) ? "selected=\"selected\"" : "";?>>Anulate</option>
                                </select>
                                   
                            </div><!-- End .select-custom -->
                        </div><!-- End .form-group -->
                    </form>
                    <?php
                        }

                        if (!empty($orders) && !isset($_GET['comanda'])){
                            foreach ($orders as $order) {
                                ?>
                                <div class="featured-box featured-box-primary align-left">
                                    <div class="box-content clearfix">   
                                        <p>Comanda plasata pe data de: <?= $order->date_added ?> | Total: <?= Functions::FormatPrice(number_format($order->getTotal(),2,'.','')) ?></p>
                                        <div class="clearfix">
                                            <span class="float-left">
                                                Status: <strong><?= $order->status ?></strong>
                                            </span>
                                            <a class="btn btn-sm btn-outline-secondary float-right" href="/comenzile-mele?comanda=<?= $order->id ?>">Detalii comanda</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else if(isset($_GET['comanda'])){
                            $product_orders = $orders->getProducts();
                            print_r($product_orders);
                            foreach($product_orders as $products) {
                               $product = new Product($products);
                            ?>
                                <div class="featured-box featured-box-primary align-left">
                                    <div class="box-content clearfix">   
                                        
                                    </div>
                                </div>
                            <?php
                            }
            
                        } else{
                           ?>
                            <div class="featured-box featured-box-primary align-left">
                                <div class="box-content">   
                                    <p>Nu aveti nicio comanda inregistrata</p>
                                    <a class="btn btn-sm btn-outline-secondary" href="/anvelope">Inapoi la cumparaturi</a>
                                </div>
                            </div>
                           <?php
                        }
                    ?>
                    
                </div><!-- End .col-lg-9 -->
                <aside class="sidebar col-lg-3">
                    <div class="widget widget-dashboard">
                        <ul class="list">
                            <li><a href="/contul-meu">Contul meu</a></li>
                            <li><a href="/informatii-contact">Informatii contact</a></li>
                            <li><a href="/adrese">Adrese</a></li>
                            <li class="active"><a>Comenzile mele</a></li>
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