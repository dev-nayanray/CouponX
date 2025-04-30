// /inc/js/customizer.js
(function($){
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            $('a').css('color', newval);
            $('button').css('background-color', newval);
        });
    });
})(jQuery);