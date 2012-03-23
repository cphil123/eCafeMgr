<div class="sub_kanan">
<h2>Table View &raquo; List</h2><hr noshade>
<?= form_open(base_url().'cashier/tableview/delete'); ?>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<?= validation_errors(); ?>
<?= $datagrid ?>
<div>&nbsp;</div>
<div class="pagination"><?= $pagination ?></div>
<div>&nbsp;</div>
<input type="submit" value="Delete [-]" />
<div>&nbsp;</div>
<?= form_close(); ?>
</div>