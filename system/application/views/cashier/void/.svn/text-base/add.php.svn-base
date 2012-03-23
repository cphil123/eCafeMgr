<div class="content">
    <h2>Void &raquo; New</h2><hr noshade>
    <form id="f_void" method="post">
        <input type="hidden" name="userid" value="<?= $userid ?>" />
        <table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td width="120" valign="top">Date</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input type="text" name="date" id="date" value="<?= $date ?>" readonly="1" size="10" /></td>
            </tr>
            <tr>
                <td valign="top">KOT Reference</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input name="kotid" type="text" id="kotid" size="12" maxlength="12" value="<?= $kotid ?>" /></td>
            </tr>
            <tr>
                <td valign="top">Operator</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input name="uname" type="text" id="uname" size="12" maxlength="10" value="<?= $uname ?>" readonly="1" /></td>
            </tr>
        </table>
		<div class="error"><?= validation_errors() ?></div>
        <input type="button" value="Continue [&raquo;]" onclick="formpost('f_void', '<?= base_url() ?>cashier/Void/add');">&nbsp;
		<input type="button" value="Cancel [X]" onclick="javascript:_goto('cashier/Void');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>