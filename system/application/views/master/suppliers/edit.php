<div class="sub_kanan">
<h2>Supplier &raquo; Edit</h2><hr noshade>
<div class="error">
<?= validation_errors(); ?>
</div>
<form id="f_supplier" method="post">
<input type="hidden" name="supid" value="<?= $supid ?>" />
<table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Supplier: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" value="<?= set_value('name', $name) ?>" /></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Address</strong></td>
    <td width="10">:</td>
    <td><input name="addr" type="text" id="addr" size="64" maxlength="64" value="<?= set_value('addr', $addr) ?>" /></td>
  </tr>
  <tr>
    <td>Supplier: <strong>City</strong></td>
    <td width="10">:</td>
    <td><input name="city" type="text" id="city" size="32" maxlength="64" value="<?= set_value('city', $city) ?>" /></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Province</strong></td>
    <td width="10">:</td>
    <td><input name="prov" type="text" id="prov" size="32" maxlength="64" value="<?= set_value('prov', $prov) ?>" /></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Zip Code</strong></td>
    <td width="10">:</td>
    <td><input name="zip" type="text" id="zip" size="6" maxlength="5" value="<?= set_value('zip', $zip) ?>" /></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Phone</strong></td>
    <td width="10">:</td>
    <td><input name="phone" type="text" id="phone" size="16" maxlength="16" value="<?= set_value('phone', $phone) ?>" /></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Save [&radic;]" onclick="javascript:formpost('f_supplier', '<?= base_url() . 'master/Suppliers/editing' ?>');">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('master/Suppliers');">&nbsp;
</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>