<div class="sub_kanan">
    <h2>Data Hiding &raquo; Confirmation</h2><hr noshade />
    <p>Are you sure want to hide all of these data?</p>
    <?= form_open('cashier/Billing/hiding'); ?>
    <ul>
        <?
        foreach ($receipt as $data):
            echo '<li>Receipt number ' . $data['recid'] . ', ' . $data['custname'] . ' (KOT number '. $data['kotid'] .')<input type="hidden" name="cb-' . $data['recid'] . '" value="yes" /></li>';
        endforeach;
        ?>
    </ul>
    <input type="submit" value="Continue [&raquo;]">
    <input type="button" value="Cancel [X]" onclick="javascript:_goto('cashier/Billing');">
    <?= form_close() ?>
</div>