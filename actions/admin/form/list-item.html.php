<tr>

    <td>
        <?=e($form['name'])?>
    </td>

    <td>
        <?php if (isset($counts[$form_id]) and $counts[$form_id]['unread'] > 0): ?>
            <span class="label label-warning">
                <?=e($counts[$form_id]['unread'])?>
            </span>
        <?php else: ?>
            <span class="label label-success">
                0
            </span>
        <?php endif ?>
    </td>

    <td class="text-right">
        <a href="<?=$uri->mask("/{$form_id}/received/list")?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=trans('Pokaż nadesłane')?>
        </a>
        <a href="<?=$uri->mask("/{$form_id}/field/list")?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Pola formularza')?>
        </a>
    </td>

</tr>
