<div class="sub_kanan">
	<h2>Raw Materials &raquo; List</h2><hr noshade>
	<form id="f_materials" method="post">
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<? if (!empty($dtl['catname'])): ?>
			<tr>
				<td width="100" valign="top">Category</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['catname'] ?></td>
			</tr>
			<? endif; ?>
			<? if (!empty($dtl['locname'])): ?>
			<tr>
				<td valign="top">Counter</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['locname']?></td>
			</tr>
			<? endif; ?>
			<? if (!empty($dtl['search'])): ?>
			<tr>
				<td valign="top">Keywords</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['search'] ?></td>
			</tr>
			<? endif; ?>
		</table>		
		<div class="pagination"><?= $pagination ?></div>
		<div>&nbsp;</div>
		<div class="panelfilter" onclick="togglePanelFilter('topcat');">&nbsp;Custom Data Filter<div id="panelsign" class="collapse">&nbsp;</div></div>
		<table width="100%" cellpadding="5" cellspacing="0" border="0" id="topcat" class="topcat" style="display: none;">
			<tr>
				<td width="180" valign="top">Category</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="catid" name="catid">
						<?= $sel_cat ?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Counter</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="locid" name="locid">
						<?= $sel_cnt ?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Keywords</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><input type="text" name="search" id="search" value="<?= $search ?>" /></td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<input type="button" name="btnRefresh" value="Refresh [&#1146;]" onclick="formpost('f_materials', '<?= base_url() . 'inventory/Stocks/grid' ?>');"/>
				</td>
			</tr>
		</table>
		<hr noshade>
		<div>&nbsp;</div>
		<?= validation_errors(); ?>
		<?= $datagrid ?>
		<div>&nbsp;</div>
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td width="100" valign="top"><strong>Total Value</strong></td>
				<td width="5" valign="top">:</td>
				<td valign="top"><strong><?= $this->axo_common->FormatCurrency($stockval) ?></strong></td>
			</tr>
		</table>		
		<div>&nbsp;</div>
		<div class="pagination"><?= $pagination ?></div>
		<div>&nbsp;</div>
		<input type="button" value="New [+]" onclick="javascript:_goto('inventory/Stocks/add');">&nbsp;
		<input type="button" value="Delete [-]" onclick="javascript:formpost('f_materials', '<?= base_url() . 'inventory/Stocks/delete' ?>');">
		<input type="button" value="Reset [&#0216;]" onclick="javascript:formpost('f_materials', '<?= base_url() . 'inventory/Stocks/reset' ?>');">
		<input type="button" value="Print [&Pi;]" onclick="javascript:openwin('inventory/Stocks/report');">&nbsp;
    <?= form_close(); ?>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>