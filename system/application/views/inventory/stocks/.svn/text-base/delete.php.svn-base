<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to delete all of these data?</p>
    <?= form_open('inventory/Stocks/deleting'); ?>
    <ul>
        <?
        foreach ($materials as $data):
            echo '<li>' . $data['name'] . '<input type="hidden" name="cb-' . $data['matid'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Stocks');">
    <?= form_close() ?>
</div>