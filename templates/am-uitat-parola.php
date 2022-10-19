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
                    <li class="breadcrumb-item active" aria-current="page">Am uitat parola</li>
                </ol>
            </div><!-- End .container -->

        </nav>

        <div class="container">
            <?php

                if(isset($_GET['token'])) {
                    ?>
                    <div class="heading mb-4">
                        <h2 class="title">Reseteaza parola</h2>
                    </div><!-- End .heading -->

                  
                    <?php
                } else {
            ?>

                <div class="heading mb-4">
                    <h2 class="title">Reseteaza parola</h2>
                    <p>Vei primi pe email indicatii pentru schimbarea parolei</p>
                </div><!-- End .heading -->

                <div>
                    <div class="form-group required-field">
                        <label for="reset-email">Email</label>
                        <input type="email" class="form-control" id="reset-email" name="reset-email" required>
                    </div><!-- End .form-group -->

                    <div class="form-footer">
                        <button onclick="sendForgot(document.querySelector('#reset-email').value)"  class="btn btn-primary">Reseteaza parola</button>
                    </div><!-- End .form-footer -->
                </div>
            <?php 
                }
            ?>
        </div>
        <div class="mb-10"></div>
    </main>
    <?php include('./templates/footer/footer.php'); ?>
</div>

<?php include('./templates/mobile-menu/mobile-menu.php'); ?>
<?php include('./templates/success-message/success-message.php'); ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>