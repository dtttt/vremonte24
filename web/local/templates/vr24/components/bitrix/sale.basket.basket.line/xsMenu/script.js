(function(window){
    window.CT_SBBL_XSMENU = function(data)
    {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    }
    CT_SBBL_XSMENU.prototype = {
        init: function()
        {
            BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshCart'));
            $('#' + this.data.visual.id).on('click', '.xs-cart-btn', $.proxy(this.toggleMenu, this));
        },
        closure: function (fname, data)
        {
            var obj = this;
            return data
                ? function(){obj[fname](data)}
                : function(arg1){obj[fname](arg1)};
        },
        refreshCart: function()
        {
            var data = {
                sessid: BX.bitrix_sessid(),
                siteId: this.data.siteId,
                templateName: this.data.templateName,
                arParams: this.data.arParams
            };
            data.arParams.OPEN = $('#' + this.data.visual.id + ' .xs-cart-btn').is('.active') ? 'Y' : 'N';
            BX.ajax({
                url: this.data.ajaxPath,
                method: 'POST',
                dataType: 'html',
                data: data,
                onsuccess: $.proxy(this.refreshCartOnSuccess, this)
            });
        },
        refreshCartOnSuccess: function(result)
        {
            $('#'+this.data.visual.id).html(result);
        },
        toggleMenu: function()
        {
            var $item = $('#'+this.data.visual.id + ' .xs-cart-btn');
            if ($item.is('.active'))
            {
                $('.xs-cart-block').hide();
                $item.find('.xs-cart-count').show();
                $item.removeClass('active');
            }
            else
            {
                $('.xs-block:visible').hide();
                $('.xs-btn.active').removeClass('active');
                $item.find('.xs-cart-count').hide();
                $('.xs-cart-block').show();
                $item.addClass('active');
            }
        }
    };
})(window);