// external js: isotope.pkgd.js

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

function getHashFilter() {
    // get filter=filterName
    var matches = location.hash.match(/c=([^&]+)/i);
    var hashFilter = matches && matches[1];
    return hashFilter && decodeURIComponent(hashFilter);
}

$(function () {

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
            if (w > 1200) {
                columnNum = 4;
            } else if (w > 900) {
                columnNum = 3;
            } else if (w > 600) {
                columnNum = 2;
            } else if (w > 300) {
                columnNum = 1;
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

        if(hashFilter != null){
            hashFilter =  '.' + hashFilter;
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
            $("img.lazy").unveil();
        });

        $(".element-item a").on('click', function () {
            var current_cat = $filterButtonGroup.find('.pure-button-active').data("filter");

            $.each( $(".grid img:visible"), function( key, value ) {
                $(value).parent().attr("rel",current_cat);
            });
        });

        // set selected class on button
        if (hashFilter) {
            $filterButtonGroup.find('.pure-button-active').removeClass('pure-button-active');
            $filterButtonGroup.find('[data-filter="' + hashFilter.replace('.','') + '"]').addClass('pure-button-active');
        }
    }

    $(window).on('hashchange', onHashchange);
    $(window).on('resize', onHashchange);

    onHashchange();

});

$(document).ready(function(){
    //Examples of how to assign the Colorbox event to elements
    $(".gallery").colorbox({
        scalePhotos:true,
        maxWidth: "98%",
        maxHeight: "95%",
        opacity: 0.95
    });

    $("img.lazy").unveil();

});




