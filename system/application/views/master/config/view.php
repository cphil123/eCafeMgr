<div class="sub_kanan">
<h2>Config &raquo; View</h2><hr noshade>
<table width="30%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="120">Record #</td>
    <td width="5">:</td>
    <td><?= $norec ?></td>
  </tr>
  <tr>
    <td>Name </td>
    <td>:</td>
    <td><?= $name ?></td>
  </tr>
  <tr>
    <td>Value </td>
    <td width="5">:</td>
    <td><?= $value ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Edit [^]" onclick="javascript:_goto('master/Config/edit/<?= $norec ?>');">
<input type="button" value="Back [&laquo;]" onclick="javascript:_goto('master/Config');">
</div>