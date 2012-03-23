<div class="sub_kanan">
<h2>Config &raquo; Edit</h2><hr noshade>
<?= validation_errors(); ?>
<form id="f_users" method="post" action="<?= base_url() . 'master/Config/editing' ?>">
<input type="hidden" name="norec" value="<?= $norec ?>" />
<table width="50%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Name </td>
    <td>:</td>
    <td><input type="text" id="name" name="name" value="<?= set_value('name', $name) ?>" readonly /></td>
  </tr>
<? if ($type == 'TEXT') { ?>
  <tr>
    <td>Value </td>
    <td width="5">:</td>
    <td><textarea name="value" id="value" cols="30" rows="5"><?= set_value('value', $value) ?></textarea></td>
  </tr>
<? } else if ($type == 'CHOICE') { ?>
<?
	$sel_choice[$value] = ' selected';
?>
  <tr>
    <td>Value </td>
    <td width="5">:</td>
    <td><select name="value">
		<option value="Y"<?= $sel_choice['Y'] ?>>Yes</option>
		<option value="N"<?= $sel_choice['N'] ?>>No</option>
	</select></td>
  </tr>
<? } ?>  
</table>
<div>&nbsp;</div>
<input type="submit" value="Save [&radic;]">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('master/Config');">&nbsp;
</form>
</div>