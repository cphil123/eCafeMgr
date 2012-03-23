<div class="sub_kanan">
    <h2>Purchase &raquo; Detail</h2><hr noshade>
    <table class="tbsum" width="30%">
        <tr>
            <td valign="top" width="80">Date</td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $date ?>
            </td>
        </tr>
        <tr>
            <td valign="top">Supplier</td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $nmsup ?>
            </td>
        </tr>
        <tr>
            <td valign="top">Invoice </td>
            <td width="5" valign="top">:</td>
            <td valign="top">
                <?= $numref ?>
            </td>
        </tr>
    </table>
    <div>&nbsp;</div>
    <form id="f_purchase" method="post">
        <input type="hidden" name="ordernum" value="<?= $ordernum ?>" />
        <input type="hidden" id="formtype" name="formtype" value="" />
        <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td valign="top">Category</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <select name="catid" onchange="_goto('inventory/Purchase/dtl/<?= $ordernum ?>/cat/' + this.value);">
                        <?= $cat_options ?>
                    </select>
                    <input type="button" value="New [+]" onclick="_toggle('newcat');" />
                    <div id="newcat" style="display: none;" class="inputbox">
                        <h3>Input New Category</h3><hr noshade>
                        <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tbview">
                            <tr>
                                <td valign="top">Category: <strong>Name</strong></td>
                                <td width="10" valign="top">:</td>
                                <td valign="top">
                                    <input type="text" name="cname" id="cname" size="48" value="<?= set_value('cname') ?>" />
                                </td>
                            </tr>
                        </table>
                        <div>&nbsp;</div>
                        <input type="button" value="Save [&radic;]" onclick="setvalue('formtype', 'newcat'); formpost('f_purchase', '<?= base_url() ?>inventory/Purchase/dtl/<?= $ordernum ?>');">&nbsp;
                    </div>
                </td>
            </tr>
            <tr>
                <td width="120" valign="top">Item</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="hidden" name="matid" id="matid" value="<?= set_value('matid', $matid) ?>" />
                    <input type="text" name="nmmat" id="nmmat" size="48" value="<?= set_value('nmmat', $name) ?>" readonly="1" />
                    <input type="button" value="Find [&hellip;]" onclick="_toggle('dropbox');" />&nbsp;
                    <input type="button" value="New [+]" onclick="_toggle('inputbox');" />
                    <div id="dropbox" style="display: none;" class="dropbox">
                        <?= $datagrid ?>
                    </div>
                    <div id="inputbox" style="display: none;" class="inputbox">
                        <h3>Input New Item</h3><hr noshade>
                        <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tbview">
                            <tr>
                                <td valign="top">Name</td>
                                <td width="10" valign="top">:</td>
                                <td valign="top">
                                    <input type="text" name="name" id="name" size="48" value="<?= set_value('name') ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Unit</td>
                                <td width="10" valign="top">:</td>
                                <td valign="top">
                                    <select name="unid">
                                        <?= $sel_unit ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Counter</td>
                                <td width="10" valign="top">:</td>
                                <td valign="top">
                                    <select name="locid">
                                        <?= $sel_ctr ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div>&nbsp;</div>
                        <input type="button" value="Save [&radic;]" onclick="setvalue('formtype', 'newitem'); formpost('f_purchase', '<?= base_url() ?>inventory/Purchase/dtl/<?= $ordernum ?>');">&nbsp;
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">Price</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="price" id="price" size="16" value="<?= set_value('price') ?>" /> Harga per <input type="text" name="desc" id="desc" size="16" value="<?= $desc ?>" class="noborder" />
                </td>
            </tr>
            <tr>
                <td valign="top">Qty</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="qty" id="qty" size="4" value="<?= set_value('qty') ?>" /><input type="text" name="desc" id="desc" size="16" value="<?= $desc ?>" class="noborder" />
                </td>
            </tr>
            <tr>
                <td valign="top">Discount</td>
                <td width="10" valign="top">:</td>
                <td valign="top">
                    <input type="text" name="disc" id="disc" size="4" value="0" /> %
                </td>
            </tr>
        </table>
        <div>&nbsp;</div>
        <?= validation_errors('<div class="error">', '</div>'); ?>
		<div>&nbsp;</div>
		<input type="button" value="Save [&radic;]" onclick="setvalue('formtype', 'newdetail'); formpost('f_purchase', '<?= base_url() ?>inventory/Purchase/dtl/<?= $ordernum ?>');">&nbsp;
		<input type="button" value="Finish [&empty;]" onclick="formpost('f_purchase', '<?= base_url() ?>inventory/Purchase/grid');">
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>