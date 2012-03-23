<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to delete all of these data?</p>
    <?= form_open('cashier/TableView/deleting'); ?>
    <ul>
        <?
        foreach ($tables as $data):
            echo '<li>Table ' . $data['num'] . ', ' . $data['custname'] . ' ('. $data['kotid'] .')<input type="hidden" name="cb-' . $data['tabid'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('cashier/TableView');">
    <?= form_close() ?>
</div>