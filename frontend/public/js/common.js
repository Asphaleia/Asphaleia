requirejs.config({
    baseUrl: "/asphaleia/js",
    paths: {
        jquery: 'lib/jquery-2.1.3.min',
        bootstrap: 'lib/bootstrap.min.amd',
        mylibs: 'lib/mylibs'
    }
});

define(['jquery', 'mylibs', 'bootstrap'], function($, mylibs) {
    var methods;

    return methods = {
        common: function() {
            $(document).ready(function(){
                // Select active menu element, when page is loaded manually
                var path = window.location.pathname;
                path = path.replace(/\/$/, "");
                path = decodeURIComponent(path);

                $('.nav a').each(function(){
                    if ($(this).attr('href') != undefined) {
                        if ($(this).attr('href') == path) {
                            $(this).closest('li').addClass('active');
                            $(this).closest('li').parents().addClass('active');
                        }
                    }
                });
            });
        }
    }
});