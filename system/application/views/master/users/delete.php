<div class="sub_kanan">
<h2>Konfirmasi Hapus Data</h2><hr noshade />
<p>Apakah Anda yakin akan menghapus data-data berikut ini?</p>
<?= form_open('master/Users/deleting'); ?>
<ul>
<?
	foreach ($divisi as $data):
		echo '<li>'.$data['uname'].'<input type="hidden" name="cb-'.$data['userid'].'" value="yes" /></li>';
	endforeach;
?>
</ul>
<input type="submit" value="Continue [&raquo;]">
<input type="button" value="Cancel [X]" onclick="javascript:goto('master/Users');">
<?= form_close() ?>
</div>