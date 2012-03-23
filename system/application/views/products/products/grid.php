<div class="sub_kanan">
    <form id="f_products" method="post">
        <h2>Products &raquo; List</h2><hr noshade>
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<? if (!empty($dtl['catname'])): ?>
			<tr>
				<td width="100" valign="top">Category</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['catname'] ?></td>
			</tr>
			<? endif; ?>
			<? if (!empty($dtl['tagname'])): ?>
			<tr>
				<td width="100" valign="top">Counter</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['tagname']?></td>
			</tr>
			<? endif; ?>
			<? if (!empty($dtl['search'])): ?>
			<tr>
				<td width="100" valign="top">Keywords</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['search'] ?></td>
			</tr>
			<? endif; ?>
		</table>		
        <div>&nbsp;</div>
		<div class="panelfilter" onclick="togglePanelFilter('topcat');">&nbsp;Custom Data Filter<div id="panelsign" class="collapse">&nbsp;</div></div>
		<table width="40%" cellpadding="5" cellspacing="0" border="0" id="topcat" class="topcat" style="display: none;">
			<tr>
				<td width="100" valign="top">Category</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="catid" name="catid">
						<?= $sel_cat ?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Label</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="tagid" name="tagid">
						<?= $sel_tag ?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Keywords</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><input type="text" name="search" id="search" value="<?= $dtl['search'] ?>" /></td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<input type="button" name="btnRefresh" value="Refresh [&#1146;]" onclick="formpost('f_products', '<?= base_url() . 'products/Products/grid' ?>');"/>
				</td>
			</tr>
		</table>
		<hr noshade>
		<div>&nbsp;</div>
		<?= $pagination ?>
		<div>&nbsp;</div>
		<?= validation_errors(); ?>
		<?= $datagrid ?>
		<div>&nbsp;</div>
		<?= $pagination ?>
		<div>&nbsp;</div>
		<input type="button" value="New [+]" onclick="javascript:_goto('products/Products/add');">&nbsp;
		<input type="submit" value="Delete [-]">
    <?= form_close(); ?>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>