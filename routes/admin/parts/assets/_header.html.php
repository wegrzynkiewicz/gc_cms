<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.9/select2-bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/1.0.9/css/sb-admin-2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.19/css/elfinder.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.19/css/theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack-extra.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.7.0/css/flag-icon.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.4.0/css/bootstrap-colorpicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.60/theme-default.min.css" />

<link rel="stylesheet" href="<?=$uri->root("/assets/admin/main.css")?>">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/<?=getVisitorLang()?>.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.2/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.19/js/elfinder.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/js/i18n/elfinder.<?=getVisitorLang()?>.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/adapters/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/<?=getVisitorLang()?>.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.4.0/js/bootstrap-colorpicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.60/jquery.form-validator.min.js"></script>

<script type="text/javascript">
$(function() {
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.12/i18n/Polish.json"
        },
    });
});
</script>

<script type="text/javascript">
$(function() {
    $.fn.elfinderInputMultiple = function(inputOptions, callback) {
        $(this).click(function() {
            var $dialog = $('<div/>').css({"z-index":"99999"});
            var options = {
                url: '<?=$uri->make($config['elfinder']['uri'])?>',
                lang: '<?=getVisitorLang()?>',
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
});
</script>

<script type="text/javascript">
$(function() {
    $.fn.elfinderInput = function(inputOptions, callback) {
        $(this).click(function() {
            var $dialog = $('<div/>').css({"z-index":"99999"});
            var options = {
                url: '<?=$uri->make($config['elfinder']['uri'])?>',
                lang: '<?=getVisitorLang()?>',
                getFileCallback: function(file) {
                    $dialog.dialogelfinder('close');
                    callback(file.url);
                },
            };
            $.extend(options, inputOptions);
            $dialog.dialogelfinder(options);
        });
        return this;
    };

});
</script>

<script type="text/javascript">
$(function() {
    CKEDITOR.on('dialogDefinition', function(event) {
        var editor = event.editor;
        var dialogDefinition = event.data.definition;
        var tabCount = dialogDefinition.contents.length;
        for (var i = 0; i < tabCount; i++) {
            if (!dialogDefinition.contents[i]) {
                continue;
            }
            var browseButton = dialogDefinition.contents[i].get('browse');
            if (browseButton !== null) {
                browseButton.hidden = false;
                browseButton.onClick = function(dialog, i) {
                    var dialogName = CKEDITOR.dialog.getCurrent()._.name;
                    var elfNode = $('<div \>').css({
                        "z-index": "100000"
                    });
                    elfNode.dialogelfinder({
                        title: '',
                        url: '<?=$uri->make($config['elfinder']['uri'])?>',
                        lang: '<?=getVisitorLang()?>',
                        useBrowserHistory: false,
                        resizable: false,
                        getFileCallback: function(file) {
                            var url = file.url;
                            var dialog = CKEDITOR.dialog.getCurrent();
                            if (dialogName == 'image') {
                                var urlObj = 'txtUrl'
                            } else if (dialogName == 'flash') {
                                var urlObj = 'src'
                            } else if (dialogName == 'files' || dialogName == 'link') {
                                var urlObj = 'url'
                            } else {
                                return;
                            }
                            dialog.setValueOf(dialog._.currentTabId, urlObj, url);
                            elfNode.dialogelfinder('close');
                        }
                    });
                }
            }
        }
    })
});
</script>
