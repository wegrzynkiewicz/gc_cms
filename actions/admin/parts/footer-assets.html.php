
<?php
$langDefinedPath = sprintf(ACTIONS_PATH."/admin/parts/assets-%s.html.php", getClientLang());
if (is_readable($langDefinedPath)){
    require $langDefinedPath;
}
?>

<script>
$(function() {
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

<?php require ACTIONS_PATH."/admin/parts/photoswipe.html.php"; ?>

<script>
$('[data-gallery="photoswipe"]').photoswipe({
    loop: false,
    closeOnScroll: false,
});
</script>

<script>
elFinder.prototype._options.url = '<?=rootUrl('/admin/elfinder/connector')?>';
elFinder.prototype._options.lang = '<?=getClientLang()?>';
</script>

<script>
$.ajaxSetup({
    beforeSend: function(xhr, settings) {
        if (!settings.crossDomain) {
            xhr.setRequestHeader("X-CSRFToken", "<?=$_SESSION['csrf_token']?>")
        }
    }
});
$('form').append('<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>');
</script>
