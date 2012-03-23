<div class="sub_kanan">
<h2>Counter &raquo; Edit</h2><hr noshade>
<?= validation_errors(); ?>
<form id="f_counter" method="post">
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
  <tr>
    <td>Counter: <strong>Name</strong></td>
    <td width="10">:</td>
    <td><input name="name" type="text" id="name" size="32" maxlength="64" value="<?= set_value('name', $name); ?>"></td>
  </tr>
</table>
<div>&nbsp;</div>
<input type="button" value="Save [&radic;]" onclick="formpost('f_counter', '<?= base_url() ?>inventory/Counter/editing/<?= $locid ?>');">&nbsp;
<input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Counter');">&nbsp;
</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>