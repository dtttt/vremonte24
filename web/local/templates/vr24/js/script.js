(function($){
    $(window).resize(function() {
        var footerHeight = $('#footer').outerHeight(true);
        var bodyMarginBottom = $('body').css('marginBottom');

        if (footerHeight != bodyMarginBottom)
        {
            $('body').css('marginBottom', footerHeight);
        }
    });
    $(document).ready(function() {
        $('#footer').css('height', 'auto');
        $(window).resize();
    });

    /* contacts.html - begin */
    $(document).ready(function() {
        $('.shop-photogallery-slider').owlCarousel({
            items: 6,
            navigation: true,
            pagination: false,
        });

        $('.shop-photogallery-slider .item').fancybox({
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });
    /* contacts.html - end */

    /* about.html - begin */
    $(document).ready(function() {
        $('.about-photogallery-slider').owlCarousel({
            items: 6,
            navigation: true,
            pagination: false
        });

        $('.about-photogallery-slider .item').fancybox({
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });
    /* about.html - end */

    /* index.html - begin */
    $(document).ready(function() {
        $('.index-slider').owlCarousel({
            navigation: true,
            pagination: true,
            theme: "owl-theme-pagination",
            itemsCustom: [[0,1]]

        });
        $('.products-bestsellers-slider').owlCarousel({
            navigation: true,
            pagination: false,
            itemsCustom: [[1200, 6], [992, 5], [768, 4], [560, 3], [400, 2], [0, 1]],
            theme: "owl-theme owl-theme160"
        });
        $('.products-accessories-slider').owlCarousel({
            navigation: true,
            pagination: false,
            itemsCustom: [[1200, 6], [992, 5], [768, 4], [560, 3], [400, 2], [0, 1]],
            theme: "owl-theme owl-theme160"
        });
        $('.video-slider').owlCarousel({
            navigation: true,
            pagination: false,
            theme: "owl-theme owl-theme110"
        });

        $('.video-slider .item > a').fancybox({
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
        
        $('.xs-menu-btn').click(function() {
            if ($(this).is('.active'))
            {
                $('.xs-menu-block').css('display', '');
                $(this).removeClass('active');
            }
            else
            {
                $('.xs-block:visible').css('display', '');
                $('.xs-btn.active').removeClass('active');
                $('.xs-menu-block').show();
                $('.xs-cart-count:hidden').show();
                $(this).addClass('active');
            }
        });

        $('.xs-search-btn').click(function() {
            if ($(this).is('.active'))
            {
                $('.xs-search-block').css('display', '');
                $(this).removeClass('active');
            }
            else
            {
                $('.xs-block:visible').css('display', '');
                $('.xs-btn.active').removeClass('active');
                $('.xs-search-block').show();
                $('.xs-cart-count:hidden').show();
                $(this).addClass('active');
            }
        });
    });
    /* index.html - end */

    /* text-page.html - begin */
    $(document).ready(function() {
        $('.products-repair-slider').owlCarousel({
            navigation: true,
            pagination: false
        });
    });
    /* text-page.html - end */

    /* cart.html - begin */
    $(document).ready(function() {
        $('.products-for-device-slider').owlCarousel({
            navigation: true,
            pagination: false,
            itemsCustom: [[1200, 6], [992, 5], [768, 4], [560, 3], [400, 2], [0, 1]],
            theme: "owl-theme owl-theme160"
        });
    });
    /* cart.html - end */

    /* warranty.html - begin */
    $(window).resize(function() {
        $('.warranty-dots').height( $('.warranty-dots-container').height() );
    });
    $(document).ready(function() {
        $(window).resize();

    });
    /* warranty.html - end */

    /* tech-overlook.html - begin */
    $(document).ready(function() {
        $('.products-corresponding-slider').owlCarousel({
            pagination: false,
            navigation: true,
            itemsCustom: [[1200, 6], [992, 5], [768, 4], [560, 3], [400, 2], [0, 1]],
            theme: "owl-theme owl-theme160"
        });
    });
    /* tech-overlook.html - end */

})(jQuery);