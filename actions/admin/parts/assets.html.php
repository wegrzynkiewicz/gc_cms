
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/1.0.9/css/sb-admin-2.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/css/elfinder.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/css/theme.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack-extra.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.7.0/css/flag-icon.css">

<link rel="stylesheet" href="<?=assetsUrl("/admin/styles/main.css")?>">

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/<?=getClientLang()?>.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/1.0.9/js/sb-admin-2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.2/lodash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/js/elfinder.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/js/i18n/elfinder.<?=getClientLang()?>.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script src="<?=rootUrl("/external/ckeditor-4.5.11/ckeditor.js")?>"></script>
<script src="<?=rootUrl("/external/ckeditor-4.5.11/adapters/jquery.js")?>"></script>
<script src="<?=assetsUrl("/admin/scripts/elfinder-input.js")?>"></script>
<script src="<?=assetsUrl("/admin/scripts/ckeditor_integration.js")?>"></script>

<script>
$.validator.setDefaults({
    highlight: function (element, errorClass, validClass) {
        if (element.type === "radio") {
            this.findByName(element.name).addClass(errorClass).removeClass(validClass);
        } else {
            $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            $(element).closest('.form-group').find('span.glyphicon').remove();
            $(element).closest('.form-group').append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
        }
    },
    unhighlight: function (element, errorClass, validClass) {
        if (element.type === "radio") {
            this.findByName(element.name).removeClass(errorClass).addClass(validClass);
        } else {
            $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
            $(element).closest('.form-group').find('span.glyphicon').remove();
            $(element).closest('.form-group').append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
        }
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});
</script>

<script>
$.extend(true, $.fn.dataTable.defaults, {
    fnDrawCallback: function(oSettings) {
        if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
            $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
        }
    },
    language: {
        url: "//cdn.datatables.net/plug-ins/1.10.12/i18n/Polish.json"
    },
});
</script>

<script>
elFinder.prototype._options.url = '<?=rootUrl('/admin/elfinder/connector')?>';
elFinder.prototype._options.lang = '<?=getClientLang()?>';
</script>
