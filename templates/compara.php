<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
    $sort = 12;
    $order = "DESC";
   
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                    <li class="breadcrumb-item"><a href="#">Magazin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Anvelope</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row compare-table-container" id="product-list">
                        <h2 class="col-md-12">
                            Compara produse
                        </h2>
                        <div class="col-md-12">
                            <table class="table table-compare">
                                <tbody>
                                    <td></td>
                                <?php

                                $compare = new Compare();
                               
                                foreach($compare->items as $prod_id => $qty ) {
                            
                                    $products = new Product();
                                    $products = $products->getProduct($prod_id);
                            
                                    foreach($products as $product) {
                                
                                        $seasons = new Season();
                                        $season = $seasons->find($product->season_id);
            
                                        $widths = new Width();
                                        $width = $widths->find($product->width_id);
                                        
                                        $heights = new Height();
                                        $height = $heights->find($product->height_id);
                                    
                                        $diameters = new Diameter();
                                        $diameter = $diameters->find($product->diameter_id);
            
                                        $suppliers = new Supplier();
                                        $supplier = $suppliers->find($product->supplier_id);
                                    ?>
                                    <td class="compare-item">
                                        <div class="col-md-12">
                                            <div class="product">
                                                <figure class="product-image-container">
                                                    <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                        <img src="<?= $product->image ?>" alt="product">
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h2 class="product-title">
                                                        <a
                                                            href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/R" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                    </h2>
                                                    <div class="price-box">
                                                        <span class="product-price"><?= $product->price ?> Lei</span>
                                                    </div><!-- End .price-box -->


                                                </div><!-- End .product-details -->
                                            </div><!-- End .product -->
                                        </div>
                                    </td>

                                    <?php
                                    }
                                }
                            ?>
                            <tr>
                                <th colspan="5">
                                    <h2>Caracteristici </h2>
                                </th>
                            </tr>
                        
                           
                            
                                
                        
                            <tr>
                                <td class="compare-info">Model</td>
                                <?php
                                    foreach($compare->items as $prod_id => $qty ) {
                                        $product = new Product($prod_id);
                                        ?>
                                        <td><?= $product->model; ?></td>
                                        <?php
                                    }
                                ?>
                            </tr>
                            
                        <?php
                            
                        ?>
                        </tbody>
                                    <tfoot>
                                        
                                    </tfoot>
                    </table>
                    </div><!-- End .row -->
                   
                </div><!-- End .col-lg-12 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->

    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>


<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>