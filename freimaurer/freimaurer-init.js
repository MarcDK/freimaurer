/*
 freimaurer 1.0

 author: Marc Tönsing
 website marc.tv/freimaurer

 a mobile, responsive image gallery build with javascript and php.

 This project uses the following open source projects:

 isotope         http://isotope.metafizzy.co/
 photoswipe      http://photoswipe.com/
 unveil          http://luis-almeida.github.io/unveil/
 Thumb           http://github.com/jamiebicknell/Thumb

 */

"use strict";

function setIndex() {
    $.each($(".freimaurer img:visible"), function (key, img) {
        $(img).parent().attr('data-index', key);
    });
}

function getItems() {
    var items = [];

    $.each($(".freimaurer img:visible"), function (key, img) {



        var href = $(img).parent().attr('href'),
            size = $(img).parent().data('size').split('x'),
            title = $(img).parent().attr("title"),
            width = size[0],
            height = size[1],
            img_src = $(img).attr("src"),
            img_el = $(img);

        var item = {
            src: href,
            title: title,
            w: width,
            h: height,
            msrc: img_src,
            el: img_el
        }

        items.push(item);
    });

    return items;
}

function openGallery(index) {

    var pswpElement = document.querySelectorAll('.pswp')[0];

    var items = getItems();

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

function getHashFilter() {
    // get filter=filterName
    var matches = location.hash.match(/c=([^&]+)/i);
    var hashFilter = matches && matches[1];
    return hashFilter && decodeURIComponent(hashFilter);
}



function colWidth(grid) {
    var w = grid.width(),
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

    grid.find('.element-item').each(function () {
        var item = $(this),
            multiplier_w = item.attr('class').match(/item-w(\d)/),
            multiplier_h = item.attr('class').match(/item-h(\d)/),
            width = multiplier_w ? columnWidth * multiplier_w[1] - 4 : columnWidth - 4,
            height = multiplier_h ? columnWidth * multiplier_h[1] * 0.5 - 4 : columnWidth * 0.5 - 4;
        item.css({
            width: width,
            height: height
        });
    });

    return columnWidth;
}

function parseHash() {
    var hash = window.location.hash.substring(1),
        params = {};

    if(hash.length < 5) {
        return params;
    }

    var vars = hash.split('&');
    for (var i = 0; i < vars.length; i++) {
        if(!vars[i]) {
            continue;
        }
        var pair = vars[i].split('=');
        if(pair.length < 2) {
            continue;
        }
        params[pair[0]] = pair[1];
    }

    if(params.gid) {
        params.gid = parseInt(params.gid, 10);
    }

    if(!params.hasOwnProperty('pid')) {
        return params;
    }
    params.pid = parseInt(params.pid, 10);
    return params;
};

var isIsotopeInit = false;

function onHashchange() {
    var grid = $('.freimaurer');
    var hashFilter = getHashFilter();

    if (hashFilter != null) {
        hashFilter = '.' + hashFilter;
    }

    if (!hashFilter && isIsotopeInit) {
        return;
    }

    isIsotopeInit = true;
    // filter isotope

    grid.isotope({
        itemSelector: '.element-item',
        masonry: {
            columnWidth: colWidth(grid),
        },
        // use filterFns
        filter: hashFilter
    });

    grid.on('layoutComplete', function () {
        $(window).off("unveil");
        $(".freimaurer img.lazy").unveil();
    });

    var filterButtonGroup = $('.freimaurer-nav ul');
    // set selected class on button
    if (hashFilter) {
        filterButtonGroup.find('.active').removeClass('active');
        filterButtonGroup.find('[data-filter="' + hashFilter.replace('.', '') + '"]').addClass('active');
    }

}

$(document).ready(function () {

    $('.freimaurer').show();
    $(".freimaurer-nav").show();

    // bind filter button click
    var filterButtonGroup = $('.freimaurer-nav ul');
    filterButtonGroup.on('click', 'a', function () {

        var filterAttr = $(this).attr('data-filter');
        // set filter in hash

        location.hash = 'c=' + encodeURIComponent(filterAttr);
    });

    $(window).on('hashchange', onHashchange);
    $(window).on('resize', onHashchange);

    onHashchange();

    $(".freimaurer a").on('click', function (event) {
        event.preventDefault();
        setIndex();
        var index = $(this).data("index");
        openGallery(index);
    });

    var navigation = responsiveNav(".nav-collapse", {
        animate: true,                    // Boolean: Use CSS3 transitions, true or false
        transition: 284,                  // Integer: Speed of the transition, in milliseconds
        label: "Menu",                    // String: Label for the navigation toggle
        insert: "before",                  // String: Insert the toggle before or after the navigation
        customToggle: "",                 // Selector: Specify the ID of a custom toggle
        closeOnNavClick: true,           // Boolean: Close the navigation when one of the links are clicked
        openPos: "relative",              // String: Position of the opened nav, relative or static
        navClass: "nav-collapse",         // String: Default CSS class. If changed, you need to edit the CSS too!
        navActiveClass: "js-nav-active",  // String: Class that is added to <html> element when nav is active
        jsClass: "js",                    // String: 'JS enabled' class which is added to <html> element
        init: function(){},               // Function: Init callback
        open: function(){},               // Function: Open callback
        close: function(){}               // Function: Close callback
    });

    $(".freimaurer img.lazy").unveil();


    // Parse URL and open gallery if it contains #&pid=3&gid=1

    var hashData = parseHash();
    if(hashData.pid > 0 && hashData.gid > 0) {
        openGallery();
    }

});




