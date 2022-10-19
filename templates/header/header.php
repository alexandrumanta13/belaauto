<?php
$user = new User();
try {
    $logged_in = $user->loggedIn();
} catch (Exception $e) {
    echo $e->getMessage();
    $logged_in = false;
}

$config['menu'] = array(
    'Acasă' => '/',
    'Anvelope' => '/anvelope',
    'Jante' => '/jante',
    
    'Lanțuri RUD' => '/lanturi-rud',
    'Lubrifianți' => '/lubrifianti',
    'Accesorii' => array(
        'Flowey' => 'https://www.flowey.com/',
        'Generator de Ozon Trioxy' => '/generator-de-ozon-trioxy',
    ),
    
    'Despre noi' => '/despre-noi',
    'Contact' => '/contact',
);
?>
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left header-dropdowns">
            <div class="header-dropdown dropdown-expanded">
                    <div class="header-menu">
                        <ul>
                            <li class="dropdown compare-dropdown">
                                <a href="/compara"  class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <i class="icon-compare"></i> 
                                    Compară <span class="compare-count">(2)</span>
                                </a>
                                <div class="dropdown-menu get-compare-items compare-products">
                                    <div class="dropdownmenu-wrapper">
                                        <ul class="compare-products">
                                            <li class="product">
                                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                                <h4 class="product-title"><a href="product.html">Lady White Top</a></h4>
                                            </li>
                                            
                                        </ul>

                                        <div class="compare-actions">
                                            <a href="#" class="action-link">Goleste</a>
                                            <a href="#" class="btn btn-primary">Vezi lista</a>
                                        </div>
                                    </div><!-- End .dropdownmenu-wrapper -->
                                </div><!-- End .dropdown-menu -->
                                    
                            </li>
                            
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <?php
                if ($logged_in) {
                    ?>
                    <p class="welcome-msg">Bun venit, <?= $user->name . ' ' . $user->last_name ?>! </p>
                    <?php
                }
                ?>
                <div class="header-dropdown dropdown-expanded">
                    <div class="header-menu">
                        <ul>
                            <li class="dropdown favorites-dropdown">
                                <a href="/favorite"  class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <i class="icon-wishlist"></i> 
                                    Favorite <span class="favorites-count">(2)</span>
                                </a>
                                <div class="dropdown-menu get-favorites-items favorites-products">
                                    <div class="dropdownmenu-wrapper">
                                        <ul class="favorites-products">
                                            <li class="product">
                                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                                <h4 class="product-title"><a href="product.html">Lady White Top</a></h4>
                                            </li>
                                            
                                        </ul>

                                        <div class="favorites-actions">
                                            <a href="#" class="action-link">Goleste</a>
                                            <a href="#" class="btn btn-primary">Vezi lista</a>
                                        </div>
                                    </div><!-- End .dropdownmenu-wrapper -->
                                </div><!-- End .dropdown-menu -->
                                    
                            </li>
                            <?php
                                if (!$logged_in) {
                                    ?>
                                    
                                    <li><a href="#" class="login-link"><i class="icon-lock"></i> <span>Autentificare</span></a></li>
                                   
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="/contul-meu"><i class="icon-user"></i> <span>Contul meu</span> </a></li>
                                    <li><a href="/delogare"><span class="logout">Delogare</span> <i class="icon-right"></i> </a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="/" class="logo">
                    <img src="images/bealaautoLogo.png" alt="Porto Logo">
                </a>
            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                    <form action="/anvelope" method="get">
                        <div class="header-search-wrapper">
                            <input type="search" class="form-control" name="cauta" id="cauta" placeholder="Spre exemplu 205/55 R16..." required>
                            <div class="select-custom">
                                <select id="categorie" name="categorie">

                                    <option selected value="-1">Toate categoriile</option>
                                    <optgroup label="Anvelope">
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
                                    </optgroup>
                                </select>
                            </div><!-- End .select-custom -->
                            <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div><!-- End .headeer-center -->

            <div class="header-right">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>
                <div class="header-contact">
                    <span>Ne poți contacta la numărul:</span>
                    <a href="tel:+40741.157.515"><strong>(0741) 157 515</strong></a>
                </div><!-- End .header-contact -->

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="cart-count"></span>
                    </a>
                    <div class="dropdown-menu get-cart-items">
                       
                    </div><!-- End .dropdown-menu -->
                    
                </div><!-- End .dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
    <div class="header-bottom sticky-header">
        <div class="container">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <?php
                    
                        if ('/' . $_GET['p'] == '/index') {
                            $url = '/';
                        } else {
                            $url = '/' . $_GET['p'];
                        }
                       
                        foreach ($config['menu'] as $k => $v) {
                            ?>
                            <li class="<?= ($url == $v ? 'active' : '')?>">
                               
                                
                                <?php
                                    // foreach($k as $w => $y) {
                                    //     print_r($w);
                                    // }
                                    
                                    if ($k == 'Accesorii') {
                                        ?>
                                        <a href="">Accesorii</a>
                                       

                                        <ul class="collapse" id="accordion-ul-2">
                                            <?php
                                                foreach ($config['menu']['Accesorii'] as $sublink => $link) {
                                                    ?>
                                                        <li>
                                                            <?php
                                                                if ($sublink == 'Flowey') {
                                                                    ?>
                                                                        <a target="_blank" href="<?= $link ?>"><?= $sublink ?></a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a href="<?= $link ?>"><?= $sublink ?></a>
                                                                    <?php
                                                                } ?>
                                                            
                                                        </li>
                                                    <?php
                                                } ?>
                                        </ul>
                                        <?php
                                    } else {
                                        ?>
                                            <a href="<?= $v ?>"><?= $k ?></a>
                                        <?php
                                    } ?>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </nav>
        </div><!-- End .header-bottom -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->