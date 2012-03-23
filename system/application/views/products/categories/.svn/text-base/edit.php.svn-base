<div class="sub_kanan">
<h2>Product Categories &raquo; Edit</h2><hr noshade>
<?= validation_errors(); ?>
<?= form_open('products/categories/editing'); ?>
<input type="hidden" name="catid" id="catid" value="<?= $catid ?>" />
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Categories: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" value="<?= set_value('name', $name); ?>"></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="submit" value="Save [&radic;]">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:goto('products/categories');">&nbsp;
<?= form_close(); ?>
</div>