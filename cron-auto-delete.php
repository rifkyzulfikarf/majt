<?php

	include "admin/inc/blob.php";
	
	$koneksi = new koneksi();
	
	$simpan = $koneksi->runQuery("UPDATE `booking` SET `acc` = '2' WHERE `konfirmasi` = '0' AND `tgl_pesan` < (NOW() - INTERVAL 2 DAY);");
?>