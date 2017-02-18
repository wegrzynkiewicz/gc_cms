
<b><?=trans('Dane lokalizacyjne')?></b><br>
<br>
<table border="1" cellpadding="6" class="localization" style="border-collapse:collapse;">
    <tr>
        <td width="85"><?=trans('Data wysłania')?></td>
        <td><?=sqldate()?></td>
    </tr>
    <tr>
        <td>IP</td>
        <td><?=def($localization, 'ip')?></td>
    </tr>
    <tr>
        <td><?=trans('Kraj / Miasto')?></td>
        <td><?=def($localization, 'country', '').' / '.def($localization, 'city', '')?></td>
    </tr>
    <tr>
        <td>User Agent</td>
        <td><?=def($localization, 'userAgent', '')?></td>
    </tr>
</table>
