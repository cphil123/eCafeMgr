<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to delete all of these data?</p>
    <?= form_open('inventory/Status/deleting'); ?>
    <ul>
        <?
        foreach ($status as $data):
            echo '<li>' . $data['title'] . '<input type="hidden" name="cb-' . $data['stid'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Status');">
    <?= form_close() ?>
</div>