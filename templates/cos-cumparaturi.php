<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-1">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cos cumparaturi</li>
                </ol>
            </div><!-- End .container -->
        </nav>
       
        <div class="container">
            <div class="row">
    
                <div class="col-lg-8 ">
                    

                    <div class="cart-table-container">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="product-col">Produs</th>
                                    <th class="price-col">Pret</th>
                                    <th class="qty-col">Cnt</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                               
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="clearfix">
                                        <div class="float-left">
                                            <a href="/anvelope" class="btn btn-outline-secondary">Continua cumparaturile</a>
                                        </div><!-- End .float-left -->
                                        <div class="float-right">
                                      
                                            <button onclick="removeCart()" class="btn btn-outline-secondary btn-clear-cart">Goleste cos</button>
                                    
                                        </div><!-- End .float-right -->
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- End .cart-table-container -->

                    
                    
                </div><!-- End .col-lg-8 -->

                <div class="col-lg-4 cart-summary-container">
                    <div class="cart-summary">
                        <h3>Sumar</h3>


                        <table class="table table-totals">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="summary-subtotal"></td>
                                </tr>

                                <tr>
                                    <td>Transport</td>
                                    <td class="summary-transport" data-price="0">-</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td class="summary-total"></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="checkout-methods">
                            <a href="/finalizare-comanda" class="btn btn-block btn-sm btn-primary">Finalizeaza comanda</a>
                        </div><!-- End .checkout-methods -->
                    </div><!-- End .cart-summary -->
                </div><!-- End .col-lg-4 -->

               
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-6"></div><!-- margin -->
    </main><!-- End .main -->
    
    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
