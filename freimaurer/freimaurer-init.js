/*
 freimaurer 1.0

 author: Marc Tönsing
 website marc.tv/freimaurer

 a mobile, responsive image gallery build with

 isotope         http://isotope.metafizzy.co/
 photoswipe      http://photoswipe.com/
 unveil          http://luis-almeida.github.io/unveil/
 thumb.php       http://github.com/jamiebicknell/Thumb

 */


// filter functions
var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function () {
        var number = $(this).find('.number').text();
        return parseInt(number, 10) > 50;
    },
    // show if name ends with -ium
    ium: function () {
        var name = $(this).find('.name').text();
        return name.match(/ium$/);
    }
};

function getItems() {
    var pic_objs = [];

    $.each($(".grid img:visible"), function (key, img) {

        $(img).parent().attr('data-index', key);


        var href = $(img).parent().attr('href'),
            size = $(img).parent().data('size').split('x'),
            title = $(img).parent().attr("title"),
            width = size[0],
            height = size[1],
            img_src = $(img).attr("src"),
            img_el = $(img);

        var pic_obj = {
            src: href,
            title: title,
            w: width,
            h: height,
            msrc: img_src,
            el: img_el
        }

        pic_objs.push(pic_obj);
    });

    return pic_objs;
}

function openGallery(elem) {

    var pswpElement = document.querySelectorAll('.pswp')[0];

    var items = getItems();

    var index = $(elem).data("index");

    var options = {
        index: parseInt(index),
        getThumbBoundsFn: function (index) {
            var thumbnail = items[index].el[0],
                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                rect = thumbnail.getBoundingClientRect();

            return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
        }
    };


    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
}

$(function () {

    function getHashFilter() {
        // get filter=filterName
        var matches = location.hash.match(/c=([^&]+)/i);
        var hashFilter = matches && matches[1];
        return hashFilter && decodeURIComponent(hashFilter);
    }

    var $grid = $('.grid');

    // bind filter button click
    var $filterButtonGroup = $('.filter-button-group');
    $filterButtonGroup.on('click', 'button', function () {
        var filterAttr = $(this).attr('data-filter');
        // set filter in hash
        location.hash = 'c=' + encodeURIComponent(filterAttr);
    });

    var colWidth = function () {
            var w = $grid.width(),
                columnNum = 1,
                columnWidth = 0;
            if (w > 1600) {
                columnNum = 6;
            } else if (w > 1200) {
                columnNum = 5;
            } else if (w > 900) {
                columnNum = 3;
            } else if (w > 600) {
                columnNum = 2;
            } else if (w > 300) {
                columnNum = 2;
            }
            columnWidth = Math.floor(w / columnNum);
            $grid.find('.element-item').each(function () {
                var $item = $(this),
                    multiplier_w = $item.attr('class').match(/item-w(\d)/),
                    multiplier_h = $item.attr('class').match(/item-h(\d)/),
                    width = multiplier_w ? columnWidth * multiplier_w[1] - 4 : columnWidth - 4,
                    height = multiplier_h ? columnWidth * multiplier_h[1] * 0.5 - 4 : columnWidth * 0.5 - 4;
                $item.css({
                    width: width,
                    height: height
                });
            });
            return columnWidth;
        },
        isIsotopeInit = false;

    function onHashchange() {
        var hashFilter = getHashFilter();

        if (hashFilter != null) {
            hashFilter = '.' + hashFilter;
        }

        if (!hashFilter && isIsotopeInit) {
            return;
        }

        isIsotopeInit = true;
        // filter isotope

        $grid.show();
        $(".button-group").show();


        $grid.isotope({
            itemSelector: '.element-item',
            masonry: {
                columnWidth: colWidth(),
            },
            // use filterFns
            filter: filterFns[hashFilter] || hashFilter
        });

        $grid.on('layoutComplete', function () {
            $(".grid img.lazy").unveil();
        });
        console.debug(1);

        // set selected class on button
        if (hashFilter) {
            $filterButtonGroup.find('.pure-button-active').removeClass('pure-button-active');
            $filterButtonGroup.find('[data-filter="' + hashFilter.replace('.', '') + '"]').addClass('pure-button-active');
        }
    }

    $(window).on('hashchange', onHashchange);
    $(window).on('resize', onHashchange);

    onHashchange();

});


$(document).ready(function () {

    $(".grid a").on('click', function (event) {
        event.preventDefault();

        openGallery(this);
    });

    $(".grid img.lazy").unveil();

});




