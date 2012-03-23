<div class="sub_kanan">
    <h2>Attendance &raquo; List</h2><hr noshade>
    <form id="f_attendance" method="post">
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td width="100" valign="top">Month</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['mon'] ?></td>
			</tr>
			<tr>
				<td valign="top">Year</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['year'] ?></td>
			</tr>
			<? if (!empty($dtl['empname'])) { ?>
			<tr>
				<td valign="top">Employee</td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['empname'] ?></td>
			</tr>
			<? } ?>
		</table>		
        <div>&nbsp;</div>
		<div class="panelfilter" onclick="togglePanelFilter('topcat');">&nbsp;Custom Data Filter<div id="panelsign" class="collapse">&nbsp;</div></div>
		<table width="40%" cellpadding="5" cellspacing="0" border="0" id="topcat" class="topcat" style="display: none;">
			<tr>
				<td valign="top" width="100">Month and year</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<select id="mon" name="mon">
						<?= $sel_mon ?>
					</select>
					<input type="text" id="year" name="year" size="6" maxlength="4" value="<?= $year ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top">Employee</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
				<select id="empid" name="empid">
					<?= $sel_emp ?>
				</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<input type="button" name="btnRefresh" value="Refresh [&#1146;]" onclick="formpost('f_attendance', '<?= base_url() . 'employees/Attendance/grid' ?>');"/>
				</td>
			</tr>
		</table>
        <div>&nbsp;</div>
        <div class="pagination"><?= $pagination ?></div>
        <div>&nbsp;</div>
        <?= $datagrid ?>
        <div>&nbsp;</div>
        <div class="pagination"><?= $pagination ?></div>
        <div>&nbsp;</div>
       <input type="button" value="Print per Employee [&prod;]" onclick="javascript:openwin('employees/Attendance/report');">&nbsp;
       <input type="button" value="Print All [&prod;]" onclick="javascript:openwin('employees/Attendance/reportall');">&nbsp;
    </form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>