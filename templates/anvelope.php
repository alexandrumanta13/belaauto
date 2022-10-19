<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
    $sort = 12;
    $order = "ASC";

    $products = Product::Paginate("id", $order, $sort);
 
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
                <div class="col-lg-9">
                <?php
                    if(count($_GET) <= 1) {
                ?>
                    <h1 class="seo">Anvelopele potrivite ofera siguranta si protectie maxima in orice conditii</h1>
                    <p>Sunt singurul punct de contact cu carosabilul, te-ai gandit vreodata din aceasta perspectiva?
                        Alegand anvelope de calitate, vei genera performanta si fiabilitate maxima in timpul sofatului.
                    </p>
                <?php
                    }
                    
                ?>
<!-- 
                    <nav class="toolbox"> 
                   <div class="toolbox-left">
                            <div class="toolbox-item toolbox-sort">
                                <div class="select-custom">
                                    <select name="orderby" class="form-control">
                                        <option value="menu_order" selected="selected">Default sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by newness</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                </div>

                                <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>
                            </div>
                        </div>  -->

                    <!-- <div class="toolbox-item toolbox-show">
                            <label><?= Product::SummaryLinks(); ?></label>
                        </div>

                        <div class="layout-modes">
                            <a href="category.html" class="layout-btn btn-grid active" title="Grid">
                                <i class="icon-mode-grid"></i>
                            </a>
                            <a href="category-list.html" class="layout-btn btn-list" title="List">
                                <i class="icon-mode-list"></i>
                            </a>
                        </div> -->
                    <!-- </nav> -->

                    <div class="row row-sm" id="product-list">
                        <?php
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
                          
                        }
                        ?>
                    </div><!-- End .row -->
                    <nav class="toolbox toolbox-pagination">
                        <!-- <div class="toolbox-item toolbox-show">
							<label class="total-pages" data-total="">Rezultate 12-42 din 4 pagini</label>
						</div> -->

                        <div id="pagination"></div>
                    </nav>
                    <?php
                        if(count($_GET) <= 1) {
                    ?>
                        <h2 class="seo">Sofeaza in siguranta cu anveope adecvate, indiferent de sezon!</h2>
                        <p>
                            Fiind permanent in contact cu carosabilul, anvelopele sunt o parte foarte importanta a oricarui
                            automobil. De aceea, pentru a asigura protectie optima si fiabilitate in timpul condusului,
                            fiecare sofer ar trebui sa respecte termenul de inlocuire a acestor anvelope, in functe de sezon
                            si tinand cont de gradul de uzura pe care acestea il prezinta.</p>
                        <p>
                            <strong>Bela Auto</strong> comercializeaza tot ce ai nevoie in materie de anvelope – anvelope
                            iarna, anevelope vara, anvelope 4X4, anvelope all-seasons, chiar si cauciucuri pentru masini
                            utilizate in
                            agricultura sau in diferitele industrii, constructii, manevrarea marfurilor in depozite –
                            anvelope camioane, anvelope industruale, anvelope agricole, anvelope stivuitor. Datorita
                            parteneriatelor cu branduri de renume in aceasta industrie, livram de fiecare data aceeasi
                            calitate, pentru ca tu sa te bucuri intotdeauna de o experienta placuta atunci cand conduci!</p>
                        <h2 class="seo">Iarna sau vara – te echipam cu anvelope corespunzatoare!</h2>
                        <p>Fiabilitatea anvelopelor alese se regaseste in detaliile si finisajele de exceptie pe care doar
                        o companie producatoare de renume le poate oferi pentru fiecare produs comercializat. Cu
                        echilibru intre design si tehnologie, anvelopele de calitate impartasesc aceste valori comune:
                        inovatie, aderenta, rezistenta si siguranta, oricare ar fi conditiile de drum sau cele meteo.</p>
                        <p>Iarna sau vara, tine de responsabilitatea ta sa acorzi importanta selectarii anvelopelor,
                        conform specificatiilor tehnice ale masinii pe care o detii: dimensiunile, nevoile si maniera
                        sofatului.</p>
                        <h2 class="seo">Pentru ca masina ta merita anvelope de calitate!</h2>
                        <p>Te sustine pentru a-ti desfasura nestingherit activitatile zilnice, fie ca este vorba despre
                        drumurile zilnice – mers la serviciu, condus copiii la gradinita sau scoala, plimbari prin oras
                        si cumparaturile saptamanale, sau despre drumurile lungi si solicitante – excursii, poate un
                        city-break sau, de ce nu, vacante lungi in tara sau strainatate. Astfel, conditia generala a
                        masinii reprezinta responsabilitatea ta, pentru a-i prelungi durata de utilizare in maxima
                        siguranta pentru tine si cei dragi.</p>
                        <p><strong>Bela Auto</strong> comercializeaza anvelope pentru autoturismul pe care il conduci, oferindu-ti asistenta
                        in alegerea lor in concordanta cu modelul masinii. Astfel, performanta si randamentul in timpul
                        sofatului vor creste considerabil. Selectate corect, anvelopele contribuie si la un consum optim
                        redus de carburant, insemnand economie si calatorii fara griji.</p>
                        <p></p>Preturile avantajoase reprezinta inca un punct forte al produselor listate in catalogul online
                        <strong>Bela Auto</strong> – vei ramane uimit de disponibilitatea cauciucurilor fiabile pentru un pret
                        convenabil, in raport cu beneficiile oferite.
                        Incepe cu anvelope de calitate si continua cu un ulei de motor pe masura, pentru mentinerea in
                        stare perfecta a componentelor si pana la accesoriile si cosmeticele utilizate.</p>
                        <h3 class="seo">Masina ta iti va multumi si te va recompensa cu siguranta un timp indelungat!</h3>
                    <?php
                        }
                    ?>

                </div><!-- End .col-lg-9 -->

                <aside class="sidebar-shop col-lg-3 order-lg-first">
                    <div class="sidebar-wrapper">
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                                    aria-controls="widget-body-2">Anvelope</a>
                            </h3>

                            <div class="collapse show" id="widget-body-2">
                                <div class="widget-body">
                                    <ul class="cat-list">
                                        <?php
                                            $category = new Subcategory();                  
                                            $categories = $category->getSubcategories();
                                            
                                            if($categories > 0) {
                                                foreach ($categories as $category) {
                                                    ?>
                                        <li data-id="<?= $category->id ?>"><a
                                                href="/anvelope?categorie=<?= $category->id; ?>"><?= $category->name; ?></a>
                                        </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        <form method="GET" id="filter-group-submit">
                            <div class="form-group">
                                <label for="latime">Latime</label>
                                <div class="select-custom">
                                    <select name="latime" class="form-control" id="latime">
                                        <option value="-1" selected="selected">Orice latime</option>

                                        <?php
                                            $width = new Width();                  
                                            $widths = $width->getWidths();
                                            
                                            if($widths > 0) {
                                                foreach ($widths as $width) {

                                                    if(isset($_GET['latime']) && $width->id == $_GET['latime']) {

                                                    ?>
                                        <option value="<?= $width->id; ?>" selected><?= $width->width_name; ?></option>
                                        <?php
                                                }

                                                else {  ?>
                                                    <option value="<?= $width->id; ?>"><?= $width->width_name; ?></option>
                                                <?php
                                                }
                                            }
                                            }
                                        ?>
                                    </select>
                                </div><!-- End .select-custom -->
                            </div>

                            <div class="form-group">
                                <label for="inaltime">Inaltime</label>
                                <div class="select-custom">
                                    <select name="inaltime" class="form-control" id="inaltime">
                                        <option value="-1" selected="selected">Orice inaltime</option>

                                        <?php
                                            $height = new Height();                  
                                            $heights = $height->getHeights();
                                            
                                            if($heights > 0) {
                                                foreach ($heights as $height) {

                                                    if(isset($_GET['inaltime']) && $height->id == $_GET['inaltime']) {
                                                    ?>
                                        <option value="<?= $height->id; ?>" selected><?= $height->height_name; ?></option>
                                        <?php
                                                }

                                                else { ?>
                                                    <option value="<?= $height->id; ?>"><?= $height->height_name; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                        ?>
                                    </select>
                                </div><!-- End .select-custom -->
                            </div>

                            <div class="form-group">
                                <label for="diametru">Diametru</label>
                                <div class="select-custom">
                                    <select name="diametru" class="form-control" id="diametru">
                                        <option value="-1" selected="selected">Orice diametru</option>

                                        <?php
                                            $diameter = new Diameter();                  
                                            $diameters = $diameter->getDiameters();
                                            
                                            if($diameters > 0) {
                                                foreach ($diameters as $diameter) {

                                                    if(isset($_GET['diametru']) && $diameter->id == $_GET['diametru']) {
                                                    ?>
                                        <option value="<?= $diameter->id; ?>" selected><?= $diameter->diameter_name; ?></option>
                                        <?php
                                                }

                                                else { ?>
                                                    <option value="<?= $diameter->id; ?>"><?= $diameter->diameter_name; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                        ?>
                                    </select>
                                </div><!-- End .select-custom -->
                            </div>

                            <div class="form-group">
                                <label for="producator">Producator</label>
                                <div class="select-custom">
                                    <select name="producator" class="form-control" id="producator">
                                        <option value="-1" selected="selected">Orice producator</option>

                                        <?php
                                            $supplier = new Supplier();                  
                                            $suppliers = $supplier->getSuppliers();
                                            
                                            if($suppliers > 0) {
                                                foreach ($suppliers as $supplier) {

                                                    if(isset($_GET['producator']) && $supplier->id == $_GET['producator']) {
                                                    ?>
                                        <option value="<?= $supplier->id; ?>" selected><?= $supplier->supplier_name; ?></option>
                                        <?php
                                                }

                                                else { ?>
                                                    <option value="<?= $supplier->id; ?>"><?= $supplier->supplier_name; ?></option>
                                                <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div><!-- End .select-custom -->
                            </div>

                            <div class="widget">
                                <div class="form-group">
                                    <label for="sezon">Sezon</label>
                                    <div class="select-custom">
                                        <select name="sezon" class="form-control" id="sezon">
                                            <option value="-1" selected="selected">Orice sezon</option>

                                            <?php
                                                $season = new Season();                  
                                                $seasons = $season->getSeasons();
                                                
                                                if($seasons > 0) {
                                                    foreach ($seasons as $season) {

                                                        if(isset($_GET['sezon']) && $season->id == $_GET['sezon']) {
                                                        ?>
                                            <option value="<?= $season->id; ?>" selected><?= $season->season_name; ?></option>
                                            <?php
                                                    }
                                                    else { ?>
                                                        <option value="<?= $season->id; ?>"><?= $season->season_name; ?></option>

                                                <?php
                                                }
                                            }
                                        }
                                            ?>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true"
                                        aria-controls="widget-body-3">Pret</a>
                                </h3>

                                <div class="collapse show" id="widget-body-3">
                                    <div class="widget-body">

                                        <div class="price-slider-wrapper">
                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .price-slider-wrapper -->

                                        <div class="filter-price-action">
                                            <button type="submit" class="btn btn-primary" id="filter-price-submit">Filtreaza</button>

                                            <div class="filter-price-text">
                                                Pret:
                                                <span id="filter-price-range"></span>
                                                <?php
                                                        $max_price = Database::table("products")->select()->order("price", "DESC")->first();
                                                    ?>
                                                <input type="hidden" name="pret" id="pret"
                                                    value="<?= $max_price->price ?>">
                                            </div><!-- End .filter-price-text -->
                                        </div><!-- End .filter-price-action -->

                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </form>

                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->

    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>
<?php include('./templates/success-message/success-message.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
<script src="../api/v1/products/pagination.js"></script>