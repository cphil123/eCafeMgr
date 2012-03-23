<?
	require_once("ini.php");
	require_once("db.php");

	$db1 = new Database();
	$db2 = new Database();

	require_once("cpdf.php");

	$cnt = $_REQUEST['c'];
	
	include("report/$cnt.php");
?>