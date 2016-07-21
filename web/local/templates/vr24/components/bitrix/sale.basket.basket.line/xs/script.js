;(function(window){
    window.CT_SBBL_XS = function(data)
    {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    }
    CT_SBBL_XS.prototype = {
        init: function()
        {
            BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshCart'));
            $('#' + this.data.visual.id).on('click', '.action-delete', this.removePosition);
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
            if (this.removeItem)
            {
                this.removeItem = false;
                return;
            }
            var data = {
                sessid: BX.bitrix_sessid(),
                siteId: this.data.siteId,
                templateName: this.data.templateName,
                arParams: this.data.arParams
            };
            data.arParams.OPEN = $('#'+this.data.visual.id).is(':visible') ? 'Y' : 'N';
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
        removePosition: function()
        {
            var obj = window[$(this).attr('data-js')];
            BX.ajax({
                url: obj.data.ajaxPath,
                method: 'POST',
                dataType: 'html',
                data: {
                    sbblRemoveItemFromCart: $(this).attr('data-positionId'),
                    sessid: BX.bitrix_sessid(),
                    siteId: obj.data.siteId,
                    templateName: obj.data.templateName,
                    arParams: obj.data.arParams
                },
                onsuccess: $.proxy(this.removePositionOnSuccess, this)
            });
            this.removeItem = true;
            BX.onCustomEvent('OnBasketChange');
        },
        removePositionOnSuccess: function(result)
        {
            $.proxy(this.refreshCartOnSuccess, this)(result);
            BX.onCustomEvent('OnAfterBasketChange');
        }
    };
})(window);