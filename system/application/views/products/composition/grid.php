<div class="sub_kanan">
    <h2>Composition &raquo; List</h2><hr noshade>
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
    <?= $pagination ?>
                <div>&nbsp;</div>
    <?= validation_errors(); ?>
    <?= form_open(base_url() . 'products/Composition/delete/'.$menuid); ?>
    <?= $datagrid ?>
                <div>&nbsp;</div>
    <?= $pagination ?>
    <table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
        <tr>
            <td width="120" valign="top"><strong>Cost of Product</strong></td>
            <td width="10" valign="top">:</td>
            <td valign="top"><?= $hpp ?></td>
        </tr>
    </table>
                <div>&nbsp;</div>
                <input type="button" value="New [+]" onclick="javascript:_goto('products/Composition/add/<?= $menuid ?>');">&nbsp;
                <input type="button" value="Print [&prod;]" onclick="javascript:openwin('products/Composition/printing/<?= $menuid ?>');">&nbsp;
                <input type="submit" value="Delete [X]">
                <input type="button" value="Back [&laquo;]" onclick="javascript:_goto('products/Products');">
    <?= form_close(); ?>
</div>