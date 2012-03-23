<div class="sub_kanan">
<h2>Employee &raquo; Edit</h2><hr noshade>
<?= validation_errors(); ?>
<form id="f_employees" method="post">
<input type="hidden" name="empid" value="<?= $empid ?>"/>
<table width="70%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="160">Employees: <strong>Position</strong></td>
    <td width="10">:</td>
    <td>
        <select name="posid">
            <?= $sel_pos ?>
        </select>
    </td>
  </tr>
  <tr>
    <td>Employees: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" value="<?= set_value('name', $name); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>Birth date</strong></td>
    <td width="10">:</td>
    <td><input name="bdate" type="text" id="bdate" size="8" maxlength="10" value="<?= set_value('bdate', $bdate); ?>"> [Format: dd-mm-yyyy]</td>
  </tr>
  <tr>
    <td>Employees: <strong>Birth place</strong></td>
    <td width="10">:</td>
    <td><input name="bplace" type="text" id="bplace" size="32" maxlength="32" value="<?= set_value('bplace', $bplace); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>Address</strong></td>
    <td width="10">:</td>
    <td><input name="addr" type="text" id="addr" size="64" maxlength="64" value="<?= set_value('addr', $addr); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>City</strong></td>
    <td width="10">:</td>
    <td><input name="city" type="text" id="city" size="32" maxlength="32" value="<?= set_value('city', $city); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>Province</strong></td>
    <td width="10">:</td>
    <td><input name="prov" type="text" id="prov" size="32" maxlength="32" value="<?= set_value('prov', $prov); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>Zip</strong></td>
    <td width="10">:</td>
    <td><input name="zip" type="text" id="zip" size="6" maxlength="5" value="<?= set_value('zip', $zip); ?>"></td>
  </tr>
  <tr>
    <td>Employees: <strong>Phone</strong></td>
    <td width="10">:</td>
    <td><input name="phone" type="text" id="phone" size="12" maxlength="16" value="<?= set_value('phone', $phone); ?>"></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Save [&radic;]" onclick="formpost('f_employees', '<?= base_url() ?>employees/Employees/editing');">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('employees/Employees');">&nbsp;
</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>