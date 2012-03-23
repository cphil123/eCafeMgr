<div class="sub_kanan">
    <h2>Stock Reset &raquo; Confirmation</h2><hr noshade />
	<p>Are you sure want to reset the following number of stock of materials?</p>
	<?= form_open('inventory/Stocks/reseting'); ?>
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