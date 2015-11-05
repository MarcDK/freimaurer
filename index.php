<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>kunstpixel.de</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- needed for mobile devices -->
    <link rel="stylesheet" href="/freimaurer/css/kunstpixel.css"/>

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

</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-61113918-1', 'auto');
    ga('send', 'pageview');
    ga('set', 'anonymizeIp', true);
</script>
<div id="header"><a href="/"><h1>Kunstpixel.de</h1></a></div>


<!-- freimaurer -->
<script type="text/javascript" src='/freimaurer/freimaurer-init.js'></script>

<?php include('freimaurer/reader.php'); ?>

<p class="grid">
<noscript>
    please enable javascript in your browser.
</noscript>
</p>

<div id="footer">
    <p><a href="http://kunstpixel.de">kunstpixel.de</a> is a project by <a href="http://marc.tv">Marc.TV</a>.</p>

    <p>A collection of my PlayStation 4 screenshots. No press bullshots. Only captured on hardware.</p>

    <p>Visit my other projects: <br> <a href="http://shortscore.org">SHORTSCORE.org</a>
        and <a href="http://verschlichtern.de">verschlichtern.de</a></p>

    <p>Impressum: Herausgeber und verantwortlich im Sinne von § 55 Absatz 1 RStV/§ 5 TMG: Marc Tönsing Im Gehölz 5 20255
        Hamburg </p>

    <p>E-Mail: <a href="mailto:marc@kunstpixel.de">marc@kunstpixel.de</a></p>
    <p>Kunstpixel is powered by <a href="https://github.com/MarcDK/freimaurer">freimaurer</a>. A simple php and js image gallery mash-up.</p>
</div>



<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>

</body>
</html>