<div class="sub_kanan">
<h2>Konfirmasi Hapus Data</h2><hr noshade />
<p>Apakah Anda yakin akan menghapus data-data berikut ini?</p>
<?= form_open('master/divisi/deleting'); ?>
<ul>
<?
	foreach ($divisi as $data):
		echo '<li>'.$data['nmdiv'].'<input type="hidden" name="cb-'.$data['kdiv'].'" value="yes" /></li>';
	endforeach;
?>
</ul>
<input type="submit" value="Lanjutkan [>]">
<input type="button" value="Batalkan [X]" onclick="javascript:goto('master/divisi');">
<?= form_close() ?>
</div>