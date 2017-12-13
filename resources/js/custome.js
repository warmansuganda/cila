//REMOTE MODAL
$(function(){
    $('[data-toggle="modal"]').click(function(e) {
        /* Parameters */
        var url = $(this).attr('href');
        var container = $(this).attr('data-container');
        
        if (url.indexOf('#') == 0) {
            $(container).modal();
        } else {
            /* XHR */
            $(container).modal();
            $(container).load(url);
        }
        return false;
    });
});