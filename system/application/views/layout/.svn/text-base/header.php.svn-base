<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $web_title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="<?= base_url() ?>css/main.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/table.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>css/chromestyle.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>css/panel.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			var baseurl = '<?= base_url() ?>';
		</script>
        <script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/chrome.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/common.php?ref=<?= base_url() ?>"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/panel.js"></script>
    </head>

    <body>
        <div id="pembungkus_utama">
            <div id="blok_atas">
                <div class="judul_web"><?= $web_title ?></div>
				<div class="menu_atas">
					<div class="chromestyle" id="chromemenu">
					<ul>
					<li><a href="<?= base_url() ?>">Home</a></li>
					<li><a href="#" rel="pos">Point of Sales</a></li>
					<li><a href="#" rel="journal">Journals &amp; Reports</a></li>
					<li><a href="#" rel="product">Products</a></li>	
					<li><a href="#" rel="inventory">Inventory</a></li>	
					<li><a href="#" rel="human">Human Resources</a></li>	
					<li><a href="#" rel="misc">Miscellaneous</a></li>
					<? if ($is_logged): ?>
					<li><a href="<?= base_url() ?>auth/logout">Logout</a></li>
					<? endif; ?>
					</ul>
					</div>

					<div id="pos" class="dropmenudiv">
					<? if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))): ?>
					<a href="<?= base_url() ?>cashier/TableView">Table View</a>
					<a href="<?= base_url() ?>cashier/Kot">Kitchen Order Ticket</a>
					<a href="<?= base_url() ?>cashier/Billing">Billing Statement</a>
					<? if (in_array($usergroup, array('SYS', 'ADM', 'ACC', 'OWN'))): ?>
					<a href="<?= base_url() ?>cashier/Void">Void Transaction</a>
					<? endif; ?>
					<? endif; ?>
					</div>

					<div id="journal" class="dropmenudiv">
					<? if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))): ?>
					<a href="<?= base_url() ?>cashier/Revenue">Revenue Journal</a>
					<a href="<?= base_url() ?>products/Sales">Sales Journal</a>
					<a href="<?= base_url() ?>inventory/Purchase/journal">Purchasing Journal</a>
					<a href="<?= base_url() ?>employees/Attendance">Attendance Report</a>
					<a href="<?= base_url() ?>guests/Feedback">Guest Comments</a>
					<? endif; ?>
					</div>

					<div id="product" class="dropmenudiv">
					<? if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))): ?>
					<a href="<?= base_url() ?>products/Products">Products</a>
					<a href="<?= base_url() ?>products/Categories">Product Categories</a>
					<? endif; ?>
					</div>

					<div id="inventory" class="dropmenudiv">
					<? if (in_array($usergroup, array('SYS', 'ADM', 'ACC', 'PUR', 'OWN'))): ?>
					<a href="<?= base_url() ?>inventory/Purchase">Purchase</a>
					<a href="<?= base_url() ?>inventory/Stocks">Raw Materials</a>
					<? if (in_array($usergroup, array('SYS', 'ADM', 'ACC', 'OWN'))): ?>
					<a href="<?= base_url() ?>inventory/Retour">Retour</a>
					<? endif; ?>
					<a href="<?= base_url() ?>inventory/Counter">Counter</a>
					<a href="<?= base_url() ?>inventory/Categories">Inventory Categories</a>
					<? endif; ?>
					</div>

					<div id="human" class="dropmenudiv">
					<? if (in_array($usergroup, array('SPV', 'SYS', 'ADM', 'ACC', 'OWN', 'OMG', 'GMG', 'PUR'))): ?>
					<a href="<?= base_url() ?>employees/Employees">Employees</a>
					<a href="<?= base_url() ?>employees/Position">Position</a>
					<? endif; ?>
					</div>

					<div id="misc" class="dropmenudiv">
					<? if (in_array($usergroup, array('SYS', 'ADM', 'ACC', 'OWN'))): ?>
					<a href="<?= base_url() ?>master/Suppliers">Suppliers</a>
					<a href="<?= base_url() ?>master/Users">Users</a>
					<a href="<?= base_url() ?>master/Config">Configuration</a>
					<? endif; ?>
					</div>
				</div>
            </div>

            <div id="blok_tengah">