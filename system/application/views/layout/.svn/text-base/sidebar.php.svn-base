<div class="sub_kiri">	
	    <div class="menu_utama">
        <?
        echo '<a href="' . base_url() . '">Home</a>';
        if ($is_logged):
			if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))):
            echo '<h3>&laquo; POINT OF SALES &raquo;</h3>';
            echo '<a href="' . base_url() . 'cashier/TableView">Table View</a>';
            echo '<a href="' . base_url() . 'cashier/Kot">Kitchen Order Ticket</a>';
            echo '<a href="' . base_url() . 'cashier/Billing">Billing Statement</a>';
			endif;
			if (in_array($usergroup, array('SYS', 'ADM', 'ACC'))):
            echo '<a href="' . base_url() . 'cashier/Void">Void Transaction</a>';
			endif;
			if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))):
            echo '<h3>&laquo; JOURNALS &amp; REPORTS &raquo;</h3>';
            echo '<a href="' . base_url() . 'cashier/Revenue">Income Statement</a>';
            echo '<a href="' . base_url() . 'products/Sales">Sales Journal</a>';
            echo '<a href="' . base_url() . 'inventory/Purchase/journal">Purchasing Journal</a>';
            echo '<a href="' . base_url() . 'cashier/Summary">Restaurant Summary</a>';
            echo '<a href="' . base_url() . 'employees/Attendance">Attendance Report</a>';
            echo '<a href="' . base_url() . 'guests/Feedback">Guest Comments</a>';
			endif;
			if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))):
            echo '<h3>&laquo; PRODUCTS &raquo;</h3>';
            echo '<a href="' . base_url() . 'products/Products">Products</a>';
            echo '<a href="' . base_url() . 'products/Categories">Product Categories</a>';
			endif;
			if (in_array($usergroup, array('SYS', 'ADM', 'ACC', 'PUR'))):
            echo '<h3>&laquo; INVENTORY &raquo;</h3>';
            echo '<a href="' . base_url() . 'inventory/Purchase">Purchase</a>';
            echo '<a href="' . base_url() . 'inventory/Stocks">Stocks</a>';
            echo '<a href="' . base_url() . 'inventory/Counter">Counter</a>';
            echo '<a href="' . base_url() . 'inventory/Categories">Inventory Categories</a>';
			endif;
			if (in_array($usergroup, array('SYS', 'ADM', 'ACC'))):
            echo '<h3>&laquo; RETOUR &raquo;</h3>';
            echo '<a href="' . base_url() . 'inventory/Retour">Retour</a>';
            echo '<a href="' . base_url() . 'inventory/Losses">Losses</a>';
			endif;
			if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))):
            echo '<h3>&laquo; EMPLOYEES &raquo;</h3>';
            echo '<a href="' . base_url() . 'employees/Employees">Employees</a>';
            echo '<a href="' . base_url() . 'employees/Position">Position</a>';
			endif;
			if (in_array($usergroup, array('SYS', 'ADM', 'ACC'))):
            echo '<h3>&laquo; MISCELLANEOUS &raquo;</h3>';
            echo '<a href="' . base_url() . 'master/Suppliers">Suppliers</a>';
            echo '<a href="' . base_url() . 'master/Users">Users</a>';
			endif;
        endif;
        ?>
    </div>
    <div class="login">
        <? if (!$is_logged): ?>
            <div id="formlogin">
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
        <? else: ?>
		<div class="notes"><div>
			<h3>Welcome <?= $uname ?></h3>
			<p>You are the member of <?= $groupname ?> group.</p>
		</div></div>
        <? endif; ?>
   		</div>
</div>