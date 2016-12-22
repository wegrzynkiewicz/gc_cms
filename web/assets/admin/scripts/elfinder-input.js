(function($) {

    $.fn.elfinderInputMultiple = function(inputOptions, callback) {

        $(this).click(function() {
            var $dialog = $('<div/>').css({"z-index":"99999"});
            var options = {
                getFileCallback: function(file) {
                    $dialog.dialogelfinder('close');
                    var urls = $.map(file, function(f) {
                        return f.url;
                    });
                    callback(urls);
                },
                commandsOptions: {
                    getfile: {
                        multiple: true,
                        oncomplete: "destroy"
                    }
                }
            };
            $.extend(options, inputOptions);
            $dialog.dialogelfinder(options);
        });

        return this;
    };

    $.fn.elfinderInput = function(inputOptions, callback) {

        $(this).click(function() {
            var $dialog = $('<div/>').css({"z-index":"99999"});
            var options = {
                getFileCallback: function(file) {
                    $dialog.dialogelfinder('close');
                    callback(file.url);
                }
            };
            $.extend(options, inputOptions);
            $dialog.dialogelfinder(options);
        });
        return this;
    };

}(jQuery));
