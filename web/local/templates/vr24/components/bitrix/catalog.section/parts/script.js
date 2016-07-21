(function(window) {
    window.CT_BNL_PARTS = function (data) {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    }
    CT_BNL_PARTS.prototype = {
        init: function () {
            var $id = $("#"+this.data.visual.id);
            $id.find('.products-spares-slider').owlCarousel({
                navigation: true,
                pagination: false,
                itemsCustom: [[1200, 6], [992, 5], [768, 4], [560, 3], [400, 2], [0, 1]],
                theme: "owl-theme owl-theme160"
            });
        }
    }
})(window);