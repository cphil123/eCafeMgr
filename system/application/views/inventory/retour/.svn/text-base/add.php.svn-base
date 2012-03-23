<div class="content">
    <h2>Retour &raquo; New</h2><hr noshade>
    <form id="f_retour" method="post">
        <input type="hidden" name="userid" value="<?= $userid ?>" />
        <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td width="120" valign="top">Date</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= form_input(array('id' => 'startdate', 'name' => 'startdate', 'size' => '12', 'value' => $startdate)) ?> <img src="<?= base_url() ?>images/cal.gif" onclick="javascript:NewCssCal('startdate', 'DDMMYYYY')" style="cursor:pointer"/></td>
            </tr>
            <tr>
                <td valign="top">Operator</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input name="uname" type="text" id="uname" size="12" maxlength="10" value="<?= $uname ?>" readonly="1" /></td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <input type="button" value="Continue [&raquo;]" onclick="formpost('f_retour', '<?= base_url() ?>inventory/Retour/add');">&nbsp;
		<input type="button" value="Cancel [X]" onclick="javascript:_goto('inventory/Retour');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>