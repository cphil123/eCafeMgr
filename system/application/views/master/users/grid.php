<div class="sub_kanan">
<h2>User &raquo; List</h2><hr noshade>
<div>&nbsp;</div>
<?= $pagination ?>
<div>&nbsp;</div>
<?= validation_errors(); ?>
<?= form_open(base_url().'master/Users/delete'); ?>
<?= $datagrid ?>
<div>&nbsp;</div>
<?= $pagination ?>
<div>&nbsp;</div>
<input type="button" value="New [+]" onclick="javascript:_goto('master/Users/add');">&nbsp;
<input type="submit" value="Delete [-]">
<?= form_close(); ?>
</div>