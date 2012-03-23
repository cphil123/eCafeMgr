<div class="content">
	<div style="width: 200px;" align="center">
	<?= validation_errors() ?>
	<form action="<?= base_url() ?>auth/login" method="post">
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr bgcolor="#CCCCCC">
				<th colspan="2"><div align="center"><strong>User Login</strong></div></th>
			</tr>
			<tr>
				<td>Username </td>
				<td><input name="uname" type="text" id="uname" size="11"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="paswd" type="password" id="paswd" size="11"></td>
			</tr>
			<tr>
				<td colspan="2"><input name="Login" type="submit" id="Login" value="Login"></td>
			</tr>
		</table>
	</form>
	</div>
</div>
