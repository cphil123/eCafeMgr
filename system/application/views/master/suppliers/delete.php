<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to delete all of these data?</p>
    <?= form_open('master/Suppliers/deleting'); ?>
    <ul>
        <?
        foreach ($supplier as $data):
            echo '<li>' . $data['name'] . '<input type="hidden" name="cb-' . $data['supid'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('master/Suppliers');">
    <?= form_close() ?>
</div>