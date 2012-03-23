<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to delete all of these data?</p>
    <?= form_open('inventory/Purchase/deleting'); ?>
    <ul>
        <?
        foreach ($purchase as $data):
            echo '<li>' . $data['nmsup'] . ', ' . $data['nmmat'] . '<input type="hidden" name="cb-' . $data['norec'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Purchase');">
    <?= form_close() ?>
</div>