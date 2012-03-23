<div class="sub_kanan">
<h2>Raw Materials &raquo; Add</h2><hr noshade>
<?= validation_errors(); ?>
<form id="f_stocks" method="post">
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Category</td>
    <td width="10">:</td>
    <td>
        <select name="catid"><?= $sel_cat ?></select>
    </td>
  </tr>
  <tr>
    <td>Counter</td>
    <td width="10">:</td>
    <td>
        <select name="locid"><?= $sel_cnt ?></select>
    </td>
  </tr>
  <tr>
    <td>Name</td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" value="<?= set_value('name', $name); ?>"></td>
  </tr>
  <tr>
    <td>Unit</td>
    <td width="10">:</td>
    <td>
        <select name="unid"><?= $sel_unit ?></select>
    </td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Save [&radic;]" onclick="formpost('f_stocks', '<?= base_url() ?>inventory/Stocks/adding');">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Stocks');">&nbsp;
</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>