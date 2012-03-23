<div class="sub_kanan">
<h2>Position &raquo; List</h2><hr noshade>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<?= validation_errors(); ?>
<?= form_open(base_url().'employees/Position/delete'); ?>
<?= $datagrid ?>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<input type="button" value="New [+]" onclick="javascript:_goto('employees/Position/add');">&nbsp;
<input type="submit" value="Delete [-]">
<?= form_close(); ?>
</div>