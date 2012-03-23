<div class="sub_kanan">
<h2>Products Categories &raquo; Add</h2><hr noshade>
<?= validation_errors(); ?>
<?= form_open('products/categories/adding'); ?>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Categories: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" /></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="submit" value="Save [&radic;">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('products/categories');">&nbsp;
<?= form_close(); ?>
</div>