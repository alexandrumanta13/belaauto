<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
    $product = new Product($_GET['produs']);
    $season = new Season($product->season_id);                                          
    $width = new Width($product->width_id);
    $height = new Height($product->height_id);
    $diameter = new Diameter($product->diameter_id);
    $supplier = new Supplier($product->supplier_id);
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                    <li class="breadcrumb-item"><a href="#">Magazin</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= "Anvelope " . $season->season_name . " " . $width->width_name . "/" . $height->height_name . "/R" . $diameter->diameter_name . " " . $product->product_name . " " . $supplier->supplier_name . " " . $product->model ?></li>
                </ol>
            </div><!-- End .container -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-single-container product-single-default">
                        <div class="row">
                        <div class="col-lg-7 col-md-6">
                                    <div class="product-single-gallery">
                                        <div class="product-slider-container product-item">
                                            <div class="product-single-carousell">
                                                <div class="product-item">
                                                    <img class="product-single-image" src="<?= $product->image ?>"/>
                                                </div>
                                                
                                            </div>
                                            <!-- End .product-single-carousel -->
                                            
                                        </div>
                                        
                                    </div><!-- End .product-single-gallery -->
                                </div><!-- End .col-lg-7 -->


                            <div class="col-lg-5 col-md-6">
                                <div class="product-single-details">
                                    <h1 class="product-title"><?= "Anvelope " . $season->season_name . " " . $width->width_name . "/" . $height->height_name . "/R" . $diameter->diameter_name . " " . $product->product_name . " " . $supplier->supplier_name . " " . $product->model ?></h1>

                                    <!-- <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:60%"></span>
                                        </div>

                                        <a href="#" class="rating-link">( 6 Reviews )</a>
                                    </div> -->

                                    <div class="price-box">
                                        
                                        <span class="product-price"><?= $product->price ?> Lei</span>
                                    </div><!-- End .price-box -->

                                    <!-- <div class="product-desc">
                                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non.</p>
                                    </div> -->
                                    <div class="product-filters-container">
                                        <div class="product-single-filter">
                                            <label>Model:</label>
                                            <h3 class="mb-0"><?= $product->model ?></h3>
                                        </div>
                                        <div class="product-single-filter">
                                            <label>Producator:</label>
                                            <h3 class="mb-0"><?= $supplier->supplier_name ?></h3>
                                        </div>
                                        <div class="product-single-filter">
                                            <label>Sezon:</label>
                                            <h3 class="mb-0"><?= $season->season_name ?></h3>
                                        </div><!-- End .product-single-filter -->
                                        
                                        <div class="product-single-filter">
                                            <label>Latime:</label>
                                            <h3 class="mb-0"><?= $width->width_name ?></h3>
                                        </div><!-- End .product-single-filter -->

                                        <div class="product-single-filter">
                                            <label>Inaltime:</label>
                                            <h3 class="mb-0"><?= $height->height_name ?></h3>
                                        </div><!-- End .product-single-filter -->
                                        <div class="product-single-filter">
                                            <label>Diametru:</label>
                                            <h3 class="mb-0"><?= $diameter->diameter_name ?></h3>
                                        </div><!-- End .product-single-filter -->

                                        <div class="product-single-filter">
                                            <label>Indice de sarcina:</label>
                                            <h3 class="mb-0"><?= $product->weight_index ?></h3>
                                        </div><!-- End .product-single-filter -->
                                        <div class="product-single-filter">
                                            <label>Indice viteza:</label>
                                            <h3 class="mb-0"><?= $product->speed_index ?></h3>
                                        </div><!-- End .product-single-filter -->

                                        <div class="product-single-filter">
                                            <label>Clasa consum:</label>
                                            <h3 class="mb-0"><?= $product->consumption_class ?></h3>
                                        </div><!-- End .product-single-filter -->
                                        <div class="product-single-filter">
                                            <label>Aderenta:</label>
                                            <h3 class="mb-0"><?= $product->adhesion ?></h3>
                                        </div><!-- End .product-single-filter -->

                                        <div class="product-single-filter">
                                            <label>Zgomot:</label>
                                            <h3 class="mb-0"><?= $product->noise ?></h3>
                                        </div><!-- End .product-single-filter -->
                                        
                                    </div><!-- End .product-filters-container -->

                                    <div class="product-action">
                                        <div class="product-single-qty">
                                            <input class="horizontal-quantity form-control" type="text">
                                        </div><!-- End .product-single-qty -->

                                        <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adauga in cos</span>
                                                                                </a>

                                        <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                            <span>Add to Wishlist</span>
                                        </a>
                                    </div><!-- End .product-action -->

                                    
                                </div><!-- End .product-single-details -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-single-container -->

                  
                </div><!-- End .col-lg-9 -->

                
            </div><!-- End .row -->

           

            <div class="mb-lg-4"></div><!-- margin -->
        </div><!-- End .container -->
    </main><!-- End .main -->
    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>
<?php include('./templates/success-message/success-message.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>