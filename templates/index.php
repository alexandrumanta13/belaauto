<?php title('BelaAuto &#8211; tyres and more'); meta(''); ?>

<div class="page-wrapper">
	<?php include('./templates/header/header.php'); ?>
	    <main class="main">
            <div class="home-top-container">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="home-slider owl-carousel owl-carousel-lazy">
                                <div class="home-slide">
                                    <img class="owl-lazy" src="images/lazy.png" data-src="images/slider/mainSlider2.jpg" alt="slider image">
                                    <div class="home-slide-content">
                                        <a href="/contact" class="btn btn-primary">Contactați-ne!</a>
                                    </div><!-- End .home-slide-content -->
                                </div><!-- End .home-slide -->

                                <div class="home-slide">
                                    <a href="anvelope">
                                        <img class="owl-lazy" src="images/lazy.png" data-src="images/slider/promotii_hp.jpg" alt="slider image">                                        
                                    </a>
                                </div><!-- End .home-slide -->
                            </div><!-- End .home-slider -->
                        </div><!-- End .col-lg-8 -->

                        <div class="col-lg-4 top-banners">
                            <form action="/anvelope" class="filter-container" method="get">
                                <h3>Caută anvelope</h3>
                                <div class="form-group">
                                    <div class="select-custom">
                                        <select class="form-control" name="categorie">
                                            <option value="" selected disabled>Tip anvelopă</option>
                                            <?php
                                                $category = new Subcategory();
                                                $categories = $category->getSubcategories();
                                                
                                                if ($categories > 0) {
                                                    foreach ($categories as $category) {
                                                        ?>
                                                        <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->
                                <div class="grouped">
                                    <div class="form-group">
                                        <div class="select-custom">
                                            <select class="form-control" name="latime">
                                                <option value="" selected disabled>Lățime</option>
                                                <?php
                                                    $width = new Width();
                                                    $widths = $width->getWidths();
                                                    
                                                    if ($widths > 0) {
                                                        foreach ($widths as $width) {
                                                            ?>
                                                            <option value="<?= $width->id; ?>"><?= $width->width_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .form-group -->
                                    <div class="form-group">
                                        <div class="select-custom">
                                            <select class="form-control" name="inaltime">
                                                <option value="" selected disabled>Înălțime</option>
                                                <?php
                                                    $height = new Height();
                                                    $heights = $height->getHeights();
                                                    
                                                    if ($heights > 0) {
                                                        foreach ($heights as $height) {
                                                            ?>
                                                            <option value="<?= $height->id; ?>"><?= $height->height_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .form-group -->
                                </div>
                                <div class="form-group">
                                    <div class="select-custom">
                                        <select class="form-control" name="diametru">
                                            <option value="" selected disabled>Diametru</option>
                                            <?php
                                                $diameter = new Diameter();
                                                $diameters = $diameter->getDiameters();
                                                
                                                if ($diameters > 0) {
                                                    foreach ($diameters as $diameter) {
                                                        ?>
                                                        <option value="<?= $diameter->id; ?>"><?= $diameter->diameter_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->
                                <div class="form-group">
                                    <div class="select-custom">
                                        <select class="form-control" name="sezon">
                                            <option value="" selected disabled>Sezon</option>
                                            <?php
                                                $season = new Season();
                                                $seasons = $season->getSeasons();
                                                
                                                if ($seasons > 0) {
                                                    foreach ($seasons as $season) {
                                                        ?>
                                                        <option value="<?= $season->id; ?>"><?= $season->season_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->
                                <div class="form-group">
                                    <div class="select-custom">
                                        <select class="form-control" name="producator">
                                            <option value="" selected disabled>Producător</option>
                                            <?php
                                                $supplier = new Supplier();
                                                $suppliers = $supplier->getSuppliers();
                                                
                                                if ($suppliers > 0) {
                                                    foreach ($suppliers as $supplier) {
                                                        ?>
                                                        <option value="<?= $supplier->id; ?>"><?= $supplier->supplier_name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .form-group -->
                                <button class="btn btn-primary" type="submit">Caută</button>
                            </form>
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .home-top-container -->

            <div class="info-boxes-container">
                <div class="container">
                    <div class="info-box">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>Transport Gratuit</h4>
                            <p>Oriunde în țară, suntem la dispoziția ta!</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box">
                        <i class="icon-us-dollar"></i>

                        <div class="info-box-content">
                            <h4>Garanție și calitate</h4>
                            <p>30 de zile, banii înapoi, fără întrebări</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>Specialiști în anvelope</h4>
                            <p>Mereu la dispoziția ta</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->
                </div><!-- End .container -->
            </div><!-- End .info-boxes-container -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php $currentDate = date("F");
                        $seasons = ['Winter' => ['September', 'October', 'November', 'December', 'January'], 'Summer' => ['February', 'March', 'April', 'May', 'June', 'July', 'August']];
                        $currentSeason = in_array($currentDate, $seasons['Winter']) ? 'Winter' : 'Summer';
                        ?>                       
                        
                        <?php
                            if ($currentSeason == "Winter") {
                                $winter = Database::table('products')->select()->where('season_id', 2)->take(4);
                                if (!empty($winter)) {
                                    ?>
                                <div class="home-product-tabs">        
                                    <h2><a href="">Vezi toate anvelopele de IARNĂ</a></h2>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                            <div class="row row-sm">
                                                <?php
                                                    foreach ($winter as $product) {
                                                        ?>
                                                            <div class="col-6 col-md-3">
                                                                <div class="product">
                                                                    <figure class="product-image-container">
                                                                        <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                            <img src="<?= $product->image ?>" alt="product">
                                                                        </a>
                                                                    </figure>
                                                                    <div class="product-details">
                                                                        <h2 class="product-title">
                                                                            <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                        </h2>
                                                                        <div class="price-box">
                                                                            <span class="product-price"><?= $product->price ?> Lei</span>
                                                                        </div><!-- End .price-box -->

                                                                        <div class="product-action">
                                                                            <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                            <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                <span>Adaugă în coș</span>
                                                                            </a>
                                                                            <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                        </div><!-- End .product-action -->
                                                                    </div><!-- End .product-details -->
                                                                </div><!-- End .product -->
                                                            </div><!-- End .col-md-4 -->
                                                        <?php
                                                    } ?>
                                            </div><!-- End .row -->
                                        </div><!-- End .tab-pane -->
                                    </div><!-- End .tab-content -->
                                </div><!-- End .home-product-tabs -->
                                <?php
                                }
                            } elseif ($currentSeason == "Summer") {
                                $summer = Database::table('products')->select()->where('season_id', 1)->take(4);
                                if (!empty($summer)) {
                                    ?>
                                <div class="home-product-tabs">
                                        <h2><a href="">Vezi toate anvelopele de VARĂ</a></h2>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                                <div class="row row-sm">

                                                    <?php
                                                        $summer = Database::table('products')->select()->where('season_id', 1)->take(4);
                                    foreach ($summer as $product) {
                                        ?>
                                                                <div class="col-6 col-md-3">
                                                                    <div class="product">
                                                                        <figure class="product-image-container">
                                                                            <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                                <img src="<?= $product->image ?>" alt="product">
                                                                            </a>
                                                                        </figure>
                                                                        <div class="product-details">
                                                                            <h2 class="product-title">
                                                                                <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                            </h2>
                                                                            <div class="price-box">
                                                                                <span class="product-price"><?= $product->price ?> Lei</span>
                                                                            </div><!-- End .price-box -->

                                                                            <div class="product-action">
                                                                                <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                                <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adaugă în coș</span>
                                                                                </a>
                                                                                <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                            </div><!-- End .product-action -->
                                                                        </div><!-- End .product-details -->
                                                                    </div><!-- End .product -->
                                                                </div><!-- End .col-md-4 -->
                                                            <?php
                                    } ?>
                                                </div><!-- End .row -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .home-product-tabs -->
                            <?php
                                }
                            }
                        ?>

                       <?php
                            if ($currentSeason == "Winter") {
                                $summer = Database::table('products')->select()->where('season_id', 1)->take(4);
                                if (!empty($summer)) {
                                    ?>
                                <div class="home-product-tabs">
                                        <h2><a href="">Vezi toate anvelopele de VARĂ</a></h2>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                                <div class="row row-sm">

                                                    <?php
                                                        $summer = Database::table('products')->select()->where('season_id', 1)->take(4);
                                    foreach ($summer as $product) {
                                        ?>
                                                                <div class="col-6 col-md-3">
                                                                    <div class="product">
                                                                        <figure class="product-image-container">
                                                                            <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                                <img src="<?= $product->image ?>" alt="product">
                                                                            </a>
                                                                        </figure>
                                                                        <div class="product-details">
                                                                            <h2 class="product-title">
                                                                                <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                            </h2>
                                                                            <div class="price-box">
                                                                                <span class="product-price"><?= $product->price ?> Lei</span>
                                                                            </div><!-- End .price-box -->

                                                                            <div class="product-action">
                                                                                <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                                <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adaugă în coș</span>
                                                                                </a>
                                                                                <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                            </div><!-- End .product-action -->
                                                                        </div><!-- End .product-details -->
                                                                    </div><!-- End .product -->
                                                                </div><!-- End .col-md-4 -->
                                                            <?php
                                    } ?>
                                                </div><!-- End .row -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .home-product-tabs -->
                        <?php
                                }
                            } else {
                                $winter = Database::table('products')->select()->where('season_id', 2)->take(4);
                                if (!empty($winter)) {
                                    ?>
                                <div class="home-product-tabs">        
                                    <h2><a href="">Vezi toate anvelopele de IARNĂ</a></h2>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                            <div class="row row-sm">
                                                <?php
                                                    foreach ($winter as $product) {
                                                        ?>
                                                            <div class="col-6 col-md-3">
                                                                <div class="product">
                                                                    <figure class="product-image-container">
                                                                        <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                            <img src="<?= $product->image ?>" alt="product">
                                                                        </a>
                                                                    </figure>
                                                                    <div class="product-details">
                                                                        <h2 class="product-title">
                                                                            <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                        </h2>
                                                                        <div class="price-box">
                                                                            <span class="product-price"><?= $product->price ?> Lei</span>
                                                                        </div><!-- End .price-box -->

                                                                        <div class="product-action">
                                                                            <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                            <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                <span>Adaugă în coș</span>
                                                                            </a>
                                                                            <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                        </div><!-- End .product-action -->
                                                                    </div><!-- End .product-details -->
                                                                </div><!-- End .product -->
                                                            </div><!-- End .col-md-4 -->
                                                        <?php
                                                    } ?>
                                            </div><!-- End .row -->
                                        </div><!-- End .tab-pane -->
                                    </div><!-- End .tab-content -->
                                </div><!-- End .home-product-tabs -->
                        <?php
                                }
                            }
                                    
                       ?>
                       
                       <?php
                            $allseason = Database::table('products')->select()->where('season_id', 3)->take(4);
                            if (!empty($allseason)) {
                                ?>
                                <div class="home-product-tabs">        
                                    <h2><a href="">Vezi toate anvelopele ALL-SEASON</a></h2>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                            <div class="row row-sm">
                                                <?php
                                                    foreach ($allseason as $product) {
                                                        ?>
                                                            <div class="col-6 col-md-3">
                                                                <div class="product">
                                                                    <figure class="product-image-container">
                                                                        <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                            <img src="<?= $product->image ?>" alt="product">
                                                                        </a>
                                                                    </figure>
                                                                    <div class="product-details">
                                                                        <h2 class="product-title">
                                                                            <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                        </h2>
                                                                        <div class="price-box">
                                                                            <span class="product-price"><?= $product->price ?> Lei</span>
                                                                        </div><!-- End .price-box -->

                                                                        <div class="product-action">
                                                                            <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                            <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                <span>Adaugă în coș</span>
                                                                            </a>
                                                                            <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                        </div><!-- End .product-action -->
                                                                    </div><!-- End .product-details -->
                                                                </div><!-- End .product -->
                                                            </div><!-- End .col-md-4 -->
                                                        <?php
                                                    } ?>
                                            </div><!-- End .row -->
                                        </div><!-- End .tab-pane -->
                                    </div><!-- End .tab-content -->
                                </div><!-- End .home-product-tabs -->
                                <?php
                            }
                        ?>

                    <?php
                            $syron = Database::table('products')->select()->where('category_id', 1)->take(4);
                            if (!empty($syron)) {
                                ?>
                                    <div class="home-product-tabs">
                                        <h2><a href="">Vezi toate anvelopele SYRON</a></h2>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                                <div class="row row-sm">
                                                    <?php
                                                        foreach ($syron as $product) {
                                                            $season = new Season($product->season_id);
                                                           
                                                            $width = new Width($product->width_id);
                                                            $height = new Height($product->height_id);
                                                            $diameter = new Diameter($product->diameter_id);
                                                            $supplier = new Supplier($product->supplier_id); ?>
                                                                <div class="col-6 col-md-3">
                                                                    <div class="product">
                                                                        <figure class="product-image-container">
                                                                            <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                                <img src="<?= $product->image ?>" alt="product">
                                                                            </a>
                                                                        </figure>
                                                                        <div class="product-details">
                                                                            <h2 class="product-title">
                                                                                <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                            </h2>
                                                                            <div class="price-box">
                                                                                <span class="product-price"><?= $product->price ?> Lei</span>
                                                                            </div><!-- End .price-box -->

                                                                            <div class="product-action">
                                                                                <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                                <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adaugă în coș</span>
                                                                                </a>
                                                                                <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                            </div><!-- End .product-action -->
                                                                        </div><!-- End .product-details -->
                                                                    </div><!-- End .product -->
                                                                </div><!-- End .col-md-4 -->
                                                            <?php
                                                        } ?>
                                                </div><!-- End .row -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .home-product-tabs -->
                                <?php
                            }
                        ?>
                        <?php
                            $rebuilt = Database::table('products')->select()->where('category_id', 9)->take(4);
                            
                            if (!empty($rebuilt)) {
                                ?>
                                    <div class="home-product-tabs">
                                        <h2><a href="">Vezi toate anvelopele pentru camioane</a></h2>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                                <div class="row row-sm">
                                                    <?php
                                                        foreach ($rebuilt as $product) {
                                                            ?>
                                                                <div class="col-6 col-md-3">
                                                                    <div class="product">
                                                                        <figure class="product-image-container">
                                                                            <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                                <img src="<?= $product->image ?>" alt="product">
                                                                            </a>
                                                                        </figure>
                                                                        <div class="product-details">
                                                                            <h2 class="product-title">
                                                                                <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                            </h2>
                                                                            <div class="price-box">
                                                                                <span class="product-price"><?= $product->price ?> Lei</span>
                                                                            </div><!-- End .price-box -->

                                                                            <div class="product-action">
                                                                                <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                                <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adaugă în coș</span>
                                                                                </a>
                                                                                <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                            </div><!-- End .product-action -->
                                                                        </div><!-- End .product-details -->
                                                                    </div><!-- End .product -->
                                                                </div><!-- End .col-md-4 -->
                                                            <?php
                                                        } ?>
                                                </div><!-- End .row -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .home-product-tabs -->
                                <?php
                            }
                        ?>
                        
                        <?php
                            $trucks = Database::table('products')->select()->where('category_id', 6)->take(4);
                            
                            if (!empty($trucks)) {
                                ?>
                                    <div class="home-product-tabs">
                                        <h2><a href="">Vezi toate anvelopele pentru camioane</a></h2>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                                <div class="row row-sm">
                                                    <?php
                                                        foreach ($trucks as $product) {
                                                            ?>
                                                                <div class="col-6 col-md-3">
                                                                    <div class="product">
                                                                        <figure class="product-image-container">
                                                                            <a href="/produse?produs=<?= $product->id ?>" class="product-image">
                                                                                <img src="<?= $product->image ?>" alt="product">
                                                                            </a>
                                                                        </figure>
                                                                        <div class="product-details">
                                                                            <h2 class="product-title">
                                                                                <a href="/produse?produs=<?= $product->id ?>"><?= "Anvelope " . $season->season_name[0] . " " . $width->width_name[0] . "/" . $height->height_name[0] . "/" . $diameter->diameter_name[0] . " " . $product->product_name . " " . $supplier->supplier_name[0] . " " . $product->model ?></a>
                                                                            </h2>
                                                                            <div class="price-box">
                                                                                <span class="product-price"><?= $product->price ?> Lei</span>
                                                                            </div><!-- End .price-box -->

                                                                            <div class="product-action">
                                                                                <a class="paction add-wishlist" onclick="addToFavorites(<?= $product->id ?>)"><span>Adaugă la favorite</span></a>
                                                                                <a onclick="addToCart(<?= $product->id ?>)" class="paction add-cart" title="Add to Cart">
                                                                                    <span>Adaugă în coș</span>
                                                                                </a>
                                                                                <a class="paction add-compare" onclick="addToCompare(<?= $product->id ?>)"><span>Adaugă la comparație</span></a>
                                                                            </div><!-- End .product-action -->
                                                                        </div><!-- End .product-details -->
                                                                    </div><!-- End .product -->
                                                                </div><!-- End .col-md-4 -->
                                                            <?php
                                                        } ?>
                                                </div><!-- End .row -->
                                            </div><!-- End .tab-pane -->
                                        </div><!-- End .tab-content -->
                                    </div><!-- End .home-product-tabs -->
                                <?php
                            }
                        ?>
                        
                        
                    </div><!-- End .col-lg-12 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-10"></div><!-- margin -->

            <div class="partners-container">
                <div class="container">
                    <div class="partners-carousel owl-carousel owl-theme">
                        <a class="partner">
                            <img src="images/brands/syron.png" alt="logo">
                        </a>
                        <a class="partner">
                            <img src="images/brands/sava.png" alt="logo">
                        </a>
                        <a class="partner">
                            <img src="images/brands/michelin.png" alt="logo">
                        </a>
                        <a class="partner">
                            <img src="images/brands/fulda.png" alt="logo">
                        </a>
                        <a class="partner">
                            <img src="images/brands/bela.png" alt="logo">
                        </a>
                        <a class="partner">
                            <img src="images/brands/atg.png" alt="logo">
                        </a>
                       
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div><!-- End .partners-container -->
            <div class="mb-10"></div><!-- margin -->

            <div class="container">
                <div class="row">
                    <div class="widget widget-cats col-md-3">
                        <h3 class="widget-title">Produse</h3>
                        <ul class="catAccordion">
                            <li class="open">
                                <a href="category.html">Anvelope</a> 
                                <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-1" aria-expanded="false" aria-controls="accordion-ul-1"></button>

                                <ul class="collapse show" id="accordion-ul-1" style="">
                                    <?php
                                    if ($categories > 0) {
                                        foreach ($categories as $category) {
                                            ?>
                                            <li><a href="<?= $category->id; ?>"><?= $category->name; ?></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                        <ul class="catAccordion">
                            <li class="open">
                                <a href="category.html">Jante</a> 
                                <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-1" aria-expanded="false" aria-controls="accordion-ul-2"></button>
                                <ul class="collapse show" id="accordion-ul-2" style="">
                                    <li><a href="">Jante Aliaj</a></li>    
                                    <li><a href="">Jante Oțel</a></li>  
                                </ul>
                            <li>
                        </ul>
                    </div>
                    <div class="accordion col-md-9">
                        <div class="accordion-tabs">
                            <div class="accordion-tab">
                                <input type="radio" id="rd1" name="rd" checked>
                                <label class="accordion-tab-label" for="rd1">Despre Anvelope</label>
                                <div class="tab-content">
                                Anvelopele reprezintă mai mult decât simple accesorii pentru mașină. Acestea sunt rezultatul unui mix inovativ în care elementul-cheie îl reprezintă performanța. Prin intermediul acestui site poți avea și tu acces la anvelope de calitate, 100% compatibile cu modelul mașinii tale, oferindu-ți toată siguranță de care ai nevoie, indiferent de sezon și de condițiile de drum. Condițiile climatice și starea drumurilor variază in decursul unui an. De aceea, pentru ca plăcerea și siguranța condusului să rămână constante, BELA AUTO oferă o gama extinsă de anvelope pentru fiecare anotimp: anvelope de vară, anvelope de iarnă și anvelope all-season.
                                </div>
                            </div>
                            
                            <div class="accordion-tab">
                                <input type="radio" id="rd2" name="rd">
                                <label class="accordion-tab-label" for="rd2">Jante auto</label>
                                <div class="tab-content">
                                Când vine vorba de jante, nu facem niciun compromis! Găsirea jantelor potrivite mașinii tale, precum și nevoilor sau personalității tale, este o adevărată provocare. Echipa BELA AUTO este pregătită pentru a-ți oferi cele mai bune sfaturi în materie de jante auto. Procesul alegerii unor jante poate fi mai complex decât pare. Nu doar tipul mașinii sau dimensiunea anvelopelor este importantă. Frumusețea stă în detalii, așa că finish-ul acestor jante trebuie și el luat în considerare pentru obținerea unui efect wow. Mate, lucioase, satinate, în diferite nuanțe coloristice sau metalice, toate aceste aspecte duc către personalizarea dorită. Lasă totul în seama noastră! Contactează-ne pentru detalii!
                                </div>
                            </div>

                            <div class="accordion-tab">
                                <input type="radio" id="rd3" name="rd">
                                <label class="accordion-tab-label" for="rd3">Flowey</label>
                                <div class="tab-content">
                                Folosind produsele potrivite pentru întreținerea corectă a mașinii, îi prelungiți considerabil durata de viață, oferindu-i în același timp o cosmetizare eficientă. Aceste produse Flowey pe care BELA AUTO le comercializează susțîn în mod activ toate aceste aspecte deosebit de importante. Prin intermediul nostru, puteți achiziționa următoarele produse Flowey: spuma activă pentru curățarea tapițeriei textile sau din piele, soluții de curățare a motorului și a componenetelor din plastic, produs pentru întreținerea jantelor și a anvelopelor, lavete din microfibră și din piele sintetică, perii de curățare, ceară pentru întreținere, șampon și spray de curățare, soluție degivrantă. Cauți un produs Flowey pe care nu l-ai găsit in lista de mai sus? Contactează-ne!
                                </div>
                            </div>

                            <div class="accordion-tab">
                                <input type="radio" id="rd4" name="rd">
                                <label class="accordion-tab-label" for="rd4">Ulei motor</label>
                                <div class="tab-content">
                                Când spunem ulei motor, vorbim despre o componentă vitală a sistemului oricărei mașini, așa că un ulei de calitate este responsabil direct pentru asigurarea unei vieți lungi și fericite a mașinii tale. Există numeroase opțiuni atunci când vine vorba de alegerea uleiului potrivit pentru motorul mașinii. Pe site-ul nostru veți găși la îndemână informații care să va contureeze opțiunile, astfel încât să va fie mai ușor să-l cumpărați pe cel adecvat necesităților. Asigurându-vă că mașina dumneavoastră folosește uleiul de motor potrivit, defapt asigurați o bună funcționare în privința lubrifierii, răcirii, curățării si protecției componentelor interioare. Nu sunteți siguri de tipul de ulei de motor de care aveți nevoie? Contactați unul dintre membrii
                                </div>
                            </div>
                            <div class="accordion-tab">
                                <input type="radio" id="rd5" name="rd">
                                <label class="accordion-tab-label" for="rd5">Lanturile RUD</label>
                                <div class="tab-content">
                                Drumurile ce prezintă pietriș ascuțit sau drumurile murdare și alunecoase, mai ales în condițiile climatice extreme, reprezintă un pericol major pentru anvelope, chiar și atunci când anvelopele sunt noi. De aceea, BELA AUTO recomandă utilizarea acestor lanțuri RUD, capabile să facă față celor mai agresive condiții. Printre cele mai importante avantaje ale acestor lanțuri RUD se numără reducerea costurilor de operare, reducerea timpilor de întrerupere (ca urmare a eventualelor defecțiuni), creșterea productivității și minimalizarea riscurilor producerii de accidente. Mențineți siguranța condusului și productivitatea activității la cote maxime folosind lanțuri RUD de calitate. Contactează-ne și te vom ajuta să le alegi pe cele potrivite.
                                </div>
                            </div>
                        </div>
                        <img src="images/SEO.png" alt="">
                    </div>
                </div>
            </div>
            <div class="mb-10"></div><!-- margin -->

		</main><!-- End .main -->
	<?php include('./templates/footer/footer.php'); ?>
		
</div>
<?php
    if (isset($_SESSION['success-order'])) {
        ?>
        <script>
            const readyStateCheckInterval = setInterval(function() {
                if (document.readyState === "complete") {
                    clearInterval(readyStateCheckInterval);
                    successOrder("<?= $_SESSION['success-order'] ?>");
                    
                }
            }, 10);
        </script>
        <?php
        unset($_SESSION['success-order']);
    } if (isset($_SESSION['success-register'])) {
        ?>
        <script>
            const readyStateCheckInterval = setInterval(function() {
                if (document.readyState === "complete") {
                    clearInterval(readyStateCheckInterval);
                    successRegister("<?= $_SESSION['success-register'] ?>");
                }
            }, 10);
        </script>
        <?php
        unset($_SESSION['success-register']);
    }
?>
<?php include('./templates/success-message/success-message.php'); ?>
<?php include('./templates/mobile-menu/mobile-menu.php'); ?>



<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>