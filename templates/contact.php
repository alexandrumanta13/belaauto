<?php 

title( 'BelaAuto &#8211; tyres and more'); meta( '');
?>

<div class="page-wrapper">
    <?php include('./templates/header/header.php'); ?>

    <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Acasa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </div><!-- End .container -->
                
            </nav>
           
            <div class="container">
                <div id="map"></div><!-- End #map -->

                <div class="row">
                    <div class="col-md-8">
                        

                        <form action="#">
                            <div class="form-group required-field">
                                <label for="contact-name">Nume</label>
                                <input type="text" class="form-control" id="contact-name" name="contact-name" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label for="contact-email">Email</label>
                                <input type="email" class="form-control" id="contact-email" name="contact-email" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label for="contact-phone">Telefon</label>
                                <input type="tel" class="form-control" id="contact-phone" name="contact-phone">
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label for="contact-message">Cu ce te putem ajuta?</label>
                                <textarea cols="30" rows="1" id="contact-message" class="form-control" name="contact-message" required></textarea>
                            </div><!-- End .form-group -->

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Trimite</button>
                            </div><!-- End .form-footer -->
                        </form>
                    </div><!-- End .col-md-8 -->

                    <div class="col-md-4">
                       

                        <div class="contact-info">
                            <div>
                                <i class="icon-phone"></i>
                                <p><a href="tel:">0201 203 2032</a></p>
                                <p><a href="tel:">0201 203 2032</a></p>
                            </div>
                            <div>
                                <i class="icon-mobile"></i>
                                <p><a href="tel:">(0723) 321 321</a></p>
                                <p><a href="tel:">(0723) 321 321</a></p>
                            </div>
                            <div>
                                <i class="icon-mail-alt"></i>
                                <p><a href="mailto:#">office@belaauto.ro</a></p>
                                <p><a href="mailto:#">info@belaauto.ro</a></p>
                            </div>
                            <div>
                                <i class="icon-skype"></i>
                                <p>contact_belaauto</p>
                                <p>info_belaauto</p>
                            </div>
                        </div><!-- End .contact-info -->
                    </div><!-- End .col-md-4 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-8"></div><!-- margin -->
        </main><!-- End .main -->

    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>
<?php include('./templates/success-message/success-message.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>