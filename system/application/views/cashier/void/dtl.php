<div class="content">
    <h2>Void Detail &raquo; Add</h2><hr noshade>
    <form id="f_dtl_void" method="post">
        <table width="50%" border="0" cellpadding="5" cellspacing="0" class="tbsum">
            <tr>
                <td valign="top" width="120">KOT Reference</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= $kotid ?></td>
            </tr>
            <tr>
                <td valign="top">Customer Name</td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= $custname ?></td>
            </tr>
        </table>
		<div>&nbsp;</div>
        <table width="50%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td valign="top" width="120">Products</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="hidden" name="menuid" id="menuid" value="<?= set_value('menuid') ?>" />
                    <input type="text" name="name" id="name" size="48" value="<?= set_value('name') ?>" readonly="1" />
                    <input type="button" value="Find [&hellip;]" onclick="_toggle('dropbox');" />
                    <div id="dropbox" style="display: none;" class="dropbox">
                        <?= $datagrid ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">Price</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="price" id="price" size="16" value="<?= set_value('price') ?>" readonly="1" />
                </td>
            </tr>
            <tr>
                <td valign="top">Void Qty</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="qty" id="qty" size="4" value="<?= set_value('qty') ?>" />
                </td>
            </tr>
            <tr>
                <td valign="top">Notes</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="notes" id="notes" size="64" value="<?= set_value('notes') ?>" />
                </td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <?= validation_errors('<div class="error">', '</div>'); ?>
		<div>&nbsp;</div>
		<input type="button" value="Save [&radic;]" onclick="formpost('f_dtl_void', '<?= base_url() ?>cashier/Void/dtl/<?= $void ?>');">&nbsp;
		<input type="button" value="Cancel [X]" onclick="formpost('f_dtl_void', '<?= base_url() ?>cashier/Void/cancel');">
		<input type="button" value="Finish [&laquo;]" onclick="formpost('f_dtl_void', '<?= base_url() ?>cashier/Void/finish');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>