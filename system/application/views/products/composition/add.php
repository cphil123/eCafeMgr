<div class="sub_kanan">
    <h2>Compisition &raquo; Add</h2><hr noshade>
    <table class="tbsum" width="30%">
        <tr>
            <td valign="top">ID</td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $menuid ?>
            </td>
        </tr>
        <tr>
            <td valign="top">Product</td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $name ?>
            </td>
        </tr>
        <tr>
            <td valign="top">Price</td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $price ?>
            </td>
        </tr>
    </table>
    <div>&nbsp;</div>
    <?= validation_errors(); ?>
    <form id="f_composition" method="post">
        <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td valign="top">Category</td>
                <td valign="top" width="10">:</td>
                <td valign="top">
                    <select name="catid" onchange="_goto('products/Composition/add/<?= $menuid ?>/cat/' + this.value);">
                        <?= $cat_options ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="top">Raw Item</td>
                <td valign="top" width="10">:</td>
                <td valign="top">
                    <input type="hidden" name="matid" id="matid" value="<?= set_value('matid', $matid) ?>" />
                    <input type="text" name="nmmat" id="nmmat" size="48" value="<?= set_value('nmmat', $nmmat) ?>" />
                    <input type="button" value="Find [&hellip;]" onclick="_toggle('dropbox');" />&nbsp;
                    <div id="dropbox" style="display: none;" class="dropbox">
                        <?= $datagrid ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">Quantity</td>
                <td valign="top" width="10">:</td>
                <td valign="top"><input name="qty" type="text" id="qty" size="6" maxlength="6" /></td>
            </tr>
            <tr>
                <td valign="top">Unit</td>
                <td valign="top" width="10">:</td>
                <td valign="top">
					<select name="unid">
						<?=  $sel_unit ?>
					</select>
				</td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <input type="button" value="Save [&radic;]" onclick="formpost('f_composition', '<?= base_url() ?>products/Composition/adding/<?= $menuid ?>');">&nbsp;
        <input type="button" value="Finish [&empty;]" onclick="_goto('products/Composition/grid/<?= $menuid ?>');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>