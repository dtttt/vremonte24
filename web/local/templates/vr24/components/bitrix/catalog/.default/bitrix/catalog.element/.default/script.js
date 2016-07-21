(function(window) {
    window.CT_BCE_CATALOG = function (data) {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    }
    CT_BCE_CATALOG.prototype = {
        init: function () {
            var $id = $('#'+this.data.visual.id);

            if ($id.find('.product-thumbs-slider .overview li').length > 3)
            {
                $id.find('.product-thumbs-slider').tinycarousel({
                    axis: 'y',
                    animationTime: 400,
                    infinite: false
                });
            }

            $id.find('.product-thumbs .overview a').click(function(e) {
                if ($(this).parent().is('.active'))
                {
                    e.preventDefault();
                    return;
                }
                $id.find('.product-big-img a').attr('href', $(this).attr('data-original-src'));
                $id.find('.product-big-img img').attr('src','').attr('src', $(this).attr('href'));
                $id.find('.product-thumbs .overview li.active').removeClass('active');
                $(this).parent().addClass('active');
                e.preventDefault();
            });

            $id.find('.product-big-img a').fancybox({
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });

            $id.find('.xs-product-imgs-slider').owlCarousel({
                pagination: true,
                itemsCustom: [[0,1]],
                theme: "owl-theme-pagination"
            });

            $id.find('.product-tab').click(function() {
                if ($(this).is('.active')) return;
                $id.find('.product-tab.active').removeClass('active');
                $(this).addClass('active');
                $id.find('.product-tab-content:visible').hide();
                $id.find('.product-tab-content[data-tab="'+ $(this).attr('data-tab') +'"]').show();
            });

            $id.find('.product-video-slider').owlCarousel({
                navigation: true,
                pagination: false,
                itemsCustom: [[0,1]]
            });
            $id.find('.product-video-one-row .item a').fancybox({
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });
        }
    }
})(window);