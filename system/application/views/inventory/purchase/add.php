<div class="content">
    <h2>Purchase &raquo; Add</h2><hr noshade>
    <form id="f_purchase" method="post">
        <input type="hidden" id="formtype" name="formtype" value="" />
        <input type="hidden" name="userid" value="<?= $userid ?>" />
        <table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td width="100" valign="top">Date</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= form_input(array('id' => 'startdate', 'name' => 'startdate', 'size' => '12', 'value' => $startdate)) ?> <img src="<?= base_url() ?>images/cal.gif" onclick="javascript:NewCssCal('startdate', 'DDMMYYYY')" style="cursor:pointer"/></td>
            </tr>
            <tr>
                <td valign="top">Supplier</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="hidden" name="supid" id="supid" value="<?= set_value('supid') ?>" />
                    <input type="text" name="nmsup" id="nmsup" size="48" value="<?= set_value('nmsup') ?>" />
                    <input type="button" value="Find [&hellip;]" onclick="_toggle('dropbox');" />
                    <div id="dropbox" style="display: none;">
                        <?= $datagrid ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">Invoice</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input name="numref" type="text" id="numref" size="16" maxlength="12" value="<?= $numref ?>" /></td>
            </tr>
            <tr>
                <td valign="top">Operator</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><input name="uname" type="text" id="uname" size="12" maxlength="10" value="<?= $uname ?>" readonly="1" /></td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <?= validation_errors('<div class="error">', '</div>'); ?>
		<div>&nbsp;</div>                        
		<input type="button" value="Continue [&raquo;]" onclick="setvalue('formtype', 'master'); formpost('f_purchase', '<?= base_url() ?>inventory/Purchase/add');">&nbsp;
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>