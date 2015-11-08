<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>freimaurer Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- needed for mobile devices -->
    <link rel="stylesheet" href="freimaurer/css/freimaurer.css"/>

    <!-- jquery  -->
    <script type="text/javascript" src='freimaurer/js/jquery.min.js'></script>

    <!-- unveil  -->
    <script type="text/javascript" src='freimaurer/js/jquery.unveil.min.js'></script>

    <!-- isotope  -->
    <script type="text/javascript" src='freimaurer/js/isotope.pkgd.min.js'></script>

    <!-- photoswipe -->
    <script type="text/javascript" src='freimaurer/js/photoswipe/photoswipe.min.js'></script>
    <script type="text/javascript" src='freimaurer/js/photoswipe/photoswipe-ui-default.min.js'></script>
    <link rel="stylesheet" href="freimaurer/js/photoswipe/default-skin/default-skin.css"/>
    <link rel="stylesheet" href="freimaurer/js/photoswipe/photoswipe.css"/>

    <!-- responsive nav -->
    <script type="text/javascript" src='freimaurer/js/responsive-nav/responsive-nav.js'></script>
    <link rel="stylesheet" href="freimaurer/js/responsive-nav/responsive-nav.css"/>
    <link rel="stylesheet" href="freimaurer/css/responsive-nav-theme.css"/>


    <!-- freimaurer -->
    <script type="text/javascript" src='freimaurer/freimaurer-init.js'></script>

</head>
<body>

<div id="header">
    <h1><a href="/">Freimaurer Demo</a></h1>
</div>

<?php
include('freimaurer/freimaurer.php');
$maurer = new Freimaurer();
?>

<?php echo $maurer->getGalleryNav(); ?>

<?php echo $maurer->getGallery(); ?>


<noscript>
    please enable javascript in your browser.
</noscript>


<section>
    <article class="about">
        <h2>About Freimaurer</h2>

        <p>A responsive onepage gallery based on <strong>php</strong> and <strong>javascript</strong>.</p>

        <p>Just upload your image folders and the navigation and thumbnails are generated automattically. </p>
    </article>
    <article class="installation">
        <h2>Installation</h2>

        <p></p>
        <ol>
            <li>Make the folder <em>/freimaurer/cache</em> writeable.</li>
            <li>Place your image folders into the folder <em>/gallery/</em></li>
            <li>All files.</li>
        </ol>
    </article>
    <article class="credits">
        <h2>credits</h2>

        <p>Freimaurer is based on following scripts:</p>
        <ul>
            <li><a href="http://isotope.metafizzy.co/">isotope</a> - dynamic grid</li>
            <li><a href="http://photoswipe.com/">photoswipe</a> - lightbox gallery</li>
            <li><a href="http://luis-almeida.github.io/unveil/">unveil</a> - image lazy loading</li>
            <li><a href="http://github.com/jamiebicknell/Thumb">Thumb</a> - thumbnail generation</li>
            <li><a href="http://responsive-nav.com">responsive nav</a> - the hamburger menu</li>
        </ul>

        <p>demo photo credits: copyright by <a href="http://marc.tv">Marc Tönsing</a>.</p>
    </article>
    <article class="download">
        <h2>Download</h2>

        <p>Download Freimaurer at <a href="https://github.com/MarcDK/freimaurer">github</a>.</p>
    </article>
    <article class="license">
        <h2>License</h2>

        <p>Freimaurer is licensed under the <a href="http://opensource.org/licenses/MIT">MIT license</a></p>
    </article>
</section>


<?php echo $maurer->getPhotoSwipeHTML(); ?>
</body>
</html>