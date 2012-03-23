<div class="content">
    <h2>Retour Detail &raquo; Add</h2><hr noshade>
    <form id="f_dtl_retour" method="post">
        <table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td>Category</td>
                <td width="10">:</td>
                <td>
                    <select name="catid" onchange="_goto('inventory/Retour/dtl/<?= $retid ?>/cat/' + this.value);">
                        <?= $cat_options ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Material</td>
                <td width="10">:</td>
                <td>
                    <input type="hidden" name="matid" id="matid" value="<?= set_value('matid') ?>" />
                    <input type="text" name="nmmat" id="nmmat" size="48" value="<?= set_value('nmmat') ?>" readonly="1" />
                    <input type="button" value="Find [&hellip;]" onclick="_toggle('dropbox');" />&nbsp;
                    <div id="dropbox" style="display: none;" class="dropbox">
                        <?= $datagrid ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Price</td>
                <td width="10">:</td>
                <td>
                    <input type="text" name="price" id="price" size="16" value="<?= set_value('price') ?>" readonly="1" />
					per <input type="text" id="unitname" name="unitname" style="border: none;" size="8" readonly="1" />
                </td>
            </tr>
            <tr>
                <td>Stock</td>
                <td width="10">:</td>
                <td>
                    <input type="text" name="stock" id="stock" size="4" value="<?= set_value('stock') ?>" readonly="1" />						
					<input type="text" id="unitname" name="unitname" style="border: none;" size="8" readonly="1" />
                </td>
            </tr>
            <tr>
                <td>Retour Qty</td>
                <td width="10">:</td>
                <td>
                    <input type="text" name="qty" id="qty" size="4" value="<?= set_value('qty') ?>" />
                </td>
            </tr>
            <tr>
                <td>Unit</td>
                <td width="10">:</td>
                <td>
                    <select id="unid" name="unid">
                        <?= $sel_unit ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td width="10">:</td>
                <td>
                    <select id="stid" name="stid">
                        <?= $sel_status ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Notes</td>
                <td width="10">:</td>
                <td>
                    <input type="text" name="notes" id="notes" size="64" value="<?= set_value('notes') ?>" />
                </td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <?= validation_errors('<div class="error">', '</div>'); ?>
		<div>&nbsp;</div>
		<input type="button" value="Save [&radic;]" onclick="formpost('f_dtl_retour', '<?= base_url() ?>inventory/Retour/dtl/<?= $retid ?>');">&nbsp;
		<input type="button" value="Cancel [X]" onclick="formpost('f_dtl_retour', '<?= base_url() ?>inventory/Retour/cancel');">
		<input type="button" value="Finish [&laquo;]" onclick="formpost('f_dtl_retour', '<?= base_url() ?>inventory/Retour/finish');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>