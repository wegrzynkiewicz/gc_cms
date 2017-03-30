<script>
$(function() {

    var refreshThemeUri = "<?=$uri->make("/admin/module/{$module_id}/refresh")?>";

    function refreshTheme(theme) {
        $.get(refreshThemeUri, {
            theme: theme,
        }, function(data) {
            $('#moduleTheme').html(data ? data : '');
        });
    }

    $('#theme').change(function() {
        refreshTheme($(this).val());
    });
});
</script>
