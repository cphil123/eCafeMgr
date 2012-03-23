<div class="sub_kanan">
<h2>DIVISI &raquo; EDIT</h2><hr noshade>
<?= validation_errors(); ?>
<?= form_open('master/divisi/editing/'.$kdiv); ?>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Divisi: <strong>Nama</strong></td>
    <td width="10">:</td>
    <td><input name="nmdiv" type="text" id="nmdiv" size="32" maxlength="64" value="<?= set_value('nmdiv', $nmdiv); ?>"></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="submit" value="Simpan [V]">&nbsp;
<input type="button" value="Batalkan [X]" onclick="javascript:goto('master/divisi');">&nbsp;
<?= form_close(); ?>
</div>