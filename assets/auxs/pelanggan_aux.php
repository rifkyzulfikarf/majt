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
				
				if ($result = $koneksi->runQuery("SELECT tgl, COUNT(id) FROM booking WHERE acc <> '2' GROUP BY tgl ASC")) {
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
							if (($i % 2) == 1) { echo "<div class='row'>";}
							if (($i % 2) == 1) { echo "<div class='col-sm-4 col-sm-offset-2'>"; } else { echo "<div class='col-sm-4'>"; }
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
							if (($i % 2) == 0) { echo "</div>";}
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
			case "daftar-pesanan":
				include "../../admin/inc/blob.php";
				
				$koneksi = new koneksi();
				$collect = array();
				$idPelanggan = $_SESSION['majt-id'];
				
				$query = "SELECT `booking`.`id`, `booking`.`tgl`, `booking`.`id_pelanggan`, `booking`.`id_gedung`, `booking`.`nama_pemesan`, 
						`booking`.`alamat`, `booking`.`provinsi`, `booking`.`kota`, `booking`.`kodepos`, `booking`.`telp`, `booking`.`waktu`, 
						`booking`.`harga`, `booking`.`konfirmasi`, `booking`.`acc`, `gedung`.`nama` FROM `booking` INNER JOIN `gedung` 
						ON (`booking`.`id_gedung` = `gedung`.`id`) WHERE `booking`.`id_pelanggan` = '$idPelanggan';";
				
				if ($result = $koneksi->runQuery($query)) {
					while ($rs = $result->fetch_array()) {
						
						if ($rs["konfirmasi"] == "0") {
							$aksi = "<a class='btn btn-default btn-sm btn-confirm' role='button' data-id='".$rs["id"]."'><i class='fa fa-check-square-o'></i></a> ";
						} else {
							$aksi = "";
						}
						
						if ($rs["acc"] == "0") {
							$acc = "Belum";
							$catering = "-";
						} elseif ($rs["acc"] == "1") {
							$acc = "Ya";
							
							if ($resCek = $koneksi->runQuery("SELECT COUNT(`booking_catering`.`id`), `catering`.`nama` FROM `booking_catering` INNER JOIN `catering` 
							ON (`booking_catering`.`id_catering` = `catering`.`id`) WHERE `booking_catering`.`id_booking` = '".$rs["id"]."'")) {
								$rsCek = $resCek->fetch_array();
								if ($rsCek[0] == 0) {
									$catering = "-";
									$aksi .= "<a class='btn btn-default btn-sm btn-show-catering' role='button' data-id='".$rs["id"]."' data-tgl='".$rs["tgl"]."'><i class='fa fa-cutlery'></i></a> ";
								} else {
									$catering = $rsCek[1];
								}
							}
							
						} else {
							$catering = "-";
							$acc = "Tidak";
						}
						
						$aksi .= "<a class='btn btn-default btn-sm btn-print' role='button' data-id='".$rs["id"]."'><i class='fa fa-print'></i></a>";
					
						$detail = array();
						array_push($detail, $rs["tgl"]);
						array_push($detail, $rs["nama_pemesan"]);
						array_push($detail, ($rs["waktu"]=="1")?$rs["nama"]." "."Siang":$rs["nama"]." "."Malam");
						array_push($detail, "Rp ".number_format($rs["harga"], 0, ",", "."));
						array_push($detail, $acc);
						array_push($detail, $catering);
						array_push($detail, $aksi);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
				break;
			case "simpan-konfirmasi":
				include "../../admin/inc/blob.php";
				$arr = array();
				
				if (isset($_POST['idpesan']) && $_POST['idpesan'] != "" && isset($_POST['tgl']) && $_POST['tgl'] != "" && 
				isset($_POST['bank']) && $_POST['bank'] != "" && isset($_POST['nama']) && $_POST['nama'] != "" && 
				isset($_POST['jml']) && $_POST['jml'] != "") {
					
					$idpesan = $_POST['idpesan'];
					$tgl = $_POST['tgl'];
					$bank = $_POST['bank'];
					$nama = $_POST['nama'];
					$jml = $_POST['jml'];
					$ket = (isset($_POST['ket']))?$_POST['ket']:"-";
					
					$koneksi = new koneksi();
					
					$query = "INSERT INTO konfirmasi(id_booking, tgl, bank, nama, jumlah, keterangan, img) VALUES('$idpesan', '$tgl', '$bank', '$nama', '$jml', '$ket', '-');";
					$query .= "UPDATE booking SET konfirmasi = '1' WHERE id = '$idpesan';";
					
					if ($result = $koneksi->runMultipleQueries($query)) {
						$arr['status']=TRUE;
						$arr['msg']="Konfirmasi berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Konfirmasi gagal.. Ada kesalahan dengan sistem..";
					}
					
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data konfirmasi dengan lengkap..";
				}
				
				echo json_encode($arr);
				break;
			case "show-catering":
				if (isset($_POST['tgl']) && $_POST['tgl'] != "" && isset($_POST['id']) && $_POST['id'] != "") {
					include "../../admin/inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					$tgl = $_POST['tgl'];
					
					$i = 1;
					
					$qCatering = "SELECT * FROM catering";
					
					if ($resCatering = $koneksi->runQuery($qCatering)) {
						while ($rsCatering = $resCatering->fetch_array()) {
							
							if (($i % 2) == 1) { echo "<div class='row'>";}
							if (($i % 2) == 1) { echo "<div class='col-sm-4 col-sm-offset-2'>"; } else { echo "<div class='col-sm-4'>"; }
							echo "<div class='thumbnail'>";
							echo "<img src='assets/images/catering/".$rsCatering['img']."' alt=''>";
							echo "<div class='caption'>";
							echo "<h3>".$rsCatering['nama']."</h3>";
							echo "<p>".$rsCatering['alamat']."</p>";
							echo "<p>".$rsCatering['telepon']."</p>";
							echo "<p>DP Rp. ".number_format($rsCatering['dp'], 0, ",", ".")."</p>";
							
							if ($rsCatering["link"] != "-") {
								echo "<p>Website <a href='".$rsCatering['link']."' target='blank'>".$rsCatering['link']."</a></p>";
							}
							
							if ($rsCatering["brosur"] != "-") {
								echo "<p>Brosur Harga <a href='assets/images/catering/brosur/".$rsCatering['brosur']."' target='blank'>Download</a></p>";
							}
							
							$qCek = "SELECT COUNT(id_catering) FROM jadwal_catering WHERE tgl = '$tgl' AND id_catering = '".$rsCatering['id']."'";
							if ($resCek = $koneksi->runQuery($qCek)) {
								$rsCek = $resCek->fetch_array();
								if ($rsCek[0] == 0) {
									echo "<p>Status : Tersedia -> <a class='pesan-catering' data-idbooking='".$id."' data-idcatering='".$rsCatering['id']."' data-namacatering='".$rsCatering['nama']."' data-tgl='".$tgl."'>Pesan</a></p>";
								} else {
									echo "<p>Status : Tidak tersedia pada tanggal pesan gedung</p>";
								}
							}
							
							echo "</div></div></div>";
							if (($i % 2) == 0) { echo "</div>";}
							$i++;
						}
					}
				}
				break;
			case "simpan-catering":
				include "../../admin/inc/blob.php";
				$arr = array();
				
				if (isset($_POST['idbooking']) && $_POST['idbooking'] != "" && isset($_POST['tgl']) && $_POST['tgl'] != "" && 
				isset($_POST['idcatering']) && $_POST['idcatering'] != "") {
					
					$idbooking = $_POST['idbooking'];
					$tgl = $_POST['tgl'];
					$idcatering = $_POST['idcatering'];
					
					$koneksi = new koneksi();
					
					$query = "INSERT INTO booking_catering(id_booking, id_catering) VALUES('$idbooking', '$idcatering');";
					$query .= "INSERT INTO jadwal_catering VALUES('$idcatering', '$tgl');";
					
					if ($result = $koneksi->runMultipleQueries($query)) {
						$arr['status']=TRUE;
						$arr['msg']="Simpan catering berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan catering gagal.. Ada kesalahan dengan sistem..";
					}
				}
				
				echo json_encode($arr);
				break;
		}
	}
?>