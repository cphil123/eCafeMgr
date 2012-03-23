<div class="sub_kanan">
<h2>Employees &raquo; View</h2><hr noshade>
<table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="160">Employees: <strong>Position</strong></td>
    <td width="10">:</td>
    <td><?= $nmpos ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><?= $name ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Birth date</strong></td>
    <td width="10">:</td>
    <td><?= $bdate ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Birth place</strong></td>
    <td width="10">:</td>
    <td><?= $bplace ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Address</strong></td>
    <td width="10">:</td>
    <td><?= $addr ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>City</strong></td>
    <td width="10">:</td>
    <td><?= $city ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Province</strong></td>
    <td width="10">:</td>
    <td><?= $prov ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Zip</strong></td>
    <td width="10">:</td>
    <td><?= $zip ?></td>
  </tr>
  <tr>
    <td>Employees: <strong>Phone</strong></td>
    <td width="10">:</td>
    <td><?= $phone ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Edit [^]" onclick="javascript:_goto('employees/Employees/edit/<?= $empid ?>');">
<input type="button" value="Back [&laquo;]" onclick="javascript:_goto('employees/Employees');">
</div>