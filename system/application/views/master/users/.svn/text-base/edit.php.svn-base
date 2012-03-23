<div class="sub_kanan">
<h2>DIVISI &raquo; EDIT</h2><hr noshade>
<?= validation_errors(); ?>
<form id="f_users" method="post" action="<?= base_url() . 'master/Users/editing' ?>">
<input type="hidden" name="userid" value="<?= $userid ?>" />
<table width="50%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Username </td>
    <td>:</td>
    <td><input type="text" id="uname" name="uname" value="<?= set_value('uname', $uname) ?>" /></td>
  </tr>
  <tr>
    <td>Password </td>
    <td width="5">:</td>
    <td><input type="text" id="paswd" name="paswd" value="<?= set_value('paswd', $paswd) ?>" /></td>
  </tr>
  <tr>
    <td>Group </td>
    <td>:</td>
    <td><select name="group"><?= $sel_group ?></select></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="submit" value="Save [&radic;]">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('master/Users');">&nbsp;
</form>
</div>