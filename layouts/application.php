<!DOCTYPE html>
<html lang="en">
<head>
    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="2bcfab6e-b451-451b-ad03-411db81e78cb" data-blockingmode="auto" type="text/javascript"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2BVXLK');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bela Auto</title>
    <base href="<?php //echo $config['base_url']; ?>">


    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Bela Auto">
    <meta name="author" content="SW-THEMES">

    <meta name="robots" content="noindex">
        
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/icons/favicon.ico">
    
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- AutoComplete CSS File -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/css/autoComplete.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2BVXLK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 
<?php y_ield(); ?>

<!-- Plugins JS File -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/plugins.min.js"></script>
<script src="js/nouislider.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc3LRykbLB-y8MuomRUIY0qH5S6xgBLX4"></script>
<script src="js/map.js"></script>

<!-- Main JS File -->
<script src="js/main.js"></script>
<script src="../api/v1/cart/add.js"></script>
<script src="../api/v1/cart/get.js"></script>
<script src="../api/v1/cart/delete.js"></script>
<script src="../api/v1/cart/update.js"></script>
<script src="../api/v1/products/get.js"></script>
<script src="../api/v1/favorites/add.js"></script>
<script src="../api/v1/favorites/get.js"></script>
<script src="../api/v1/favorites/delete.js"></script>
<script src="../api/v1/compare/add.js"></script>
<script src="../api/v1/compare/get.js"></script>
<script src="../api/v1/compare/delete.js"></script>
<script src="../api/v1/forgot/send.js"></script>


<script src="../api/v1/user/login.js"></script>
<script src="../api/v1/user/register.js"></script>
<script src="../api/v1/messages/success-cart.js"></script>
<script src="../api/v1/messages/success-order.js"></script>
<script src="../api/v1/messages/success-favorites.js"></script>
<script src="../api/v1/messages/success-compare.js"></script>
<script src="../api/v1/messages/limit-compare.js"></script>
<script src="../api/v1/messages/success-register.js"></script>
<script src="../api/v1/messages/success-forgot.js"></script>
<script src="../api/v1/messages/functions.js"></script>



<?php if ($config['google_analytics_web_property_id'] != ''): ?>
  <script>
    var _gaq=[['_setAccount','<?php echo $config['google_analytics_web_property_id']; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
   
  <?php endif; ?>
  
</body>
</html>
