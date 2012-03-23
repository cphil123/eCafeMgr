<div class="sub_kanan">
    <h2>Data Deletion &raquo; Confirmation</h2><hr noshade />
<p>Are you sure want to delete these datas?</p>
<?= form_open('products/Composition/deleting/'.$menuid); ?>
<ul>
<?
	foreach ($compositions as $data):
		echo '<li>'.$data['name'].'<input type="hidden" name="cb-'.$data['comid'].'" value="yes" /></li>';
	endforeach;
?>
</ul>
<input type="submit" value="Continue [&raquo;]">
<input type="button" value="Cancel [X]" onclick="javascript:_goto('products/Composition/grid/<?= $menuid ?>');">
<?= form_close() ?>
</div>