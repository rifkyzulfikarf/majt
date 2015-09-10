<?php
session_start();
if (isset($_SESSION['majt-id']) && isset($_GET['kode']) && $_GET['kode'] != "") {
	include("admin/inc/blob.php");
	
	$koneksi = new koneksi();
	$id = $_GET['kode'];
	
	$query = "SELECT `booking`.`tgl`, `booking`.`id_pelanggan`, `pelanggan`.`nama` AS nama_pelanggan, `booking`.`nama_pemesan`
			, `booking`.`alamat`, `booking`.`kota`, `booking`.`telp`, `booking`.`acc`, `gedung`.`nama` AS nama_gedung, `gedung`.`dp` 
			FROM `booking` INNER JOIN `gedung` ON (`booking`.`id_gedung` = `gedung`.`id`) INNER JOIN `pelanggan` 
			ON (`booking`.`id_pelanggan` = `pelanggan`.`id`) WHERE `booking`.`id` = '$id';";
	if ($result = $koneksi->runQuery($query)) {
		$rs = $result->fetch_array();
		
		if ($rs['acc'] == "0") {
			$status = "Pesan";
		} elseif ($rs['acc'] == "1") {
			$status = "Sudah Diacc";
		} else {
			$status = "Ditolak";
		}
		
?>
	<html>
	<head>
	<title>Bukti Transaksi Pemesanan</title>
	<link href="assets/css/cetak.css" rel="stylesheet" type="text/css">
	</head>
	<h1> BUKTI PEMESANAN BARANG </h1>
	<table width="600" border="0" cellspacing="2" cellpadding="3">
	  <tr>
		<td><strong>Tgl. Pemesanan </strong></td>
		<td><strong>:</strong></td>
		<td> <?php echo $rs['tgl'] ?> </td>
	  </tr>
	  <tr>
		<td><strong>Pelanggan</strong></td>
		<td><strong>:</strong></td>
		<td><?php echo $rs['id_pelanggan']." - ".$rs['nama_pelanggan'] ?></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong>Nama Pemesan</strong></td>
		<td><strong>:</strong></td>
		<td><?php echo $rs['nama_pemesan'] ?></td>
	  </tr>
	  <tr>
		<td><strong>Alamat Pemesan</strong></td>
		<td><strong>:</strong></td>
		<td><?php echo $rs['alamat'] ?></td>
	  </tr>
	  <tr>
		<td><strong>Kota</strong></td>
		<td><strong>:</strong></td>
		<td><?php echo $rs['kota'] ?></td>
	  </tr>
	  <tr>
		<td><strong>No. Telepon</strong></td>
		<td><strong>:</strong></td>
		<td><?php echo $rs['telp'] ?></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong>Status Pemesanan</strong></td>
		<td><strong>:</strong></td>
		<td><strong><?php echo $status; ?></strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<table width="761" border="0" cellpadding="2" cellspacing="0">
	  <tr>
		<td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
		<td width="324" bgcolor="#CCCCCC"><strong>Gedung</strong></td>
		<td width="132" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp)</strong></td>
		<td width="60" align="center" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
		<td width="122" align="right" bgcolor="#CCCCCC"><strong>Total (Rp)</strong></td>
	  </tr>
		<tr>
		<td align="center">1</td>
		<td><?php echo $rs['nama_gedung'] ?></td>
		<td align="right">Rp. <?php echo number_format($rs['dp'], 0, ",", ".") ?></td>
		<td align="right">1</td>
		<td align="right">Rp. <?php echo number_format($rs['dp'], 0, ",", ".") ?></td>
	  </tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp) : </strong></td>
		<td align="right" bgcolor="#F5F5F5">Rp. <?php echo number_format($rs['dp'], 0, ",", ".") ?></td>
	  </tr>
	  <tr>
		<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL  (Rp) : </strong></td>
		<td align="right" bgcolor="#F5F5F5">Rp. <?php echo number_format($rs['dp'], 0, ",", ".") ?></td>
	  </tr>
	</table>
	</body>
	</html>
<?php
	}
}
?>