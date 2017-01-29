<li>
    <a id="session-refresh" href="#"
        title="<?=$trans('Kliknij, aby odświeżyć czas')?>">
        <span class="hidden-xs">
            <?=$trans('Do końca: ')?>
        </span>
        <i class="fa fa-clock-o fa-fw"></i>
        <span id="session-countdown"><?=date("i:s", $config['session']['staff']['cookie']['lifetime'])?></span>
    </a>

    <script>
        $(function() {
            var timeoutUrl = "<?=GC\Url::make('/auth/session-timeout')?>";
            var refreshUrl = "<?=GC\Url::make('/admin/account/session-refresh')?>";
            var sessionTimeout = <?=e($config['session']['staff']['cookie']['lifetime'])?>;

            var finalTime = new Date();
            finalTime.setSeconds(finalTime.getSeconds() + sessionTimeout);
            $('#session-countdown')
                .countdown(finalTime)
                .on('update.countdown', function(event) {
                    $(this).html(event.strftime('%M:%S'));
                })
                .on('finish.countdown', function(event) {
                    window.location.href = timeoutUrl;
                });
            $('#session-refresh').click(function(event){
                event.preventDefault();
                var nextTime = new Date();
                nextTime.setSeconds(nextTime.getSeconds() + sessionTimeout);
                $.post(refreshUrl, function(data, statusText, xhr) {
                    if (xhr.status == 204) {
                        $('#session-countdown').countdown(nextTime);
                    }
                });
            });
        });
    </script>

</li>
