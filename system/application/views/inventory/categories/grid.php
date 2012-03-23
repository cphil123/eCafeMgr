<div class="sub_kanan">
<h2>Categories &raquo; List</h2><hr noshade>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<?= validation_errors(); ?>
<?= form_open(base_url().'inventory/Categories/delete'); ?>
<?= $datagrid ?>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<input type="button" value="New [+]" onclick="javascript:_goto('inventory/Categories/add');">&nbsp;
<input type="submit" value="Delete [-]">
<?= form_close(); ?>
</div>