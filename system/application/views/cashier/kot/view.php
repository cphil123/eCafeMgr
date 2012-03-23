<div class="content">
<h2>Kitchen Order Ticket &raquo; View</h2><hr noshade>
<form id="f_kot" method="post">
<!-- start of reference -->
<input type="hidden" name="dtrange" value="<?= $dtrange ?>" />
<input type="hidden" name="startdate" value="<?= $startdate ?>" />
<input type="hidden" name="enddate" value="<?= $enddate ?>" />
<input type="hidden" name="mon" value="<?= $mon ?>" />
<input type="hidden" name="year" value="<?= $year ?>" />
<input type="hidden" name="ctid" value="<?= $ctid ?>" />
<!-- end of reference -->
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="100"><strong>Table Number </strong></td>
    <td width="5">:</td>
    <td><?= $tview['num'] ?></td>
  </tr>
  <tr>
    <td><strong>Order Number </strong></td>
    <td width="5">:</td>
    <td><?= $tview['kotid'] ?></td>
  </tr>
  <tr>
    <td><strong>Customer Name </strong></td>
    <td>:</td>
    <td><?= $tview['custname'] ?></td>
  </tr>
  <tr>
    <td><strong>Server Name </strong></td>
    <td>:</td>
    <td><?= $tview['nmserver'] ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<?= $datagrid ?>
<div>&nbsp;</div>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td width="100"><strong>Total</strong></td>
    <td width="5">:</td>
    <td><?= $total ?></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Back [&laquo;]" onclick="formpost('f_kot', '<?= base_url() . 'cashier/Kot/grid' ?>');">
</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>