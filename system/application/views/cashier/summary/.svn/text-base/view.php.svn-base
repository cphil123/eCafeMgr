<div class="sub_kanan">
	<h2>Restaurant Summary</h2><hr noshade>
	<form id="f_summary" method="post">
		<table width="40%" cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td width="100" valign="top"><?= Date ?></td>
				<td width="5" valign="top">:</td>
				<td valign="top"><?= $dtl['startdate'] ?></td>
			</tr>
		</table>	
		<input type="button" value="Print [&prod;]" onclick="javascript:openwin('cashier/Summary/report');">		
        <div>&nbsp;</div>
		<div class="panelfilter" onclick="togglePanelFilter('topcat');">&nbsp;Custom Data Filter<div id="panelsign" class="collapse">&nbsp;</div></div>
		<table width="40%" cellpadding="5" cellspacing="0" border="0" id="topcat" class="topcat" style="display: none;">
			<tr>
				<td width="100" valign="top">Date</td>
				<td width="5" valign="top">:</td>
				<td valign="top">
					<?= form_input(array('id' => 'startdate', 'name' => 'startdate', 'size' => '12', 'value' => $startdate)) ?> <img src="<?= base_url() ?>images/cal.gif" onclick="javascript:NewCssCal('startdate', 'DDMMYYYY')" style="cursor:pointer"/> &nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top">
				<input type="button" name="btnRefresh" value="Refresh [&#1146;]" onclick="formpost('f_summary', '<?= base_url() . 'cashier/Summary/view' ?>');"/>
				</td>
			</tr>
		</table>
		
		<table class="panelcontainer">
			<tr>
				<td>
		<div class="panelblock-outter">
			<div class="panelblock-inner">
				<div class="paneltitle">
					<div class="paneltitletext"><a href="#">LEMAH LEDOK TODAY's SUMMARY</a></div>
					<div class="panelaction"><a href="#">[+]</a> <a href="#">[-]</a> <a href="#">[X]</a></div>
				</div>
				<div class="panelcontent">
					<h3>Total Pax per Group</h3>
					<?= $ttlpergroup ?>
					<div>&nbsp;</div>
					<table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
					  <tr>
						<td>Total Discount</td>
						<td>:</td>
						<td><?= $ttldisc ?></td>
					  </tr>
					  <tr>
						<td>Total Tax</td>
						<td>:</td>
						<td><?= $ttltax ?></td>
					  </tr>
					  <tr>
						<td width="140">Total Revenue</td>
						<td width="5">:</td>
						<td><?= $ttlrevenue ?></td>
					  </tr>
					  <tr>
						<td>Number of Pax</td>
						<td>:</td>
						<td><?= $ttlpax ?></td>
					  </tr>
					</table>
				</div>
			</div>
		</div>

		<div class="panelblock-outter">
			<div class="panelblock-inner">
				<div class="paneltitle">
					<div class="paneltitletext"><a href="#">TODAY GUEST COMMENTS / FEEDBACKS</a></div>
					<div class="panelaction"><a href="#">[+]</a> <a href="#">[-]</a> <a href="#">[X]</a></div>
				</div>
				<div class="panelcontent">
					<?= $feedback ?>
				</div>
			</div>
		</div>
				</td>
				<td>
		<div class="panelblock-outter">
			<div class="panelblock-inner">
				<div class="paneltitle">
					<div class="paneltitletext"><a href="#">LEMAH LEDOK MONTH TO DATE SUMMARY</a></div>
					<div class="panelaction"><a href="#">[+]</a> <a href="#">[-]</a> <a href="#">[X]</a></div>
				</div>
				<div class="panelcontent">
					<h3>Total Pax per Group</h3>
					<?= $ttlpergroup_mtd ?>
					<div>&nbsp;</div>
					<table width="60%" border="0" cellpadding="5" cellspacing="0" class="tbview">
					  <tr>
						<td>Total Discount</td>
						<td>:</td>
						<td><?= $ttldisc_mtd ?></td>
					  </tr>
					  <tr>
						<td>Total Tax</td>
						<td width="5">:</td>
						<td><?= $ttltax_mtd ?></td>
					  </tr>
					  <tr>
						<td width="140">Total Revenue</td>
						<td width="5">:</td>
						<td><?= $ttlrevenue_mtd ?></td>
					  </tr>
					  <tr>
						<td>Number of Pax</td>
						<td>:</td>
						<td><?= $ttlpax_mtd ?></td>
					  </tr>
					</table>
				</div>
			</div>
		</div>
				</td>
			</tr>
		</table>		
	</form>
</div>

<script type="text/javascript">
    function isInputValid() {
        return true;
    }
</script>