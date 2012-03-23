<div class="sub_kanan">
<h2>Supplier &raquo; View</h2><hr noshade>
<table width="50%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="120">Supplier: <strong>Name</strong></td>
    <td width="5">:</td>
    <td><?= $name ?></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Address </strong></td>
    <td>:</td>
    <td><?= $addr ?></td>
  </tr>
  <tr>
    <td>Supplier: <strong>City </strong></td>
    <td width="5">:</td>
    <td><?= $city ?></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Province </strong></td>
    <td>:</td>
    <td><?= $prov ?></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Zip Code </strong></td>
    <td>:</td>
    <td><?= $zip ?></td>
  </tr>
  <tr>
    <td>Supplier: <strong>Phone </strong></td>
    <td>:</td>
    <td><?= $phone ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Edit [^]" onclick="javascript:_goto('master/Suppliers/edit/<?= $supid ?>');">
<input type="button" value="Back [&laquo;]" onclick="javascript:_goto('master/Suppliers');">
</div>