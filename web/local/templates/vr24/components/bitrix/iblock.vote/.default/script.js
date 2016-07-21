(function(window) {
    window.CT_BIV = function (data) {
        this.data = data;
        $(document).ready($.proxy(this.init, this));
    };
    CT_BIV.prototype = {
        init: function () {
            var $id = $('#'+this.data.visual.id);
            if (this.data.votable)
            {
                var obj = this;
                var data = this.data;
                $id.find('.stars div.active').data('active', true);
                $id.on('mouseenter', '.stars div', function() {
                    var $elements = $();
                    if ($(this).data('active') != true)
                        $elements = $elements.add($(this));
                    $elements = $elements.add($(this).add($(this).prevAll(':not(.active)')));
                    $elements.addClass('active');
                }).on('mouseleave', '.stars div', function() {
                    $id.find('.stars div.active').each(function() {
                        if ($(this).data('active') != true)
                            $(this).removeClass('active');
                    });
                }).on('click', '.stars div', function() {
                    $id.off('mouseleave mouseenter', '.stars div');

                    data.ajaxParams.vote = 'Y';
                    data.ajaxParams.rating = $(this).length + $(this).prevAll().length;
                    $.ajax({
                        type: "POST",
                        url: data.ajaxPath,
                        data: data.ajaxParams,
                        success: $.proxy(obj.setResult, obj),
                        dataType: 'json'
                    });
                });
            }
        },
        setResult: function(result) {
            if (!!result && !result.ERROR)
            {
                var $id = $('#'+this.data.visual.id);
                $id.find('.stars div:lt('+Math.ceil(result.value)+')').data('active', true);

                $id.find('.stars div').each(function() {
                    if ($(this).data('active') == true)
                    {
                        if (!$(this).is('.active'))
                            $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });

                if ($id.find('.suffix').length > 0)
                {
                    $id.find('.suffix').html(result.value);
                }
            }
        }
    }
})(window);