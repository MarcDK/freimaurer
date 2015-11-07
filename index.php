<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>freimaurer Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- needed for mobile devices -->
    <link rel="stylesheet" href="/freimaurer/css/freimaurer.css"/>

    <!-- jquery  -->
    <script type="text/javascript" src='/freimaurer/js/jquery.min.js'></script>

    <!-- unveil  -->
    <script type="text/javascript" src='/freimaurer/js/jquery.unveil.min.js'></script>

    <!-- isotope  -->
    <script type="text/javascript" src='/freimaurer/js/isotope.pkgd.min.js'></script>

    <!-- photoswipe -->
    <script type="text/javascript" src='/freimaurer/js/photoswipe/photoswipe.min.js'></script>
    <script type="text/javascript" src='/freimaurer/js/photoswipe/photoswipe-ui-default.min.js'></script>
    <link rel="stylesheet" href="/freimaurer/js/photoswipe/default-skin/default-skin.css"/>
    <link rel="stylesheet" href="/freimaurer/js/photoswipe/photoswipe.css"/>

    <!-- freimaurer -->
    <script type="text/javascript" src='/freimaurer/freimaurer-init.js'></script>

</head>
<body>

<div id="header">
    <a href="/">
        <h1>Freimaurer Demo</h1>
    </a>
</div>


<?php
include('freimaurer/freimaurer.php');

$maurer = new Freimaurer();
echo $maurer->getGalleryNav();
echo $maurer->getGallery();
?>

<noscript>
    please enable javascript in your browser.
</noscript>

<?php echo $maurer->getPhotoSwipeHTML(); ?>
</body>
</html>