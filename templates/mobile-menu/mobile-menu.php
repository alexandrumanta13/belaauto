

<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu">
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
        </nav><!-- End .mobile-nav -->

        <!-- <div class="social-icons">
            <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
            <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
        </div> -->
        <!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->