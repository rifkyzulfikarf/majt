<?php
	session_start();
	if (isset($_POST['apa']) && $_POST['apa'] != "" ) {
		switch ($_POST['apa']) {
			case "logout":
				$arr = array();
				
				session_destroy();
				
				$arr['status']=TRUE;
				
				echo json_encode($arr);
				break;
			case "calendar-data":
				include "../../admin/inc/blob.php";
				
				$koneksi = new koneksi();
				$events = array();
				
				//Lihat dulu jumlah gedung yang ada
				if ($result = $koneksi->runQuery("SELECT COUNT(id) FROM gedung")) {
					$rs = $result->fetch_array();
					$jumlahGedung = $rs[0];
				}
				
				$jumlahGedung = $jumlahGedung * 2;
				
				if ($result = $koneksi->runQuery("SELECT tgl, COUNT(id) FROM booking GROUP BY tgl ASC")) {
					while ($rs = $result->fetch_array()) {
						$e = array();
						
						$e['start'] = $rs['tgl'];
						$e['end'] = $rs['tgl'];
						$e['allDay'] = true;
						
						if ($rs[1] == $jumlahGedung) {
							$e['title'] = "Penuh";
							$e['color'] = "red";
						} else if ($rs[1] < $jumlahGedung) {
							$e['title'] = ($jumlahGedung - $rs[1])." ruangan tersedia.";
							$e['color'] = "blue";
						}
						
						
							
						array_push($events, $e);
					}
				}
				
				echo json_encode($events);
				break;
			case "show-orderable":
				if (isset($_POST['tgl']) && $_POST['tgl'] != "") {
					include "../../admin/inc/blob.php";
					
					$koneksi = new koneksi();
					$tgl = $_POST['tgl'];
					$dowTgl = date("w", strtotime($tgl));
					$i = 1;
					
					$qGedung = "SELECT * FROM gedung";
					
					if ($resGedung = $koneksi->runQuery($qGedung)) {
						while ($rsGedung = $resGedung->fetch_array()) {
							if ($i == 1) { echo "<div class='col-sm-3 col-sm-offset-2'>"; } else { echo "<div class='col-sm-3'>"; }
							echo "<div class='thumbnail'>";
							echo "<img src='assets/images/gedung/".$rsGedung['img']."' alt=''>";
							echo "<div class='caption'>";
							echo "<h3>".$rsGedung['nama']."</h3>";
							echo "<p>".$rsGedung['kapasitas']."</p>";
							echo "<p>DP Rp. ".number_format($rsGedung['dp'], 0, ",", ".")."</p>";
							
							$qHarga = "SELECT waktu, harga FROM harga_gedung WHERE id_gedung = '".$rsGedung['id']."' AND hari = '$dowTgl'";
							if ($resHarga = $koneksi->runQuery($qHarga)) {
								while ($rsHarga = $resHarga->fetch_array()) {
									if ($rsHarga['waktu'] == "1") {
										$hargaSiang = $rsHarga['harga'];
									} else {
										$hargaMalam = $rsHarga['harga'];
									}
								}
							}
							
							$qCek = "SELECT waktu FROM booking WHERE id_gedung = '".$rsGedung['id']."' AND tgl = '$tgl'";
							if ($resCek = $koneksi->runQuery($qCek)) {
								if ($resCek->num_rows > 0) {
									while ($rsCek = $resCek->fetch_array()) {
										if ($rsCek['waktu'] == "1") {
											$hargaSiang = "Penuh";
										} else {
											$hargaMalam = "Penuh";
										}
									}
								}
							}
							
							if ($hargaSiang != "Penuh") {
								echo "<p>Siang Rp. ".number_format($hargaSiang, 0, ",", ".")." -> <a class='pesan-item' data-id='".$rsGedung['id']."' 
								data-nama='".$rsGedung['nama']."' data-idwaktu='1' data-waktu='Siang' data-harga='".$hargaSiang."' data-tgl='".$tgl."'>Pesan</a></p>";
							} else {
								echo "<p>Siang Penuh</p>";
							}
							
							if ($hargaMalam != "Penuh") {
								echo "<p>Malam Rp. ".number_format($hargaMalam, 0, ",", ".")." -> <a class='pesan-item' data-id='".$rsGedung['id']."' 
								data-nama='".$rsGedung['nama']."' data-idwaktu='2' data-waktu='Malam' data-harga='".$hargaMalam."' data-tgl='".$tgl."'>Pesan</a></p>";
							} else {
								echo "<p>Malam Penuh</p>";
							}
							
							echo "</div></div></div>";
							$i++;
						}
					}
					
				}
				break;
			case "simpan-booking":
				
				include "../../admin/inc/blob.php";
				$arr = array();
				
				if (isset($_POST['tgl']) && $_POST['tgl'] != "" && isset($_POST['idgedung']) && $_POST['idgedung'] != "" && 
				isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['alamat']) && $_POST['alamat'] != "" && 
				isset($_POST['provinsi']) && $_POST['provinsi'] != "" && isset($_POST['kota']) && $_POST['kota'] != "" && 
				isset($_POST['kodepos']) && $_POST['kodepos'] != "" && isset($_POST['telp']) && $_POST['telp'] != "" && 
				isset($_POST['waktu']) && $_POST['waktu'] != "" && isset($_POST['harga']) && $_POST['harga'] != "") {
					
					$tgl = $_POST['tgl'];
					$idpelanggan = $_SESSION['majt-id'];
					$idgedung = $_POST['idgedung'];
					$nama = $_POST['nama'];
					$alamat = $_POST['alamat'];
					$provinsi = $_POST['provinsi'];
					$kota = $_POST['kota'];
					$kodepos = $_POST['kodepos'];
					$telp = $_POST['telp'];
					$waktu = $_POST['waktu'];
					$harga = $_POST['harga'];
					$koneksi = new koneksi();
					
					$query = "INSERT INTO booking(tgl, id_pelanggan, id_gedung, nama_pemesan, alamat, provinsi, kota, kodepos, telp, waktu, harga, konfirmasi, acc) 
							VALUES('$tgl', '$idpelanggan', '$idgedung', '$nama', '$alamat', '$provinsi', '$kota', '$kodepos', '$telp', '$waktu', '$harga', '0', '0')";
					
					if ($result = $koneksi->runQuery($query)) {
						$arr['status']=TRUE;
						$arr['msg']="Pemesanan berhasil.. Silahkan melakukan pembayaran dan konfirmasi..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Pemesanan gagal.. Ada kesalahan dengan sistem..";
					}
					
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data pemesanan dengan lengkap..";
				}
				
				echo json_encode($arr);
				break;
		}
	}
?>