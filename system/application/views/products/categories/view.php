<div class="sub_kanan">
<h2>Product Categories &raquo; View</h2><hr noshade>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Categories: <strong>Name</strong></td>
    <td width="5">:</td>
    <td><?= $name ?></td>
  </tr>
  <tr>
    <td>Categories: <strong>Prefix</strong></td>
    <td>:</td>
    <td><?= $prefix ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Edit [^]" onclick="javascript:openwin('products/categories/printing/<?= $kdiv ?>');">
<input type="button" value="Back [&laquo;]" onclick="javascript:goto('products/categories');">
</div>