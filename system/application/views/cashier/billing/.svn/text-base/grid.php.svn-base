<div class="content">
    <h2>Billing Statement &raquo; List</h2><hr noshade>
    <form id="f_billing" method="post">
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td width="100" valign="top"><?= ($dtrange == 'bydate') ? 'Start Date' : 'Month' ?></td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= ($dtrange == 'bydate') ? $dtl['startdate'] : $dtl['mon'] ?></td>
			</tr>
			<tr>
				<td valign="top"><?= ($dtrange == 'bydate') ? 'End Date' : 'Year' ?></td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= ($dtrange == 'bydate') ? $dtl['enddate'] : $dtl['year'] ?></td>
			</tr>
			<? if (!empty($dtl['ptype'])) { ?>
			<tr>
				<td valign="top">Payment</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['ptype'] ?></td>
			</tr>
			<? } ?>
			<? if (!empty($dtl['ctype'])) { ?>
			<tr>
				<td valign="top">Group</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['ctype'] ?></td>
			</tr>
			<? } ?>
		</table>		
        <div>&nbsp;</div>
		<div class="panelfilter" onclick="togglePanelFilter('topcat');">&nbsp;Custom Data Filter<div id="panelsign" class="collapse">&nbsp;</div></div>
		<table width="100%" cellpadding="5" cellspacing="0" border="0" id="topcat" class="topcat" style="display: none;">
			<tr>
				<td width="180" valign="top"><?= form_radio(array('name' => 'dtrange', 'value' => 'bydate', 'checked' => $radio_dtrange['bydate'])) ?>Range of date</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<?= form_input(array('id' => 'startdate', 'name' => 'startdate', 'size' => '12', 'value' => $startdate)) ?> <img src="<?= base_url() ?>images/cal.gif" onclick="javascript:NewCssCal('startdate', 'DDMMYYYY')" style="cursor:pointer"/> &nbsp;
					<?= form_input(array('id' => 'enddate', 'name' => 'enddate', 'size' => '12', 'value' => $enddate)) ?> <img src="<?= base_url() ?>images/cal.gif" onclick="javascript:NewCssCal('enddate', 'DDMMYYYY')" style="cursor:pointer"/>
				</td>
			</tr>
			<tr>
				<td valign="top"><?= form_radio(array('name' => 'dtrange', 'value' => 'bymonth', 'checked' => $radio_dtrange['bymonth'])) ?>Per month and year</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="mon" name="mon">
						<?= $sel_mon ?>
					</select>
					<input type="text" id="year" name="year" size="6" maxlength="4" value="<?= $year ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top">Payment</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
				<select id="ptid" name="ptid">
					<?= $sel_payment ?>
				</select>
				</td>
			</tr>
			<tr>
				<td valign="top">Group</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
				<select id="ctid" name="ctid">
					<?= $sel_group ?>
				</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<input type="button" name="btnRefresh" value="Refresh [&#1146;]" onclick="formpost('f_billing', '<?= base_url() . 'cashier/Billing/grid' ?>');"/>
				</td>
			</tr>
		</table>
		<hr noshade>
        <div>&nbsp;</div>
		<div class="pagination"><?= $pagination ?></div>
        <div>&nbsp;</div>
        <?= validation_errors(); ?>
        <?= $datagrid ?>
        <div>&nbsp;</div>
		<div class="pagination"><?= $pagination ?></div>
        <div>&nbsp;</div>
        <table width="40%" border="0" cellpadding="5" cellspacing="0" class="tbview">
            <tr>
                <td width="200" valign="top"><strong>Total</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= $total ?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Total Tax</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= $totaltax ?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Total Discount</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><?= $totaldisc ?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Gross Revenue</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><strong><?= $totalall ?></strong></td>
            </tr>
        </table>
        <div>&nbsp;</div>
		<div class="spacing">
<? if ($tax_audit == 'Y') { ?>
        <input type="button" value="Hide [!]" onclick="javascript:formpost('f_billing', '<?= base_url() . 'cashier/Billing/hide' ?>');"/>
        <input type="button" value="Unhide [|]" onclick="javascript:formpost('f_billing', '<?= base_url() . 'cashier/Billing/unhide' ?>');"/>
<? } ?>
        <input type="button" value="Print [&prod;]" onclick="openwin('cashier/Billing/report');"/>
		</div>
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>