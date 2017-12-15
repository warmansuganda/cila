//REMOTE MODAL
function initModalAjax(selector) {
    var selector_triger = typeof selector !== 'undefined' ? selector : '[data-toggle="modal"]';
    $(selector_triger).click(function(e) {
        /* Parameters */
        var url = $(this).attr('href');
        var container = $(this).attr('data-target');

        if (url.indexOf('#') == 0) {
            $(container).modal();
        } else {
            /* XHR */
            NProgress.start();
            $(container).modal();
            $(container).html('').load(url, function(){
                NProgress.done();
            });
        }
        return false;
    });
}