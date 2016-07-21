(function(window){
    window.CT_SBBL_NOTXS = function(data)
    {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    }
    CT_SBBL_NOTXS.prototype = {
        init: function()
        {
            BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshCart'));
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
        }
    };
})(window);