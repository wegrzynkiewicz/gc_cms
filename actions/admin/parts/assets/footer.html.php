<?php
$template = sprintf(ACTIONS_PATH.'/admin/parts/assets/footer-%s.html.php', getClientLang());
if (is_readable($template)) {
    require $template;
}
?>

<script>
$(window).bind("load resize", function() {
    var topOffset = 50;
    var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
    if (width < 768) {
        $('div.navbar-collapse').addClass('collapse');
        topOffset = 100; // 2-row-menu
    } else {
        $('div.navbar-collapse').removeClass('collapse');
    }

    var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
    height = height - topOffset;
    if (height < 1) height = 1;
    if (height > topOffset) {
        $("#page-wrapper").css("min-height", (height) + "px");
    }
});

var url = window.location;
var element = $('ul.nav a').filter(function() {
 return this.href == url;
}).addClass('active').parent();

while(true){
    if (element.is('li')){
        element = element.parent().addClass('in').parent();
    } else {
        break;
    }
}
</script>

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

<?php require ACTIONS_PATH."/admin/parts/photoswipe.html.php"; ?>

<script>
$('[data-gallery="photoswipe"]').photoswipe({
    loop: false,
    closeOnScroll: false,
});
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
