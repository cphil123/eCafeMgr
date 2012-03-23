<div class="sub_kanan">
<h2>Product &raquo; View</h2><hr noshade>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Product: <strong>Category</strong></td>
    <td width="5">:</td>
    <td><?= $catname ?></td>
  </tr>
  <tr>
    <td>Product: <strong>Tag</strong></td>
    <td>:</td>
    <td><?= $tagname ?></td>
  </tr>
  <tr>
    <td>Product: <strong>Name</strong></td>
    <td width="5">:</td>
    <td><?= $name ?></td>
  </tr>
  <tr>
    <td>Product: <strong>Price</strong></td>
    <td>:</td>
    <td><?= $price ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Detail [&asymp;]" onclick="javascript:_goto('products/Composition/grid/<?= $menuid ?>');">
<input type="button" value="Edit [^]" onclick="javascript:_goto('products/Products/edit/<?= $menuid ?>');">
<input type="button" value="Back [&laquo;]" onclick="javascript:_goto('products/Products');">
</div>