<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>freimaurer Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- needed for mobile devices -->
    <link rel="stylesheet" href="freimaurer/css/freimaurer.css"/>

    <!-- jquery  -->
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js'></script>

    <!-- unveil  -->
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/unveil/1.3.0/jquery.unveil.min.js'></script>

    <!-- isotope  -->
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js'></script>

    <!-- photoswipe -->
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.0/photoswipe.min.js'></script>
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.0/photoswipe-ui-default.min.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.0/default-skin/default-skin.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.0/photoswipe.css"/>

    <!-- responsive nav -->
    <script type="text/javascript" src='https://cdn.jsdelivr.net/responsive-nav/1.0.39/responsive-nav.min.js'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/responsive-nav/1.0.39/responsive-nav.css"/>

    <!-- freimaurer -->
    <script type="text/javascript" src='freimaurer/freimaurer-init.js'></script>

</head>
<body>

<div id="header">
    <h1><a href="/">Freimaurer Demo</a></h1>
</div>

<!--- Freimaurer ---->

<?php
include('freimaurer/freimaurer.php');
$maurer = new Freimaurer();
?>

<?php echo $maurer->getGalleryNav(); ?>

<?php echo $maurer->getGallery(); ?>

<!--- /Freimaurer ---->

<noscript>
    please enable javascript in your browser.
</noscript>


<section>
    <article>
        <h2>About Freimaurer</h2>

        <p>A responsive onepage gallery based on <strong>php</strong> and <strong>javascript</strong>.</p>

        <p>Just upload your image folders and the navigation and thumbnails are generated automattically. </p>
    </article>
    <article>
        <h2>Installation</h2>

        <p></p>
        <ol>
            <li>Place your image folders into the folder <em>/gallery/</em>.</li>
            <li>Customize index.php to your needs.</li>
            <li>Upload all files to your webserver.</li>
            <li>Make the folder <em>/freimaurer/cache</em> writeable.</li>
        </ol>
    </article>
    <article>
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
    <article>
        <h2>Download</h2>

        <p>Download Freimaurer at <a href="https://github.com/MarcDK/freimaurer">github</a>.</p>
    </article>
    <article>
        <h2>License</h2>

        <p>Freimaurer is licensed under the <a href="http://opensource.org/licenses/MIT">MIT license</a></p>
    </article>
</section>


<!--- Freimaurer PhotoSwipe HTML ---->
<?php echo $maurer->getPhotoSwipeHTML(); ?>
</body>
</html>